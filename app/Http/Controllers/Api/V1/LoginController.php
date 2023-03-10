<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    public function login(LoginFormRequest $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();

            $success['token'] = $user->createToken('MyApp')->plainTextToken;

            $success['name'] = $user->name;


            return $this->sendResponse($success, 'User login successfully.');

        } else {

            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);

        }

    }
}
