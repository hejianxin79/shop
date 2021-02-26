<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    use HasFactory;

    /**
     * 提交的字段强制类型转换
     * @var array
     */
    protected $casts = [
        'pics' => 'array',
    ];

    //可批量填充的字段
    protected $fillable = [
        'user_id',
        'category_id',
        'description',
        'price',
        'stock',
        'cover',
        'pics',
        'is_on',
        'is_recommend',
        'details'
    ];
}
