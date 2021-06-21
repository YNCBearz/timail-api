<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUpRequest;
use App\Services\Login\SignUpService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @var SignUpService
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
     */
    public function signUp(SignUpRequest $request)
    {
        try {
            $user = $this->signUpService->createNewAccount($request);

            return response()->json(['data' => $user]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
