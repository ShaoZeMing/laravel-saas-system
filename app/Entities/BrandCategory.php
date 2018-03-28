<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\BrandCategory
 *
 * @property int $brand_id
 * @property int $cat_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\BrandCategory whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\BrandCategory whereCatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\BrandCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\BrandCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BrandCategory extends Model implements Transformable
{
    use TransformableTrait;
    public $table='brand_categories';
    protected $guarded = [];

}
