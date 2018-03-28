<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\SequenceTrait;


/**
 * App\Entities\MerchantCategorie
 *
 * @property int $merchant_id
 * @property int $cat_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchantCategory whereCatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchantCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchantCategory whereMerchantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchantCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MerchantCategory extends Model implements Transformable
{
    use TransformableTrait;
    public $table='merchant_categories';
    protected $guarded = [];

}
