<?php
/**
 *  SiteAccountService.php
 *
 * @author gengzhiguo@xiongmaojinfu.com
 * $Id: SiteAccountService.php 2017-06-21 下午2:35 $
 */


namespace App\Services\Account;

use App\Entities\Site;
use App\Entities\SiteBill;
use App\Repositories\SiteAccountRepositoryEloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\MessageBag;

/**
 * Class SiteAccountService
 * @package App\Services\Account
 */
class SiteAccountService
{

    /**
     * 冻结账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $siteId
     * @param $amount
     * @param Model $model
     * @param $bizType
     * @return bool
     */
    public static function freeze($siteId, $amount, Model $model, $bizType, $desc = '')
    {
        $bizType = 'FREEZE_' . strtoupper('freeze_fee');
        $bizTypeValue = constant(sprintf('%s::%s', SiteBill::class, $bizType));

        if($amount == 0){
            return true;
        }
        $siteAccountModel =  app(SiteAccountRepositoryEloquent::class)->freeze($siteId, $amount);
        $billData = $siteAccountModel->toArray();
        self::createBill($model, $billData, $bizTypeValue, $amount, $desc);

        return $siteAccountModel;
    }


    /**
     * 减去账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $siteId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function decrement($siteId, $amount, Model $model, $desc = '')
    {
        $siteAccountModel =  app(SiteAccountRepositoryEloquent::class)->decrement($siteId, $amount);
        $billData = $siteAccountModel->toArray();
        self::createBill($model, $billData, SiteBill::PAYOUT, $amount, $desc);
        return $siteAccountModel;
    }


    /**
     * 工单退还资金减去账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $siteId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function orderDecrement($siteId, $amount, Model $model, $desc = '工单退还资金')
    {
        $siteAccountModel =  app(SiteAccountRepositoryEloquent::class)->decrement($siteId, $amount);
        $billData = $siteAccountModel->toArray();
        self::createBill($model, $billData, SiteBill::ORDER_DEDUCTIONS, $amount, $desc);
        return $siteAccountModel;
    }


    /**
     * 扣款减去账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $siteId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function otherDecrement($siteId, $amount, Model $model, $desc = '')
    {
        $siteAccountModel =  app(SiteAccountRepositoryEloquent::class)->decrement($siteId, $amount);
        $billData = $siteAccountModel->toArray();
        self::createBill($model, $billData, SiteBill::DEDUCTIONS, $amount, $desc);
        return $siteAccountModel;
    }


    /**
     * 解冻账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $siteId
     * @param $amount
     * @param Model $model
     * @param $bizType
     * @return bool
     */
    public static function unfreeze($siteId, $amount, Model $model, $bizType, $desc = '')
    {
        if($amount == 0){
            return true;
        }
        $siteAccountModel =  app(SiteAccountRepositoryEloquent::class)->unfreeze($siteId, $amount);
        $billData = $siteAccountModel->toArray();
        self::createBill($model, $billData, $bizType, $amount, $desc);
        return $siteAccountModel;
    }


    /**
     * 增加账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $siteId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function increment($siteId, $amount, Model $model, $desc = '')
    {
        $siteAccountModel =  app(SiteAccountRepositoryEloquent::class)->increment($siteId, $amount);
        $billData = $siteAccountModel->toArray();
        self::createBill($model, $billData, SiteBill::INCOME, $amount, $desc);
        return $siteAccountModel;
    }

    /**
     * 工单收入增加账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $siteId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function orderIncrement($siteId, $amount, Model $model, $desc = '工单收入')
    {
        $siteAccountModel =  app(SiteAccountRepositoryEloquent::class)->increment($siteId, $amount);
        $billData = $siteAccountModel->toArray();
        self::createBill($model, $billData, SiteBill::ORDER_INCOME, $amount, $desc);
        return $siteAccountModel;
    }


    /**
     * 线下增加账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $siteId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function offlineIncrement($siteId, $amount, Model $model, $desc = '')
    {
        $siteAccountModel =  app(SiteAccountRepositoryEloquent::class)->increment($siteId, $amount);
        $billData = $siteAccountModel->toArray();
        self::createBill($model, $billData, SiteBill::OFFLINE_INCOME, $amount, $desc);
        return $siteAccountModel;
    }


    /**
     * 退款增加账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $siteId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function otherIncrement($siteId, $amount, Model $model, $desc = '')
    {
        $siteAccountModel =  app(SiteAccountRepositoryEloquent::class)->increment($siteId, $amount);
        $billData = $siteAccountModel->toArray();
        self::createBill($model, $billData, SiteBill::REFUND, $amount, $desc);
        return $siteAccountModel;
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
    public  static function createBill(Model $model, array $billData, $bizType, $amount, $desc = '')
    {
        // 写一条商家资金流水记录
        if (!method_exists($model, 'siteBills')) {
            throw new \Exception('该对象不包含siteBills方法');
        }
        $billData['biz_type'] = $bizType;
        $billData['biz_comment'] = SiteBill::$bizComments[$bizType];
        $billData['amount'] = $amount;
        $billData['desc'] = $desc;
        $billSaved = $model->siteBills()->save(new SiteBill($billData));
        if (!$billSaved) {
            throw new \Exception('添加商家流水记录失败');
        }
    }


    /**
     * 线上提现,清理账户余额
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $siteId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function onlineRefund($siteId, $amount,Model $model)
    {
        $siteAccountModel =  app(SiteAccountRepositoryEloquent::class)->decrement($siteId, $amount);
        $billData = $siteAccountModel->toArray();
        self::createBill($model, $billData, SiteBill::ONLINE_WITHDRAWALS, $amount);
        return $siteAccountModel;
    }


    /**
     * 线下提现,清理账户余额
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $siteId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function offlineRefund($siteId, $amount,Model $model)
    {
        $siteAccountModel =  app(SiteAccountRepositoryEloquent::class)->decrement($siteId, $amount);
        $billData = $siteAccountModel->toArray();
        self::createBill($model, $billData, SiteBill::OFFLINE_WITHDRAWALS, $amount);
        return $siteAccountModel;
    }
}
