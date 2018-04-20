<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\SequenceTrait;


/**
 * App\Entities\MerchantBill
 *
 * @property string $id
 * @property int $merchant_id
 * @property int $balance
 * @property int $freeze
 * @property int $available
 * @property int $coupon
 * @property int $paid
 * @property int $income
 * @property int $amount
 * @property int $billable_id
 * @property string $billable_type
 * @property int $biz_type
 * @property string $biz_comment
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchantBill whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchantBill whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchantBill whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchantBill whereBillableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchantBill whereBillableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchantBill whereBizComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchantBill whereBizType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchantBill whereCoupon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchantBill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchantBill whereFreeze($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchantBill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchantBill whereIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchantBill whereMerchantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchantBill wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MerchantBill whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MerchantBill extends BaseModel
{
    protected $guarded = [];


    public function merchant(){
        return $this->belongsTo(Merchant::class);
    }

    /**
     * 支出
     */
    const PAYOUT = -1;
    /**
     * 充值
     */
    const INCOME = 1;
    /**
     * 冻结
     */
    const FREEZE = -2;
    /**
     * 解冻
     */
    const UNFREEZE = 2;

    /**
     * 退款
     */
    const REFUND = 3;

    /**
     * 扣款
     */
    const DEDUCTIONS = -3;

    /*线下充值*/
    const OFFLINE_INCOME = 5;


    /*线下提现*/
    const OFFLINE_WITHDRAWALS = -5;

    /*线上提现*/
    const ONLINE_WITHDRAWALS = -6;
    /**
     * 工单获得+
     */
    const ORDER_INCOME = 10;

    /**
     * 工单退还-
     */
    const ORDER_DEDUCTIONS = -10;

    public static $bizComments = [
        self::PAYOUT => '支付',
        self::INCOME => '充值',
        self::FREEZE => '资金冻结',
        self::UNFREEZE => '资金解冻',
        self::REFUND => '退款',
        self::DEDUCTIONS => '扣款',
        self::OFFLINE_INCOME => '线下充值',
        self::OFFLINE_WITHDRAWALS => '线下提现',
        self::ONLINE_WITHDRAWALS => '线上提现',
        self::ORDER_INCOME => '工单获得',
        self::ORDER_DEDUCTIONS => '工单退回',
    ];

    public static $symbol = [
        '1'  => '＋',
        '-1' => '－',
        '2'  => '＋',
        '-2' => '－',
        '3'  => '＋',
        '-3'  => '－',
        '5'  => '＋',
        '-5'  => '－',
        '-6'  => '－',
        '10'  => '＋',
        '-10'  => '－',
    ];

    protected $rechargeState = [
        '-1' => '关闭',
        '0'  => '未处理',
        '1'  => '处理中',
        '2'  => '成功',
        '5'  => '线下充值',
    ];

    protected $rechargeResource = [
        'alipay'   => '支付宝充值',
        'wechat'   => '微信充值',
        'recharge' => '线下充值',
    ];


    public function billable()
    {
        return $this->morphTo();
    }
    public function transform()
    {
        $fields = [
            'balance',
            'freeze',
            'available',
            'amount'
        ];
        foreach ($fields as $field) {
            if (isset($this->{$field})) {
                $value = intval($this->{$field});
                $this->{$field} = formatMoney(fenToYuan($value));
            }
        }
        /*拼接显示支付或者收入金额的符号 */
        $this->amount_txt = self::$symbol[$this->biz_type].$this->amount;

        $idFields = [
            'id',
            'merchant_id',
            'billable_id',
        ];
        foreach ($idFields as $idField) {
            if (isset($this->{$idField})) {
                $this->{$idField} = hashIdEncode($this->{$idField});
            }
        }
        return $this->toArray();
    }
}
