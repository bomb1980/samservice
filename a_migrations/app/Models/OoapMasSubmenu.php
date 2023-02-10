<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//ooap_mas_submenu_model
class OoapMasSubmenu extends Model
{
    protected $table = 'ooap_mas_submenu';

    protected $primaryKey = 'submenu_id';

    protected $fillable = [
        'show_on_menu', 'menu_id', 'submenu_name', 'route_name', 'display_order', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at', 'error', 'admin'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public $timestamps = true;


    static function getDatas($allow_menus = [], $route_name = NULL, $show_on_menu = NULL )
    {
        $data = self::select([
            'ooap_mas_submenu.*',
            'ooap_mas_menu.menu_name',
            'ooap_mas_menu.display_order',
            'ooap_mas_menu.activepage_name',
            'ooap_mas_menu.menu_icon',
        ])
        ->leftjoin('ooap_mas_menu', 'ooap_mas_submenu.menu_id','=', 'ooap_mas_menu.menu_id')
        ->where('ooap_mas_submenu.in_active', false);

        if (!empty($allow_menus)) {
            $data = $data->whereIn('ooap_mas_submenu.submenu_id', $allow_menus);
        }

        if (!empty($show_on_menu)) {
            $data = $data->where('ooap_mas_submenu.show_on_menu', '=', 1);
        }

        if (!empty($route_name)) {
           $data = $data->where('ooap_mas_submenu.route_name', '=', $route_name);
        }

        return $data->orderBy('ooap_mas_submenu.menu_id', 'asc')->orderBy('ooap_mas_submenu.submenu_id', 'asc')->get();
    }

    static function getData( $route_name = NULL)
    {
        return self::select(['ooap_mas_submenu.*'])->where('route_name', '=',  $route_name );
    }
}
