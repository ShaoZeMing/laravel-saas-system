<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\standardRepository;
use App\Entities\Standard;
use App\Validators\StandardValidator;

/**
 * Class StandardRepositoryEloquent
 * @package namespace App\Repositories;
 */
class StandardRepositoryEloquent extends BaseRepository implements StandardRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Standard::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
