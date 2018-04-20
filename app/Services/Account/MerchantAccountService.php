<?php
/**
 *  MerchantAccountService.php
 *
 * @author gengzhiguo@xiongmaojinfu.com
 * $Id: MerchantAccountService.php 2017-06-21 下午2:35 $
 */


namespace App\Services\Account;

use App\Entities\MerchantBill;
use App\Repositories\MerchantAccountRepositoryEloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MerchantAccountService
 * @package App\Services\Account
 */
class MerchantAccountService
{

    /**
     * 冻结账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $merchantId
     * @param $amount
     * @param Model $model
     * @param $bizType
     * @return bool
     */
    public static function freeze($merchantId, $amount, Model $model, $bizType, $desc = '')
    {
        $bizType = 'FREEZE_' . strtoupper('freeze_fee');
        $bizTypeValue = constant(sprintf('%s::%s', MerchantBill::class, $bizType));

        if ($amount == 0) {
            return true;
        }
        $merchantAccountModel = app(MerchantAccountRepositoryEloquent::class)->freeze($merchantId, $amount);
        $billData = $merchantAccountModel->toArray();
        self::createBill($model, $billData, $bizTypeValue, $amount, $desc);

        return $merchantAccountModel;
    }


    /**
     * 减去账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $merchantId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function decrement($merchantId, $amount, Model $model, $desc = '')
    {
        $merchantAccountModel = app(MerchantAccountRepositoryEloquent::class)->decrement($merchantId, $amount);
        $billData = $merchantAccountModel->toArray();
        self::createBill($model, $billData, MerchantBill::PAYOUT, $amount, $desc);
        return $merchantAccountModel;
    }

    /**
     * 工单退还资金减去账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $merchantId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function orderDecrement($merchantId, $amount, Model $model, $desc = '工单退还资金')
    {
        $merchantAccountModel =  app(MerchantAccountRepositoryEloquent::class)->decrement($merchantId, $amount);
        $billData = $merchantAccountModel->toArray();
        self::createBill($model, $billData, MerchantBill::ORDER_DEDUCTIONS, $amount, $desc);
        return $merchantAccountModel;
    }

    /**
     * 扣款减去账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $merchantId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function otherDecrement($merchantId, $amount, Model $model, $desc = '')
    {
        $merchantAccountModel = app(MerchantAccountRepositoryEloquent::class)->decrement($merchantId, $amount);
        $billData = $merchantAccountModel->toArray();
        self::createBill($model, $billData, MerchantBill::DEDUCTIONS, $amount, $desc);
        return $merchantAccountModel;
    }


    /**
     * 解冻账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $merchantId
     * @param $amount
     * @param Model $model
     * @param $bizType
     * @return bool
     */
    public static function unfreeze($merchantId, $amount, Model $model, $bizType, $desc = '')
    {
        if ($amount == 0) {
            return true;
        }
        $merchantAccountModel = app(MerchantAccountRepositoryEloquent::class)->unfreeze($merchantId, $amount);
        $billData = $merchantAccountModel->toArray();
        self::createBill($model, $billData, $bizType, $amount, $desc);
        return $merchantAccountModel;
    }


    /**
     * 增加账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $merchantId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function increment($merchantId, $amount, Model $model, $desc = '')
    {
        $merchantAccountModel = app(MerchantAccountRepositoryEloquent::class)->increment($merchantId, $amount);
        $billData = $merchantAccountModel->toArray();
        self::createBill($model, $billData, MerchantBill::INCOME, $amount, $desc);
        return $merchantAccountModel;
    }


    /**
     * 工单收入增加账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $merchantId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function orderIncrement($merchantId, $amount, Model $model, $desc = '工单收入')
    {
        $merchantAccountModel =  app(MerchantAccountRepositoryEloquent::class)->increment($merchantId, $amount);
        $billData = $merchantAccountModel->toArray();
        self::createBill($model, $billData, MerchantBill::ORDER_INCOME, $amount, $desc);
        return $merchantAccountModel;
    }

    /**
     * 线下增加账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $merchantId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function offlineIncrement($merchantId, $amount, Model $model, $desc = '')
    {
        $merchantAccountModel = app(MerchantAccountRepositoryEloquent::class)->increment($merchantId, $amount);
        $billData = $merchantAccountModel->toArray();
        self::createBill($model, $billData, MerchantBill::OFFLINE_INCOME, $amount, $desc);
        return $merchantAccountModel;
    }


    /**
     * 退款增加账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $merchantId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function otherIncrement($merchantId, $amount, Model $model, $desc = '')
    {
        $merchantAccountModel = app(MerchantAccountRepositoryEloquent::class)->increment($merchantId, $amount);
        $billData = $merchantAccountModel->toArray();
        self::createBill($model, $billData, MerchantBill::REFUND, $amount, $desc);
        return $merchantAccountModel;
    }


    /**
     * 创建商户资金账户流水
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param Model $model
     * @param array $billData
     * @param $bizType
     * @param $amount
     * @throws \Exception
     */
    public static function createBill(Model $model, array $billData, $bizType, $amount, $desc = '')
    {
        // 写一条商家资金流水记录
        if (!method_exists($model, 'merchantBills')) {
            throw new \Exception('该对象不包含merchantBills方法');
        }
        $billData['biz_type'] = $bizType;
        $billData['biz_comment'] = MerchantBill::$bizComments[$bizType];
        $billData['amount'] = $amount;
        $billData['desc'] = $desc;
        $billSaved = $model->merchantBills()->save(new MerchantBill($billData));
        if (!$billSaved) {
            throw new \Exception('添加商家流水记录失败');
        }
    }


    /**
     * 线上提现,清理账户余额
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $merchantId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function onlineRefund($merchantId, $amount, Model $model, $desc = '')
    {
        $merchantAccountModel = app(MerchantAccountRepositoryEloquent::class)->decrement($merchantId, $amount);
        $billData = $merchantAccountModel->toArray();
        self::createBill($model, $billData, MerchantBill::ONLINE_WITHDRAWALS, $amount, $desc);
        return $merchantAccountModel;
    }


    /**
     * 线下提现,清理账户余额
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $merchantId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function offlineRefund($merchantId, $amount, Model $model, $desc = '')
    {
        $merchantAccountModel = app(MerchantAccountRepositoryEloquent::class)->decrement($merchantId, $amount);
        $billData = $merchantAccountModel->toArray();
        self::createBill($model, $billData, MerchantBill::OFFLINE_WITHDRAWALS, $amount, $desc);
        return $merchantAccountModel;
    }
}
