<?php

namespace App\Services\Log;

use App\Repositories\RequestExecutionRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PerformanceService
{
    /**
     * @var RequestExecutionRepository $requestExecutionRepository
     */
    protected RequestExecutionRepository $requestExecutionRepository;

    public function __construct(RequestExecutionRepository $requestExecutionRepository)
    {
        $this->requestExecutionRepository = $requestExecutionRepository;
    }

    public function logResponseTime(
        Request $request,
        Response $response
    ) {
        $data = [
            'method' => $request->method(),
            'path' => $request->path(),
            'seconds' => microtime(true) - LARAVEL_START,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'create_user' => auth()->user() ?? 0
        ];

        $this->requestExecutionRepository->insertResponseTime($data);
    }
}
