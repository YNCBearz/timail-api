<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Throwable;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param Throwable $th
     * @return JsonResponse
     */
    public function errorHandling(Throwable $th): JsonResponse
    {
        Log::error($th);

        return response()->json(
            [
                'message' => 'Something went wrong',
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
