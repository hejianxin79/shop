<?php

use App\Models\Category;

/**
 * 查询所有分类
 */
if(!function_exists('categoryTree')){
    function categoryTree($status = false)
    {
        return Category::select(['id','pid','name', 'status', 'level'])  //查一级
            ->when($status !== false, function($query) use ($status){
                $query->where('status', $status);
            })
            ->where('pid',0)
            ->with([
                //查二级
                'children' => function($query) use ($status){
                    $query->select(['id','pid','name','status','level'])->when($status !== false, function($query) use ($status){
                        $query->where('status', $status);
                    });
                },
                //查三级
                'children.children' => function($query) use ($status){
                    $query->select(['id','pid','name','status','level'])->when($status !== false, function($query) use ($status){
                        $query->where('status', $status);
                    });
                }
            ])
            ->get();
    }
}
/**
 * 缓存可用分类树
 */
if(!function_exists('cache_category')){
    function cache_category()
    {
        try {
           return cache()->rememberForever('cache_category', function () {
                return categoryTree(1);
            });
        } catch (Exception $e) {
        }
    }
}

/**
 * 缓存所有分类
 */
if(!function_exists('cache_category_all')){
    function cache_category_all()
    {
        try {
            return cache()->rememberForever('cache_category_all', function () {
                return categoryTree();
            });
        } catch (Exception $e) {
        }
    }
}

/**
 * 清空分类缓存
 */
if(!function_exists('forget_cache_category')){
    function forget_cache_category()
    {
        cache()->forget('cache_category');
        cache()->forget('cache_category_all');
    }
}
