<?php

namespace App\Traits\Auth;

use App\Events\Auth\Authenticated;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Traits\NeedsDeviceAgent;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Validation\Validator as ValidatorInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

trait RegistersUser
{
    use NeedsDeviceAgent, ApiResponse;

    /**
     * @var string|null
     */
    private $token = null;

    /**
     * @var User|null
     */
    private $user = null;

    /**
     * Registration
     *
     * This endpoint is responsible for registering a new user
     *
     * @bodyParam name string required The name of the user
     * @bodyParam username string required The username of the user. Must be unique
     * @bodyParam email string required The email of the user. Must be unique
     * @bodyParam phone_number string The user's phone number
     * @bodyParam timezone string The user timezone (defaults to UTC)
     * @bodyParam referred_by string The username of referrer (if user was referred)
     * @bodyParam role string required The role of the user. Must be `gamer` or `tournament_organizer`
     * @bodyParam password string required User password must be at least 8 characters
     * @bodyParam password_confirmation string required must match the input password
     *
     * @responseFile status=201 storage/responses/register.json
     * @responseFile status=422 storage/responses/errors/validation.json
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function register(Request $request): JsonResponse
    {
        $data = $request->all();

        $this->validator($data)->validate();

        $this->registerUser($data);

        return $this->sendResponse([
            'status' => 'success',
            'message' => 'User account registered!',
            'data' => [
                'user' => new UserResource($this->getRegisteredUser()),
                'token' => $this->getToken(),
            ],
        ], HTTP_STATUS_CREATED);
    }

    /**
     * @return User|null
     */
    public function getRegisteredUser(): ?User
    {
        return $this->user;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     *
     * @return ValidatorInterface
     */
    private function validator(array $data): ValidatorInterface
    {

        return Validator::make($data, [
            'name' => ['bail', 'required', 'string', 'max:255'],
            'email' => ['bail', 'required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['bail', 'required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     *
     * @return User|Model
     */
    private function create(array $data): User
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return User::query()->create($data);
    }

    /**
     * @param array $data
     */
    private function registerUser(array $data): void
    {
        $this->user = $this->create($data);

        if (!empty($data['phone_number'])) {
            $this->user->profile()->create(['phone_number' => $data['phone_number']]);
        }

        $device = $this->getUserActiveDevice();

        $this->token = $this->user
            ->createToken($device)
            ->plainTextToken;

        event(new Registered($this->user));

        event(new Authenticated($this->user, [
            'user_agent' => request()->header('user-agent'),
            'device' => $device,
            'ip' => request()->ip(),
            'login_at' => now(),
        ]));
    }

    /**
     * @return string|null
     */
    private function getToken(): ?string
    {
        return $this->token;
    }
}
