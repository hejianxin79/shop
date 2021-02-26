<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\BaseRequest;
use Illuminate\Http\Request;

class LoginController extends BaseController
{
    /**
     * 用户登录
     * LoginRequest 表单数据验证
     * @param LoginRequest $request
     * @return \Dingo\Api\Http\Response|void
     */
    public function login(LoginRequest $request): \Dingo\Api\Http\Response
    {

        $credentials = \request(['email', 'password']);
        if(!$token = auth('api')->attempt($credentials)){
            return $this->response->errorUnauthorized();
        }
        //检查用户状态
        $user = auth('api')->user();
        if($user->is_locked == 1){
            return $this->response->errorForbidden('用户已禁用');
        }
        return $this->respondWithToken($token);
    }

    /**
     * 获取个人信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * 退出登录
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();
        return $this->response->noContent();
    }

    /**
     * 刷新Token
     * @return \Dingo\Api\Http\Response
     */
    public function refresh(): \Dingo\Api\Http\Response
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * 格式化返回Token
     * @param $token
     * @return \Dingo\Api\Http\Response
     */
    protected function respondWithToken($token): \Dingo\Api\Http\Response
    {
        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 6000
        ]);
    }
}
