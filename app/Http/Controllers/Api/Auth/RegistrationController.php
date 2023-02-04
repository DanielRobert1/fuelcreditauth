<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Traits\Auth\RegistersUser;

/**
 * @group User Registration Api
 *
 * API for allowing users to register on the platform
 *
 * @unauthenticated
 *
 * Class RegistrationController
 *
 * @package App\Http\Controllers\Api\Auth
 */
class RegistrationController extends Controller
{
    use RegistersUser;
}
