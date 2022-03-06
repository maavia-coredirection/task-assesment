<?php

namespace App\Http\Controllers;

use App\Constant;
use App\Http\Message;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Traits\LoginTrait;
class AuthController extends Controller
{
    use LoginTrait;
    /**
     * @param RegisterUserRequest $request
     * @return JsonResponse
     */
    public function signup(RegisterUserRequest $request):JsonResponse
    {

        $request->saveUser();
        return response()->json([Message::CREATE_USER], Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request)
    {


        if(!$this->validateEmailAndPassword($request)){
            return response()->json([
                'message' => Message::INVALID_EMAIL_PASSWORD
            ], Response::HTTP_UNAUTHORIZED);
        }

        $tokenResult = $this->createToken($request);

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => Constant::TOKEN_TYPE,
            'expires_at' => $this->expireToken($tokenResult)
        ]);
    }


    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }


}
