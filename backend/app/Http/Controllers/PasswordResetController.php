<?php

namespace App\Http\Controllers;

use App\Http\Message;
use App\Http\Requests\PasswordResetEmailRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\Models\User;
use App\Models\PasswordReset;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
class PasswordResetController extends Controller
{
    //

    public function create(PasswordResetEmailRequest $request)
    {
        if (!$request->findUserEmail()){
            return response()->json(['message' => Message::USER_NOT_FOUND_AGAINST_EMAIL], Response::HTTP_NOT_FOUND);
        }

        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $request->findUserEmail()->email],
            [
                'email' => $request->findUserEmail()->email,
                'token' => $this->generateRandomToken()
            ]
        );
        if ($request->findUserEmail() && $passwordReset)
            $request->findUserEmail()->notify(
                new PasswordResetRequest($passwordReset->token)
            );
        return response()->json([
            'message' => Message::RESET_PASSWORD_EMAIL
        ]);
    }

    /**
     * @return string
     */
    public function generateRandomToken():string{
        return Str::random(60);
    }


    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();
        if(!$passwordReset){
            return response()->json(['message' => Message::INVALID_RESET_LINK], Response::HTTP_NOT_FOUND);
        }

        if (Carbon::parse($passwordReset->created_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json(['message' => Message::INVALID_RESET_LINK], Response::HTTP_NOT_FOUND);
        }
        return response()->json($passwordReset);
    }


    /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(UpdatePasswordRequest $request)
    {

        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();
        if (!$passwordReset){
            return response()->json(['message' => Message::INVALID_PASSWORD_UPDATE_TOKEN], Response::HTTP_NOT_FOUND);
        }

        $user = User::where('email', $passwordReset->email)->first();
        if (!$user){
            return response()->json(['message' => Message::USER_NOT_FOUND_AGAINST_EMAIL], Response::HTTP_NOT_FOUND);
        }
        $user->password = $request->password;
        $user->update();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess($passwordReset));
        return response()->json($user);
    }



}
