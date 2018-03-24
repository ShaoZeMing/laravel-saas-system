<?php

namespace App\Entities;

use App\Traits\HashIdsTrait;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\SequenceTrait;


/**
 * App\Entities\Brand
 *
 * @property string $id
 * @property string $brand_name
 * @property string $brand_desc
 * @property int $brand_parent_id
 * @property int $brand_level
 * @property int $brand_state
 * @property int $brand_sort
 * @property string $brand_logo
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Categorie[] $cats
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Brand[] $children
 * @property-read \App\Entities\Brand $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Brand whereBrandDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Brand whereBrandLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Brand whereBrandLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Brand whereBrandName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Brand whereBrandParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Brand whereBrandSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Brand whereBrandState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Brand whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Brand extends BaseModel
{

    protected $guarded = [];


    /**
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $id
     * @return array
     */
    public static function getDelIds($id)
    {
        $ids = self::where('brand_parent_id',$id)->get(['id'])->toArray();
        $ids = array_column($ids,'id');
        $ids[] = $id;
        return $ids;
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
                $mod =  self::find($id,['brand_parent_id']);
                if($mod->count() && $mod->brand_parent_id){
                    $rIds[] = $mod->brand_parent_id;
                    self::getAddIds($mod->brand_parent_id);
                }
            }
        }else{
            $rIds[] = $ids;
            $mod =  self::find($ids,['brand_parent_id']);
            if($mod->count() && $mod->brand_parent_id){
                $rIds[] = $mod->brand_parent_id;
                self::getAddIds($mod->brand_parent_id);
            }
        }
        return array_unique($rIds);
    }


    /**
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(){
        return $this->belongsTo(Brand::class);

    }

    /**
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(){
        return $this->hasMany(Brand::class,'brand_parent_id');
    }


    /**
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(){
        return $this->hasMany(Product::class,'brand_parent_id');
    }


    /**
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cats(){
        return $this->belongsToMany(Categorie::class,'brand_categories','brand_id','cat_id');
    }


    /**
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $value
     * @return string
     */
    public function getBrandLogoAttribute($value)
    {
        if ($value) {
            $img = parse_url($value)['path'];
            $host = rtrim(config('filesystems.disks.admin.url'), '/').'/';
            return $host . $img;
        }
        return $value;
    }


}
