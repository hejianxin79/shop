<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Dingo\Api\Http\Response;
use Faker\Provider\Base;
use Illuminate\Http\Request;

class RegisterController extends BaseController
{
    /**
     * 用户注册
     * @param RegisterRequest $request
     * @return Response
     */
    public function store(RegisterRequest $request): Response
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();
        return $this->response->created();
    }
}
