<?php
/**
 *  UserAccountService.php
 *
 * @author gengzhiguo@xiongmaojinfu.com
 * $Id: UserAccountService.php 2017-06-21 下午2:35 $
 */


namespace App\Services\Account;

use App\Entities\User;
use App\Entities\UserBill;
use App\Repositories\UserAccountRepositoryEloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\MessageBag;

/**
 * Class UserAccountService
 * @package App\Services\Account
 */
class UserAccountService
{

    /**
     * 冻结账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $userId
     * @param $amount
     * @param Model $model
     * @param $bizType
     * @return bool
     */
    public static function freeze($userId, $amount, Model $model, $bizType, $desc = '')
    {
        $bizType = 'FREEZE_' . strtoupper('freeze_fee');
        $bizTypeValue = constant(sprintf('%s::%s', UserBill::class, $bizType));

        if($amount == 0){
            return true;
        }
        $userAccountModel =  app(UserAccountRepositoryEloquent::class)->freeze($userId, $amount);
        $billData = $userAccountModel->toArray();
        self::createBill($model, $billData, $bizTypeValue, $amount, $desc);

        return $userAccountModel;
    }


    /**
     * 减去账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $userId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function decrement($userId, $amount, Model $model, $desc = '')
    {
        $userAccountModel =  app(UserAccountRepositoryEloquent::class)->decrement($userId, $amount);
        $billData = $userAccountModel->toArray();
        self::createBill($model, $billData, UserBill::PAYOUT, $amount, $desc);
        return $userAccountModel;
    }


    /**
     * 工单退还资金减去账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $userId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function orderDecrement($userId, $amount, Model $model, $desc = '工单退还资金')
    {
        $userAccountModel =  app(UserAccountRepositoryEloquent::class)->decrement($userId, $amount);
        $billData = $userAccountModel->toArray();
        self::createBill($model, $billData, UserBill::ORDER_DEDUCTIONS, $amount, $desc);
        return $userAccountModel;
    }


    /**
     * 扣款减去账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $userId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function otherDecrement($userId, $amount, Model $model, $desc = '')
    {
        $userAccountModel =  app(UserAccountRepositoryEloquent::class)->decrement($userId, $amount);
        $billData = $userAccountModel->toArray();
        self::createBill($model, $billData, UserBill::DEDUCTIONS, $amount, $desc);
        return $userAccountModel;
    }


    /**
     * 解冻账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $userId
     * @param $amount
     * @param Model $model
     * @param $bizType
     * @return bool
     */
    public static function unfreeze($userId, $amount, Model $model, $bizType, $desc = '')
    {
        if($amount == 0){
            return true;
        }
        $userAccountModel =  app(UserAccountRepositoryEloquent::class)->unfreeze($userId, $amount);
        $billData = $userAccountModel->toArray();
        self::createBill($model, $billData, $bizType, $amount, $desc);
        return $userAccountModel;
    }


    /**
     * 增加账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $userId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function increment($userId, $amount, Model $model, $desc = '')
    {
        $userAccountModel =  app(UserAccountRepositoryEloquent::class)->increment($userId, $amount);
        $billData = $userAccountModel->toArray();
        self::createBill($model, $billData, UserBill::INCOME, $amount, $desc);
        return $userAccountModel;
    }

    /**
     * 工单收入增加账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $userId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function orderIncrement($userId, $amount, Model $model, $desc = '工单收入')
    {
        $userAccountModel =  app(UserAccountRepositoryEloquent::class)->increment($userId, $amount);
        $billData = $userAccountModel->toArray();
        self::createBill($model, $billData, UserBill::ORDER_INCOME, $amount, $desc);
        return $userAccountModel;
    }


    /**
     * 线下增加账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $userId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function offlineIncrement($userId, $amount, Model $model, $desc = '')
    {
        $userAccountModel =  app(UserAccountRepositoryEloquent::class)->increment($userId, $amount);
        $billData = $userAccountModel->toArray();
        self::createBill($model, $billData, UserBill::OFFLINE_INCOME, $amount, $desc);
        return $userAccountModel;
    }


    /**
     * 退款增加账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $userId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function otherIncrement($userId, $amount, Model $model, $desc = '')
    {
        $userAccountModel =  app(UserAccountRepositoryEloquent::class)->increment($userId, $amount);
        $billData = $userAccountModel->toArray();
        self::createBill($model, $billData, UserBill::REFUND, $amount, $desc);
        return $userAccountModel;
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
        if (!method_exists($model, 'userBills')) {
            throw new \Exception('该对象不包含userBills方法');
        }
        $billData['biz_type'] = $bizType;
        $billData['biz_comment'] = UserBill::$bizComments[$bizType];
        $billData['amount'] = $amount;
        $billData['desc'] = $desc;
        $billSaved = $model->userBills()->save(new UserBill($billData));
        if (!$billSaved) {
            throw new \Exception('添加商家流水记录失败');
        }
    }


    /**
     * 线上提现,清理账户余额
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $userId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function onlineRefund($userId, $amount,Model $model)
    {
        $userAccountModel =  app(UserAccountRepositoryEloquent::class)->decrement($userId, $amount);
        $billData = $userAccountModel->toArray();
        self::createBill($model, $billData, UserBill::ONLINE_WITHDRAWALS, $amount);
        return $userAccountModel;
    }


    /**
     * 线下提现,清理账户余额
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $userId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function offlineRefund($userId, $amount,Model $model)
    {
        $userAccountModel =  app(UserAccountRepositoryEloquent::class)->decrement($userId, $amount);
        $billData = $userAccountModel->toArray();
        self::createBill($model, $billData, UserBill::OFFLINE_WITHDRAWALS, $amount);
        return $userAccountModel;
    }
}
