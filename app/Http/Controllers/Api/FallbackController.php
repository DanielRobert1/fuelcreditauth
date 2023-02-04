<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class FallbackController extends Controller
{

    use ApiResponse;
    /**
     * @return JsonResponse
     */
    final public function missing(): JsonResponse
    {
        return $this->sendResponse([
            'status' => 'error',
            'message' => "The resource you're looking for was not found",
        ], HTTP_STATUS_NOT_FOUND);
    }
}
