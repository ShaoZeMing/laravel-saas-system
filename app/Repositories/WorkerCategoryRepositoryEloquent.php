<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\worker_categorieRepository;
use App\Entities\WorkerCategory;
use App\Validators\WorkerCategorieValidator;

/**
 * Class WorkerCategorieRepositoryEloquent
 * @package namespace App\Repositories;
 */
class WorkerCategoryRepositoryEloquent extends BaseRepository implements WorkerCategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WorkerCategory::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
