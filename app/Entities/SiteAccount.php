<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\SequenceTrait;

/**
 * App\Entities\SiteAccount
 *
 * @property string $id
 * @property int $balance
 * @property int $freeze
 * @property int $available
 * @property int $coupon
 * @property int $paid
 * @property int $income
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SiteAccount whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SiteAccount whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SiteAccount whereCoupon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SiteAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SiteAccount whereFreeze($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SiteAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SiteAccount whereIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SiteAccount wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SiteAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SiteAccount extends BaseModel
{

    protected $guarded = [];

    /**
     * 所属账户
     *
     * @author gengzhiguo@xiongmaojinfu.com
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function transform()
    {
        $fields = [
            'balance',
            'available',
            'freeze',
            'income',
            'paid'
        ];
        foreach ($fields as $field) {
            if (isset($this->{$field})) {
                $this->{$field} = fenToYuan($this->{$field});
            }
        }
        $fieldids=[
            'site_id',
        ];
        foreach ($fieldids as $fieldId) {
            if (isset($this->{$fieldId})) {
                $this->{$fieldId} = hashIdEncode($this->{$fieldId});
            }
        }
        return $this->toArray();
    }
}
