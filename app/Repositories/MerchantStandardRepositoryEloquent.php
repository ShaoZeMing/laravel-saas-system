<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\merchant_standardRepository;
use App\Entities\MerchantStandard;
use App\Validators\MerchantStandardValidator;

/**
 * Class MerchantStandardRepositoryEloquent
 * @package namespace App\Repositories;
 */
class MerchantStandardRepositoryEloquent extends BaseRepository implements MerchantStandardRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MerchantStandard::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
