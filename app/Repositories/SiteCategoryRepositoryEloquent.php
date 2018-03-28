<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\site_categorieRepository;
use App\Entities\SiteCategory;
use App\Validators\SiteCategorieValidator;

/**
 * Class SiteCategorieRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SiteCategoryRepositoryEloquent extends BaseRepository implements SiteCategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SiteCategory::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
