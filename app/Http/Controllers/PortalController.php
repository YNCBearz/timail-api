<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUpRequest;
use App\Services\Portal\SignUpService;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PortalController extends Controller
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
            DB::beginTransaction();
            $user = $this->signUpService->createNewAccount($request);
            DB::commit();

            return response()->json(['data' => $user], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollback();

            return $this->errorHandling($th);
        }
    }
}
