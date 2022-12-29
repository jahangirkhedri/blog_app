<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\RegisterFormRequest;
use App\Models\User;


class RegisterController extends BaseController
{
    public function register(RegisterFormRequest $request)
    {

        $input = $request->all();

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $success['token'] = $user->createToken('MyApp')->plainTextToken;

        $success['name'] = $user->name;


        return $this->sendResponse($success, 'User register successfully.');

    }
}
