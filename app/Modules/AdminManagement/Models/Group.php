<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 24/10/2017
 * Time: 9:37
 */

namespace App\Modules\AdminManagement\Models;

use App\Models\BaseModel\Group as BaseGroup;

class Group extends BaseGroup
{
    public static function GetSelectableList() {
        $groups = Group::all();
        $tmp = [];
        foreach ($groups as $group) {
            $tmp[$group->id] = $group->name;
        }
        return $tmp;
    }

    public static function advancedSearch(Request $request, $pagination =  10) {
        $user = new Group();
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

    public function selectedRole() {
        $tmp = [];
        foreach ($this->roles as $role) {
            $tmp[] = $role->id;
        }

        return $tmp;
    }

    public function saveRole($new) {
        $old = $this->selectedRole();

        if(count($old) == count($new)) {
            return;
        }

        if(count($old) > count($new)) {
            foreach ($old as $id) {
                if(!in_array($id, $new)) {
                    $this->revokeRoleByID($id);
                }
            }
        } else {
            foreach ($new as $id) {
                if(!in_array($id, $old)) {
                    $this->assignRoleByID($id);
                }
            }
        }
    }
}