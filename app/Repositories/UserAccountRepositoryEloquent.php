<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UserAccountRepository;
use App\Entities\UserAccount;
use App\Validators\UserAccountValidator;

/**
 * Class UserAccountRepositoryEloquent
 * @package namespace App\Repositories;
 */
class UserAccountRepositoryEloquent extends BaseRepository implements UserAccountRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserAccount::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    protected $maFields = [
        'user_id',
        'balance',
        'freeze',
        'available',
        'discount',
        'coupon',
        'paid',
        'income',
    ];

    /**
     * 冻结账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $id
     * @param $amount
     * @return mixed
     * @throws \Exception
     */
    public function freeze($id, $amount)
    {
        $account = $this->findByField('user_id', $id, $this->maFields)->first();
        $available = intval($account->available);
        $newAvailable = $available - $amount;
        $freeze = intval($account->freeze);
        $newFreeze = $freeze + $amount;
        $affected = $this->model->where('user_id', $id)
            ->whereRaw("available >= {$amount}")
            ->where('available', $available)
            ->where('freeze', $freeze)
            ->update([
                'freeze' => $newFreeze,
                'available' => $newAvailable,
            ]);
        if ($affected) {
            $account->available = $newAvailable;
            $account->freeze = $newFreeze;
            return $account;
        }
        throw new \Exception('冻结资金失败', 3003);
    }




    /**
     * 解冻账户资金
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $id
     * @param $amount
     * @return mixed
     * @throws \Exception
     */
    public function unfreeze($id, $amount)
    {
        $account = $this->findByField('user_id', $id, $this->maFields)->first();
        $available = intval($account->available);
        $newAvailable = $available + $amount;
        $freeze = intval($account->freeze);
        $newFreeze = $freeze - $amount;

        $affected = $this->model->where('user_id', $id)
            ->where('freeze', '>=', $amount)
            ->where('freeze', $freeze)
            ->where('available', $available)
            ->update([
                'freeze' => $newFreeze,
                'available' => $newAvailable,
            ]);

        if ($affected) {
            $account->freeze = $newFreeze;
            $account->available = $newAvailable;

            return $account;
        }
        Log::error('解冻资金失败',[$newAvailable,$id, $amount, $account]);
        throw new \Exception('解冻账户资金失败', 3004);
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
    public function increment($id, $amount)
    {
        $account = $this->findByField('user_id', $id, $this->maFields)->first();
        $balance = intval($account->balance);
        $newBalance = $balance + $amount;
        $available = intval($account->available);
        $newAvailable = $available + $amount;
        $affected = $this->model->where('user_id', $id)
            ->where('balance', $balance)
            ->where('available', $available)
            ->update([
                'balance' => $newBalance,
                'available' => $newAvailable,
            ]);
        if ($affected) {
            $account->balance = $newBalance;
            $account->available = $newAvailable;

            return $account;
        }
        Log::error('增加账户资金失败',[$newAvailable,$id,$newBalance, $amount, $account]);
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
    public function decrement($id, $amount)
    {
        $account = $this->findByField('user_id', $id, $this->maFields)->first();
        $balance = intval($account->balance);
        $newBalance = $balance - $amount;
        $available = intval($account->available);
        $newAvailable = $available - $amount;
        $affected = $this->model->where('user_id', $id)
            ->where("balance", '>=', $amount)
            ->where('balance', $balance)
            ->where('available', '>=', $amount)
            ->where('available', $available)
            ->update([
                'balance' => $newBalance,
                'available' => $newAvailable,
            ]);
        if ($affected) {
            $account->balance = $newBalance;
            $account->available = $newAvailable;

            return $account;
        }
        \Log::error('减去账户资金失败', [$newAvailable,$id,$newBalance, $amount, $account]);

        throw new \Exception('减去账户资金失败', 3002);
    }

}
