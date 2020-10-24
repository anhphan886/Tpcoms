<?php


namespace Modules\Wiki\Models;

use Illuminate\Database\Eloquent\Model;
use MyCore\Models\Traits\ListTableTrait;

class WikiCategoryTable extends Model
{
    use ListTableTrait;
    protected $table = 'wiki_category';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name_vi',
        'name_en',
        'alias_vi',
        'alias_en',
        'description_vi',
        'description_en',
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
    ];

    public function getListCore(&$filter = [])
    {
        $oSelect = $this->orderBy('updated_at', 'DESC');
        if (isset($filter['name_en']) && $filter['name_en']) {
            $oSelect = $oSelect->where('name_en', 'like', '%' . $filter['name_en'] . '%');
        }
        if (isset($filter['name_vi']) && $filter['name_vi']) {
            $oSelect = $oSelect->where('name_vi', 'like', '%' . $filter['name_vi'] . '%');
        }
        unset($filter['name_en']);
        unset($filter['name_vi']);
        return $oSelect;
    }

    public function getDetailCategory($id)
    {
        $oSelect = $this->where('id', $id)->first();
        return $oSelect;
    }

    public function deleteCategory($filter)
    {
        $oSelect = $this->where($filter)->delete();
        return $oSelect;
    }

    public function checkCategoryEn($id = 0, $en)
    {
        $oSelect = $this->where('alias_en', $en);
        if ($id != 0) {
            $oSelect = $oSelect->where('id', '<>', $id);
        }
        return $oSelect;
    }

    public function checkCategoryVi($id = 0, $vi)
    {
        $oSelect = $this->where('alias_vi', $vi);
        if ($id != 0) {
            $oSelect = $oSelect->where('id', '<>', $id);
        }
        return $oSelect;
    }

    public function addCategory($arr)
    {
        $oSelect = $this->insert($arr);
        return $oSelect;
    }

    public function editCategory($id, array $arr)
    {
        $oSelect = $this->where('id', $id)->update($arr);
        return $oSelect;
    }

    public function getCategory()
    {
        $oSelect = $this->get();
        return $oSelect;
    }
}
