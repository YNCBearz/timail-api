<?php

namespace App\Http\Middleware;

use App\Services\Log\PerformanceService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MeasureResponseTime
{
    /**
     * @var PerformanceService $performanceService
     */
    protected PerformanceService $performanceService;

    public function __construct(PerformanceService $performanceService)
    {
        $this->performanceService = $performanceService;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Add response time as an HTTP header. For better accuracy ensure this middleware
        // is added at the end of the list of global middlewares in the Kernel.php file
        if ((defined('LARAVEL_START') && $response instanceof Response)) {
            $response->headers->add(['X-RESPONSE-TIME' => microtime(true) - LARAVEL_START]);
        }

        return $response;
    }

    /**
     * Perform any final actions for the request lifecycle.
     *
     * @param Request $request
     * @param Response $response
     */
    public function terminate(Request $request, Response $response)
    {
        // At this point the response has already been sent to the browser so any
        // modification to the response (such adding HTTP headers) will have no effect
        if (defined('LARAVEL_START')) {
            $this->performanceService->logResponseTime($request, $response);
        }
    }
}
