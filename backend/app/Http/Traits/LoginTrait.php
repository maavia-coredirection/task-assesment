<?php

namespace App\Http\Traits;


use App\Constant;
use App\Http\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait LoginTrait {
    /**
     * @param Request $request
     * @return array
     */
    public function pluckEmailAndPassword(Request $request):array{
        return [
            "email"=>$request->email,
            "password"=>$request->password
        ];
    }

    public function validateEmailAndPassword(Request $request):bool{
        if(!Auth::attempt($this->pluckEmailAndPassword($request))){
            return false;
        }
        return true;

    }

    /**
     * @param Request $request
     * @return array
     */
    public function createToken(Request $request){
        $user = $request->user();
        $tokenData = $user->createToken(Constant::CREATE_TOKEN_STRING);
        $token = $tokenData->token;

        if ($request->remember_me){
            $token->expires_at = $this->tokenExpireAt();
        }
        $token->save();
        return $tokenData;

    }


    public function expireToken(object $tokenPayload):string{
       return Carbon::parse($tokenPayload->token->expires_at)->toDateTimeString();
    }

    public function tokenExpireAt():string{
        return Carbon::now()->addWeeks(1);
    }

}
