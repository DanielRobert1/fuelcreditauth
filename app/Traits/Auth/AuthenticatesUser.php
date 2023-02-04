<?php


namespace App\Traits\Auth;


use App\Events\Auth\Authenticated;
use App\Events\Auth\SignedOut;
use App\Events\Auth\SignedOutAllDevices;
use App\Models\User;
use App\Traits\NeedsDeviceAgent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;

trait AuthenticatesUser
{
    use NeedsDeviceAgent, ApiResponse;
    
    /**
     * @param Request $request
     * @return array
     */
    private function validateLogin(Request $request): array
    {
        return $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * @param Request $request
     * @param Model|User $user
     * @param array $ability
     * @return string
     */
    private function authenticate(Request $request, Model $user): string
    {
        $device = $this->getUserActiveDevice() ?? UNKNOWN_DEVICE_TOKEN;

        $token = $user->createToken($device)->plainTextToken;

        event(new Authenticated($user, [
            'user_agent' => $request->header('user-agent'),
            'device' => $device,
            'ip' => $request->ip(),
            'login_at' => now(),
        ]));

        return $token;
    }

    /**
     * Sign In
     *
     * Authenticate a guest user
     * @unauthenticated
     *
     * Sign in a guest user
     *
     * @bodyParam email string required The email of the user
     * @bodyParam password string required The password of the user
     *
     * @responseFile status=200 storage/responses/register.json
     * @responseFile status=422 storage/responses/errors/validation.json
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function login(Request $request, User $user): JsonResponse
    {
        $fields = $this->validateLogin($request);

        $request_user = $user->where('email', $fields['email'])
            ->first();

        if(!$request_user || !Hash::check($fields['password'], $request_user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials!'
            ], HTTP_STATUS_UNAUTHENTICATED);
        }

        $token = $this->authenticate($request, $request_user);
        return $this->sendResponse([
            'user' => new UserResource($request_user),
            'token' => $token,
        ],'User Authenticated!');
    }

    /**
     * Sign Out
     *
     * Sign out an authenticated user from current active device
     * @authenticated
     *
     * @response {
     * "status" => "success",
     * "message" => "Signed out!"
     * }
     *
     * @param Request $request
     * @return JsonResponse
     */
    final public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        $requestData = [
            'device' => $this->getUserActiveDevice() ?? UNKNOWN_DEVICE_TOKEN,
            'last_activity_at' => now(),
        ];

        $request->user()->currentAccessToken()->delete();

        event(new SignedOut($user, $requestData));

        return $this->sendSuccess('Signed out!');
    }

    /**
     * Sign Out (All Devices)
     *
     * Sign out an authenticated user from all signed in devices
     * @authenticated
     *
     * @response {
     * "status" => "success",
     * "message" => "Signed out of all devices!"
     * }
     *
     * @param Request $request
     * @return JsonResponse
     */
    final public function logoutAllDevices(Request $request): JsonResponse
    {
        $this->signOutAllDevices($request);

        return $this->sendSuccess('Signed out of all devices!');
    }

    /**
     * @param Request $request
     */
    private function signOutAllDevices(Request $request): void
    {
        $user = $request->user();

        $user->tokens()->delete();

        event(new SignedOutAllDevices($user));
    }

}
