<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\brand_categorieRepository;
use App\Entities\BrandCategory;
use App\Validators\BrandCategoryValidator;

/**
 * Class BrandCategoryRepositoryEloquent
 * @package namespace App\Repositories;
 */
class BrandCategoryRepositoryEloquent extends BaseRepository implements BrandCategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BrandCategory::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
