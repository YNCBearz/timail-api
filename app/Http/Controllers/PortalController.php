<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
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
     * LoginController constructor.
     * @param SignUpService $signUpService
     */
    public function __construct(SignUpService $signUpService)
    {
        $this->signUpService = $signUpService;
    }

    /**
     * @param SignUpRequest $request
     * @return JsonResponse
     */
    public function signUp(SignUpRequest $request): JsonResponse
    {
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
     * @param SignInRequest $request
     * @return JsonResponse
     */
    public function signIn(SignInRequest $request): JsonResponse
    {
        /**
         * NOTE.
         * We had check User & password in SignInRequest.
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
}
