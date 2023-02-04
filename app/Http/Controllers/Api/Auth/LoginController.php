<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Traits\Auth\AuthenticatesUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Sponsor Authentication Api
 *
 * API for allowing sponsor authentication on the platform
 *
 * Class LoginController
 * @package App\Http\Controllers\Api\Auth\Sponsor
 */
class LoginController extends Controller
{
    use AuthenticatesUser;

  

    /**
     * Get User Data
     *
     * Get an authenticated user data
     * @authenticated
     *
     * @responseFile status=200 storage/responses/user.get.json
     *
     * @param Request $request
     * @return JsonResponse
     */
    final public function getUser(Request $request): JsonResponse
    {

        return response()->json([
            'status' => 'success',
            'data' => new UserResource($request->user()),
        ]);
    }
}
