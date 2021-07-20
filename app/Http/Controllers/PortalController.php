<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\Portal\SignUpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class PortalController extends Controller
{
    /**
     * @var SignUpService $signUpService
     */
    protected SignUpService $signUpService;

    /**
     * PortalController constructor.
     * @param SignUpService $signUpService
     */
    public function __construct(SignUpService $signUpService)
    {
        $this->signUpService = $signUpService;
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        /**
         * NOTE.
         * We had check unique email in RegisterRequest.
         */
        try {
            DB::beginTransaction();
            $user = $this->signUpService->createNewAccount($request);
            DB::commit();

            return response()->json(
                [
                    'data' => [
                        'user' => $user,
                    ],
                ],
                Response::HTTP_CREATED
            );
        } catch (Throwable $th) {
            DB::rollback();

            return $this->errorHandling($th);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        /**
         * NOTE.
         * We had check User & password in LoginRequest.
         */
        $credentials = $request->validated();
        $token = auth()->attempt($credentials);

        return $this->createNewToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     * @return JsonResponse
     */
    protected function createNewToken(string $token): JsonResponse
    {
        return response()->json(
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'data' => [
                    'user' => auth()->user(),
                ],
            ]
        );
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(
            ['message' => 'User successfully signed out'],
            Response::HTTP_RESET_CONTENT
        );
    }
}
