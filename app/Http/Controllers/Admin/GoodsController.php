<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GoodsRequest;
use App\Models\Category;
use App\Models\Good;
use Illuminate\Http\Request;

class GoodsController extends BaseController
{
    /**
     * 商品列表
     */
    public function index()
    {
        //
    }

    /**
     * 添加商品
     */
    public function store(GoodsRequest $request)
    {
        //对分类进行一下检查， 只能使用3级分类， 并且不能被禁用
        $category = Category::find($request->category_id);
        if(!$category){
            return $this->response->errorBadRequest('分类不存在');
        }
        //追加当前登录用户ID
        $request->offsetSet('user_id',auth('api')->id());
        Good::create($request->all());
        return $this->response->created();
    }

    /**
     * 商品详情
     */
    public function show($id)
    {
        //
    }

    /**
     * 更新商品
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 是否上架
     */
    public function isOn()
    {

    }
    /**
     * 是否推荐
     */
    public function isRecommend()
    {

    }
}
