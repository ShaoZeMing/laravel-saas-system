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
    public function cats(){
        return $this->belongsToMany(Category::class,'category_standards','standard_id','cat_id');
    }

    /**
     * 获取分类下所有的产品
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'standard_id');
    }




    public function transform()
    {

    }
}
