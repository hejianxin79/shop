<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Doctrine\Inflector\Rules\Transformations;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->input('type');
        if($type == 'all'){
            return cache_category_all();  //自定义辅助函数
        }else{
            return cache_category();
        }

    }

    /**
     * 添加分类
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inserData = $this->checkInput($request);
        if(!is_array($inserData)){
            return $inserData;
        }
        // 计算level级别

        //批量赋值
        Category::create($inserData);
        //清空缓存由CategoryObserver观察者进行
        return $this->response->created();
    }

    /**
     * 分类详情
     *
     * @param  Category $category  类型注入
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * 更新分类
     *
     * @param \Illuminate\Http\Request $request
     * @param Category $category  依赖注入
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $updateData = $this->checkInput($request);
        if(!is_array($updateData)){
            return $updateData;
        }
        // 计算level级别

        //批量赋值
        $category->update($updateData);
        //清空缓存由CategoryObserver观察者进行
        return $this->response->noContent();
    }

    /**
     * 验证输入的分类数据
     * @param Request $request
     * @return array|void
     */
    protected function checkInput(Request $request)
    {
        $request->validate([
            'name' => 'required|max:16',
        ], [
            'name.required' => '请填写分类名称',
        ]);
        $pid = $request->input('pid', 0);
        $level = $pid == 0 ? 1 : (Category::find($pid)->level + 1);
        if($level > 3){
            return $this->response->errorBadRequest('不能超过3级分类');
        }
        return ['name'=>$request->input('name'),'pid'=>$pid, 'level'=>$level];
    }


    /**
     *分类禁用or启用
     * @param Category $category
     */
    public function status(Category $category)
    {
        $category->status = $category->status == 1 ? 0 : 1;
        $category->save();
        //清空缓存由CategoryObserver观察者进行
        return $this->response->noContent();
    }
}
