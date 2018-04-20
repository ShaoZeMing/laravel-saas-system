<?php


namespace App\Services\Account;
use App\Entities\PlatformBill;
use App\Repositories\PlatformAccountRepositoryEloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\MessageBag;

/**
 * Class PlatformAccountService
 * @package App\Services\Account
 */
class PlatformAccountService
{

  


    /**
     * 减去平台账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $platformId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function decrement($amount, Model $model, $desc = '')
    {
        $platformAccountModel =  app(PlatformAccountRepositoryEloquent::class)->decrement($amount);
        $billData = $platformAccountModel->toArray();
        self::createBill($model, $billData, PlatformBill::PAYOUT, $amount, $desc);
        return $platformAccountModel;
    }


 

    /**
     * 增加平台账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $platformId
     * @param $amount
     * @param Model $model
     * @return mixed
     */
    public static function increment($amount, Model $model, $desc = '')
    {
        $platformAccountModel =  app(PlatformAccountRepositoryEloquent::class)->increment($amount);
        $billData = $platformAccountModel->toArray();
        self::createBill($model, $billData, PlatformBill::INCOME, $amount, $desc);
        return $platformAccountModel;
    }


    /**
     * 创建资金账户流水
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
        if (!method_exists($model, 'platformBills')) {
            throw new \Exception('该对象不包含platformBills方法');
        }
        $billData['biz_type'] = $bizType;
        $billData['platform_account_id'] = $billData['id'] ;
        $billData['biz_comment'] = PlatformBill::$bizComments[$bizType];
        $billData['amount'] = $amount;
        $billData['desc'] = $desc ;
        $billSaved = $model->platformBills()->save(new PlatformBill($billData));
        if (!$billSaved) {
            throw new \Exception('添加商家流水记录失败');
        }
    }



}
