<?php

namespace App\Http\Controllers;

use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator ;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth ;
use App\Admin ;


class AdminAuthController extends Controller
{
    use GeneralTrait ;

    public function adminLogin(request $request)
    {
        try
        {
            $rules = [
                "email" => "required|exists:admins,email",
                "password" => "required"
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $credintials = $request->only(['email','password']);

            $token = Auth::guard('admin-api')->attempt($credintials) ;

            if(!$token)
            {
                return $this->returnError('E001','بيانات الدخول غير صحيحة');
            }
            else
            {
                $admin = Auth::guard('admin-api')->user();
                $admin->api_token = $token ;
                return $this->returnData('admin',$admin,'تم الدخول بنجاح','2001');
            }


        }

        catch (\Exception $ex)
        {
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }

    }

    public function logout(request $request)
    {
        $token = $request->header('auth-token');
        if($token)
        {
            try
            {
                JWTAuth::setToken($token)->invalidate();
            }
            catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e)
            {
                return $this->returnError('404','some thing went wrong');
            }
            return $this->returnSuccessMessage('logout has done successfully','E002');
        }
        else
        {
            return $this->returnError('404','some thing went wrong');
        }
    }


    public function userLogin(request $request)
    {
        try
        {
            $rules = [
                "email" => "required",
                "password" => "required"
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $credintials = $request->only(['email','password']);

            $token = Auth::guard('user-api')->attempt($credintials) ;

            if(!$token)
            {
                return $this->returnError('E001','بيانات الدخول غير صحيحة');
            }
            else
            {
                $user = Auth::guard('user-api')->user();
                $user->api_token = $token ;
                return $this->returnData('user',$user,'تم الدخول بنجاح','2001');
            }


        }

        catch (\Exception $ex)
        {
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }

    }


}
