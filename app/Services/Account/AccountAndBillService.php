<?php


namespace App\Services\Account;
use App\Entities\User;
use App\Entities\UserBill;
use App\Repositories\UserAccountRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\MessageBag;

/**
 * Class UserAccountService
 * @package App\Services\Account
 */
class AccountAndBillService
{

    private static  $bizType = [
        'merchant',
        'user',
        'site',
        'worker',
        ];
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
    /**
     * 资金账户和流水处理
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $userId
     * @param $amount
     * @param Model $model
     * @param $billType
     * @return bool
     */
    public static function createBillAndUpdateAccount($id,$uidType,$amount,$billType, Model $model, $desc='')
    {

        if(!in_array($uidType,self::$bizType)){
            throw new \Exception('没有这个uidType类型:['.$uidType.']');
        }

        \Log::notice('当前用户账户处理start',[__METHOD__,$id,$uidType,$amount,$billType,$model]);
        $service = 'App\\Services\\Account\\'.ucfirst($uidType).'AccountService';
        switch ($billType){
            //线上增加账户资金
            case self::INCOME:
                $res = $service::increment($id,$amount,$model, $desc);
                break;
            //线下增加账户资金
            case self::OFFLINE_INCOME:
                $res = $service::offlineIncrement($id,$amount,$model, $desc);
                break;
            //其他退款账户资金
            case self::REFUND:
                $res = $service::otherIncrement($id,$amount,$model, $desc);
                break;
            //其他扣款减少账户资金
            case self::DEDUCTIONS:
                $res = $service::otherDecrement($id,$amount,$model, $desc);
                break;
            case self::PAYOUT:
                //线上支出
                $res = $service::decrement($id,$amount,$model, $desc);
                break;
            case self::OFFLINE_WITHDRAWALS:
                //线下提现
                $res = $service::offlineRefund($id,$amount,$model, $desc);
                break;
            case self::ONLINE_WITHDRAWALS:
                //线上提现
                $res = $service::onlineRefund($id,$amount,$model, $desc);
                break;
            case self::ORDER_INCOME:
                //线下提现
                $res = $service::orderIncrement($id,$amount,$model, $desc);
                break;
            case self::ORDER_DEDUCTIONS:
                //线上提现
                $res = $service::orderDecrement($id,$amount,$model, $desc);
                break;
            default:
                throw new \Exception('没有这个billType类型:['.$billType.']');
        }
        \Log::notice('当前用户账户处理end',[__METHOD__,$id,$uidType,$amount,$billType,$res]);
        return $res;
    }



}
