<?php


namespace Modules\Wiki\Models;

use Illuminate\Database\Eloquent\Model;
use MyCore\Models\Traits\ListTableTrait;

class WikiSlugTable extends Model
{
    use ListTableTrait;
    protected $table = 'wiki_slug';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'route',
        'alias_vi',
        'alias_en',
        'created_at',
        'updated_at',
    ];

    public function addCategory($arr)
    {
        $tmp = [
            'route' => 'frontend.category_wiki',
            'alias_en' => $arr['alias_en'],
            'alias_vi' => $arr['alias_vi']
        ];
        $oSelect = $this->insert($tmp);
        return $oSelect;
    }

    public function addDetail($arr)
    {
        $tmp = [
            'route' => 'frontend.detail_wiki',
            'alias_en' => $arr['alias_en'],
            'alias_vi' => $arr['alias_vi']
        ];
        $oSelect = $this->insert($tmp);
        return $oSelect;
    }

    public function editCategory($alias_en, $alias_vi, $arr)
    {
        $tmp = [
            'route' => 'frontend.category_wiki',
            'alias_en' => $arr['alias_en'],
            'alias_vi' => $arr['alias_vi']
        ];
        $oSelect = $this
            ->where('alias_en', $alias_en)
            ->where('alias_vi', $alias_vi)
            ->update($tmp);
        return $oSelect;
    }

    public function deleteCategory($alias_en, $alias_vi)
    {
        $oSelect = $this->where('route', 'frontend.category_wiki')
            ->where('alias_en', $alias_en)
            ->where('alias_vi', $alias_vi)
            ->delete();
        return $oSelect;
    }

    public function editDetail($alias_en, $alias_vi, $arr)
    {
        $tmp = [
            'route' => 'frontend.detail_wiki',
            'alias_en' => $arr['alias_en'],
            'alias_vi' => $arr['alias_vi']
        ];
        $oSelect = $this
            ->where('alias_en', $alias_en)
            ->where('alias_vi', $alias_vi)
            ->update($tmp);
        return $oSelect;
    }

    public function deleteDetail($alias_en, $alias_vi)
    {
        $oSelect = $this->where('route', 'frontend.detail_wiki')
            ->where('alias_en', $alias_en)
            ->where('alias_vi', $alias_vi)
            ->delete();
        return $oSelect;
    }
}
