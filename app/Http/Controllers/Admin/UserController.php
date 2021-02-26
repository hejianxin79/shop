<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *  用户列表
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');

        $users = User::when($name, function($query) use ($name){
                $query->where('name', 'like', "%$name%");
            })
            ->when($email, function($query) use ($email){
                $query->where('email', $email);
            })
            ->paginate(2);
        //使用transformer进行数据过滤
        return $this->response->paginator($users, new UserTransformer());
    }


    /**
     * Display the specified resource.
     *用户详情
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->response->item($user, new UserTransformer());
    }

    /**
     * 禁用|启用用户
     */
    public function lock(User $user)
    {
        $user->is_locked = $user->is_locked == 0 ? 1 : 0;
        $user->save();
        return $this->response->noContent();
    }


}
