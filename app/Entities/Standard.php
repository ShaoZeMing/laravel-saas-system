<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Standard  extends BaseModel
{

    protected $guarded = [];


    /**
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function merchants(){
        return $this->belongsToMany(Merchant::class,'merchant_standards','standard_id','merchant_id');
    }

    /**
     * 获取分类
     */
    public function cat()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }


    /**
     * 获取分类
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }




    public function transform()
    {

    }
}
