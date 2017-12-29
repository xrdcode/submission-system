<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 24/10/2017
 * Time: 18:29
 */

namespace App\Modules\AdminManagement\Models;

use App\Models\BaseModel\Role as BaseRole;

class Role extends BaseRole
{
    public static function GetSelectableList() {
        $groups = Role::all();
        $tmp = [];
        foreach ($groups as $group) {
            $tmp[$group->id] = $group->name;
        }
        return $tmp;
    }

    public static function advancedSearch(Request $request, $pagination =  10) {
        $user = new Role();
        return $user
            ->where("name", 'like', "%$request->name%")
            ->orderBy('name')
            ->paginate($pagination);
    }

    public static function scopeSearch($q, $s) {
        return $q
            ->where("name", 'like', "%$s%")
            ->orderBy('name');
    }
}