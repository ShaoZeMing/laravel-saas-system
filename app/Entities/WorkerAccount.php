<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\SequenceTrait;

/**
 * App\Entities\WorkerAccount
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WorkerAccount whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WorkerAccount whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WorkerAccount whereCoupon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WorkerAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WorkerAccount whereFreeze($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WorkerAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WorkerAccount whereIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WorkerAccount wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\WorkerAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WorkerAccount extends BaseModel
{

    protected $guarded = [];
    /**
     * 所属账户
     *
     * @author gengzhiguo@xiongmaojinfu.com
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function worker()
    {
        return $this->belongsTo(Worker::class);
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
            'worker_id',
        ];
        foreach ($fieldids as $fieldId) {
            if (isset($this->{$fieldId})) {
                $this->{$fieldId} = hashIdEncode($this->{$fieldId});
            }
        }
        return $this->toArray();
    }
}
