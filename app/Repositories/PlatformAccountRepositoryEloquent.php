<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\platformAccountRepository;
use App\Entities\PlatformAccount;
use App\Validators\PlatformAccountValidator;

/**
 * Class PlatformAccountRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PlatformAccountRepositoryEloquent extends BaseRepository implements PlatformAccountRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PlatformAccount::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    /**
     * 增加账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $id
     * @param $amount
     * @return mixed
     * @throws \Exception
     */
    public function increment($amount,$id=1)
    {
        $id = config('xiuxiu.platform_account_id');
        \Log::info('平台账户',[__METHOD__]);
        $account = $this->findByField('id', $id)->first();
        $balance = intval($account->balance);
        $newBalance = $balance + $amount;
        $affected = $this->model->where('id', $id)
            ->where('balance', $balance)
            ->update([
                'balance' => $newBalance,
            ]);
        \Log::error('增加账户资123',[$id,$newBalance, $amount, $account]);

        if ($affected) {
            $account->balance = $newBalance;
            return $account;
        }
        \Log::error('增加账户资金失败',[$id,$newBalance, $amount, $account]);
        throw new \Exception('解冻账户资金失败', 3004);
    }




    /**
     * 减去账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $id
     * @param $amount
     * @return mixed
     * @throws \Exception
     */
    public function decrement($amount,$id=1)
    {
        $id = config('saas.platform_account_id');
        $account = $this->findByField('id', $id)->first();
        $balance = intval($account->balance);
        $newBalance = $balance - $amount;
        $affected = $this->model->where('id', $id)
            ->where("balance", '>=', $amount)
            ->where('balance', $balance)
            ->update([
                'balance' => $newBalance,
            ]);
        if ($affected) {
            $account->balance = $newBalance;
            return $account;
        }
        \Log::error('减去账户资金失败', [$id,$newBalance, $amount, $account]);
        throw new \Exception('减去账户资金失败', 3002);
    }
}
