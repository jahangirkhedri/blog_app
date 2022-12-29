<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class RegisterController extends BaseController
{
    public function register(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'name' => 'required',

            'email' => 'required|email',

            'password' => 'required',

            'password_confirmation' => 'required|same:password',

        ]);


        if ($validator->fails()) {

            return $this->sendError('Validation Error.', $validator->errors());

        }


        $input = $request->all();

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $success['token'] = $user->createToken('MyApp')->plainTextToken;

        $success['name'] = $user->name;


        return $this->sendResponse($success, 'User register successfully.');

    }
}
