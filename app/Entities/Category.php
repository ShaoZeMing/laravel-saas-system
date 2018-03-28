<?php

namespace App\Entities;


/**
 * App\Entities\Categorie
 *
 * @property string $id
 * @property string $cat_name
 * @property string $cat_desc
 * @property int $cat_parent_id
 * @property int $cat_level
 * @property int $cat_state
 * @property int $cat_sort
 * @property string $cat_logo
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Brand[] $brands
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Category[] $children
 * @property-read mixed $categorie_logo
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Malfunction[] $malfunctions
 * @property-read \App\Entities\Category $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereCatDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereCatLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereCatLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereCatName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereCatParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereCatSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereCatState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends BaseModel
{
    public $table='categories';

    protected $guarded = [];


//    /**
//     * @return array
//     */
//    public function allNodes() : array
//    {
//        $orderColumn = DB::getQueryGrammar()->wrap($this->orderColumn);
//        $byOrder = $orderColumn.' = 0,'.$orderColumn;
//
//        return static::with('brands')->orderByRaw($byOrder)->get()->toArray();
//    }


    public static function getDelIds($id)
    {
        static $rIds;
        $rIds[] = $id;
        $ids = self::where('cat_parent_id',$id)->get(['id'])->toArray();
        $ids = array_column($ids,'id');
        foreach ($ids as $v){
            $rIds[] = $v;
            $mod =  self::where('cat_parent_id',$v)->get();
            \Log::info('循环获取CID',[$mod->count()]);
            if($mod->count()){
                $idss = array_column($mod->toArray(),'id');
                foreach ($idss as $vv)
                $rIds[] = $vv;
                self::getDelIds($vv);
            }
        }
        return $rIds;
    }

    /**
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $ids
     * @return array
     */
    public static function getAddIds($ids)
    {
        static $rIds;

        if(is_array($ids)){
            foreach ($ids as $id){
                $rIds[] = $id;
                $mod =  self::find($id,['cat_parent_id']);
                if($mod->count() && $mod->cat_parent_id){
                    $rIds[] = $mod->cat_parent_id;
                    self::getAddIds($mod->cat_parent_id);
                }
            }
        }else{
            $rIds[] = $ids;
            $mod =  self::find($ids,['cat_parent_id']);
            if($mod->count() && $mod->cat_parent_id){
                $rIds[] = $mod->cat_parent_id;
                self::getAddIds($mod->cat_parent_id);
            }
        }
        return array_unique($rIds);
    }



    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brand_categories', 'cat_id', 'brand_id');
    }

    /**
     * 获取分类下所有的产品
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'cat_id');
    }

    /**
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function malfunctions()
    {
        return $this->hasMany(Malfunction::class, 'cat_id');
    }

    /**
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'cat_parent_id');
    }

    /**
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'cat_parent_id');
    }


    public function getCatLogoAttribute($value)
    {
        if ($value) {
            $img = parse_url($value)['path'];
            $host = rtrim(config('filesystems.disks.admin.url'), '/') . '/';
            return $host . $img;
        }
        return $value;
    }


    public function transform()
    {

    }

}
