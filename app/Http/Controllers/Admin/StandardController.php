<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Brand;
use App\Entities\Category;
use App\Entities\Malfunction;
use App\Entities\Product;
use App\Entities\Standard;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;

class StandardController extends Controller
{
    use ModelForm;
    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('规格管理');
            $content->description('这都是规格');
            $content->body($this->grid());

        });

    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('编辑规格');
            $content->description('注意编辑');
            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('创建规格');
            $content->description('描述');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Standard::class, function (Grid $grid) {

            $catId = request()->get('cat_id');//搜索分类下的规格
            $where = $catId ? ['cat_id' => $catId] : [];
            $grid->model()->where($where)->orderBy('standard_sort');
//            $grid->id('ID')->sortable();
            $grid->column('standard_name', '规格名称');
            $grid->column('cat.cat_name', '规格分类');
            $grid->column('standard_desc', '规格描述')->limit(30);
            $grid->column('standard_state','状态')->switch();
            $grid->created_at('创建时间');
            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->like('standard_name','规格名称');
                $filter->equal('cat_id','规格分类')->select(Category::all()->pluck('cat_name', 'id'));
                $filter->between('created_at', '创建时间')->datetime();
            });

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Standard::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->select('cat_id', '规格分类')->options(Category::all()->pluck('cat_name', 'id'))->load('malfunctions','/admin/api/cat/malfunctions');
            $form->text('standard_name', '规格名称')->rules('required');
            $form->textarea('standard_desc', '描述');
            $form->number('standard_sort', '排序')->setWidth(2);
            $form->switch('standard_state','状态')->default(1);
        });
    }




}
