<?php


namespace Modules\Wiki\Models;

use Illuminate\Database\Eloquent\Model;
use MyCore\Models\Traits\ListTableTrait;

class WikiDetailTable extends Model
{
    use ListTableTrait;
    protected $table = 'wiki_detail';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'category_id',
        'name_vi',
        'name_en',
        'alias_vi',
        'alias_en',
        'description_vi',
        'description_en',
        'content_vi',
        'content_en',
        'image',
        'position',
        'seo_title_vi',
        'seo_title_en',
        'seo_keyword_vi',
        'seo_keyword_en',
        'seo_description_vi',
        'seo_description_en',
        'seo_image',
        'is_actived',
        'is_deleted',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    public function getListCore(&$filter = [])
    {
        $oSelect = $this
            ->join('wiki_category', 'wiki_category.id', 'wiki_detail.category_id');
        if (isset($filter['name_en']) && $filter['name_en']) {
            $oSelect = $oSelect->where('wiki_detail.name_en', 'like', '%' . $filter['name_en'] . '%');
        }
        if (isset($filter['name_vi']) && $filter['name_vi']) {
            $oSelect = $oSelect->where('wiki_detail.name_vi', 'like', '%' . $filter['name_vi'] . '%');
        }
        if (isset($filter['category_name_en']) && $filter['category_name_en']) {
            $oSelect = $oSelect->where('wiki_category.name_en', 'like', '%' . $filter['category_name_en'] . '%');
        }
        if (isset($filter['category_name_vi']) && $filter['category_name_vi']) {
            $oSelect = $oSelect->where('wiki_category.name_vi', 'like', '%' . $filter['category_name_vi'] . '%');
        }
        $oSelect->select(
            'wiki_detail.*',
            'wiki_category.name_en as category_name_en',
            'wiki_category.name_vi as category_name_vi'
        );
        $oSelect->orderBy('updated_at', 'DESC');
        unset($filter['name_en']);
        unset($filter['name_vi']);
        unset($filter['category_name_en']);
        unset($filter['category_name_vi']);
        return $oSelect;
    }

    public function getDetail($id)
    {
        $oSelect = $this->where('id', $id)->first();
        return $oSelect;
    }

    public function checkDetailEn($id = 0, $en)
    {
        $oSelect = $this->where('alias_en', $en);
        if ($id != 0) {
            $oSelect = $oSelect->where('id', '<>', $id);
        }
        return $oSelect;
    }

    public function checkDetailVi($id = 0, $vi)
    {
        $oSelect = $this->where('alias_vi', $vi);
        if ($id != 0) {
            $oSelect = $oSelect->where('id', '<>', $id);
        }
        return $oSelect;
    }

    public function addDetail($arr)
    {
        $oSelect = $this->insert($arr);
        return $oSelect;
    }

    public function editDetail($id, array $arr)
    {
        $oSelect = $this->where('id', $id)->update($arr);
        return $oSelect;
    }

    public function deleteDetail($filter)
    {
        $oSelect = $this->where($filter)->delete();
        return $oSelect;
    }
}
