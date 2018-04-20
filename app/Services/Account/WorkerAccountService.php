<?php
/**
 *  WorkerAccountService.php
 *
 * @author gengzhiguo@xiongmaojinfu.com
 * $Id: WorkerAccountService.php 2017-06-21 下午2:35 $
 */


namespace App\Services\Account;

use App\Entities\Worker;
use App\Entities\WorkerBill;
use App\Repositories\WorkerAccountRepositoryEloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\MessageBag;

/**
 * Class WorkerAccountService
 * @package App\Services\Account
 */
class WorkerAccountService
{

    /**
     * 冻结账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $workerId
     * @param $amount
     * @param Model $model
     * @param $bizType
     * @return bool
     */
    public static function freeze($workerId, $amount, Model $model, $bizType, $desc = '')
    {
        $bizType = 'FREEZE_' . strtoupper('freeze_fee');
        $bizTypeValue = constant(sprintf('%s::%s', WorkerBill::class, $bizType));

        if($amount == 0){
            return true;
        }
        $workerAccountModel =  app(WorkerAccountRepositoryEloquent::class)->freeze($workerId, $amount);
        $billData = $workerAccountModel->toArray();
        self::createBill($model, $billData, $bizTypeValue, $amount, $desc);

        return $workerAccountModel;
    }


    /**
     * 减去账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $workerId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function decrement($workerId, $amount, Model $model, $desc = '')
    {
        $workerAccountModel =  app(WorkerAccountRepositoryEloquent::class)->decrement($workerId, $amount);
        $billData = $workerAccountModel->toArray();
        self::createBill($model, $billData, WorkerBill::PAYOUT, $amount, $desc);
        return $workerAccountModel;
    }


    /**
     * 工单退还资金减去账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $workerId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function orderDecrement($workerId, $amount, Model $model, $desc = '工单退还资金')
    {
        $workerAccountModel =  app(WorkerAccountRepositoryEloquent::class)->decrement($workerId, $amount);
        $billData = $workerAccountModel->toArray();
        self::createBill($model, $billData, WorkerBill::ORDER_DEDUCTIONS, $amount, $desc);
        return $workerAccountModel;
    }


    /**
     * 扣款减去账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $workerId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function otherDecrement($workerId, $amount, Model $model, $desc = '')
    {
        $workerAccountModel =  app(WorkerAccountRepositoryEloquent::class)->decrement($workerId, $amount);
        $billData = $workerAccountModel->toArray();
        self::createBill($model, $billData, WorkerBill::DEDUCTIONS, $amount, $desc);
        return $workerAccountModel;
    }


    /**
     * 解冻账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $workerId
     * @param $amount
     * @param Model $model
     * @param $bizType
     * @return bool
     */
    public static function unfreeze($workerId, $amount, Model $model, $bizType, $desc = '')
    {
        if($amount == 0){
            return true;
        }
        $workerAccountModel =  app(WorkerAccountRepositoryEloquent::class)->unfreeze($workerId, $amount);
        $billData = $workerAccountModel->toArray();
        self::createBill($model, $billData, $bizType, $amount, $desc);
        return $workerAccountModel;
    }


    /**
     * 增加账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $workerId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function increment($workerId, $amount, Model $model, $desc = '')
    {
        $workerAccountModel =  app(WorkerAccountRepositoryEloquent::class)->increment($workerId, $amount);
        $billData = $workerAccountModel->toArray();
        self::createBill($model, $billData, WorkerBill::INCOME, $amount, $desc);
        return $workerAccountModel;
    }

    /**
     * 工单收入增加账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $workerId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function orderIncrement($workerId, $amount, Model $model, $desc = '工单收入')
    {
        $workerAccountModel =  app(WorkerAccountRepositoryEloquent::class)->increment($workerId, $amount);
        $billData = $workerAccountModel->toArray();
        self::createBill($model, $billData, WorkerBill::ORDER_INCOME, $amount, $desc);
        return $workerAccountModel;
    }


    /**
     * 线下增加账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $workerId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function offlineIncrement($workerId, $amount, Model $model, $desc = '')
    {
        $workerAccountModel =  app(WorkerAccountRepositoryEloquent::class)->increment($workerId, $amount);
        $billData = $workerAccountModel->toArray();
        self::createBill($model, $billData, WorkerBill::OFFLINE_INCOME, $amount, $desc);
        return $workerAccountModel;
    }


    /**
     * 退款增加账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $workerId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function otherIncrement($workerId, $amount, Model $model, $desc = '')
    {
        $workerAccountModel =  app(WorkerAccountRepositoryEloquent::class)->increment($workerId, $amount);
        $billData = $workerAccountModel->toArray();
        self::createBill($model, $billData, WorkerBill::REFUND, $amount, $desc);
        return $workerAccountModel;
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
        if (!method_exists($model, 'workerBills')) {
            throw new \Exception('该对象不包含workerBills方法');
        }
        $billData['biz_type'] = $bizType;
        $billData['biz_comment'] = WorkerBill::$bizComments[$bizType];
        $billData['amount'] = $amount;
        $billData['desc'] = $desc;
        $billSaved = $model->workerBills()->save(new WorkerBill($billData));
        if (!$billSaved) {
            throw new \Exception('添加商家流水记录失败');
        }
    }


    /**
     * 线上提现,清理账户余额
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $workerId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function onlineRefund($workerId, $amount,Model $model)
    {
        $workerAccountModel =  app(WorkerAccountRepositoryEloquent::class)->decrement($workerId, $amount);
        $billData = $workerAccountModel->toArray();
        self::createBill($model, $billData, WorkerBill::ONLINE_WITHDRAWALS, $amount);
        return $workerAccountModel;
    }


    /**
     * 线下提现,清理账户余额
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $workerId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function offlineRefund($workerId, $amount,Model $model)
    {
        $workerAccountModel =  app(WorkerAccountRepositoryEloquent::class)->decrement($workerId, $amount);
        $billData = $workerAccountModel->toArray();
        self::createBill($model, $billData, WorkerBill::OFFLINE_WITHDRAWALS, $amount);
        return $workerAccountModel;
    }
}
