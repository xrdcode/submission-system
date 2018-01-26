<?php

namespace App\Modules\AdminManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Role;
use App\Models\BaseModel\Admin as BaseAdmin;

class Admin extends BaseAdmin
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'address', 'phone','active',
    ];

    protected $hidden = [
      "password", "remember_token", "email_token"
    ];

    public function selectedGroup() {
        $tmp = [];
        foreach ($this->groups as $group) {
            $tmp[] = $group->id;
        }

        return $tmp;
    }

    public function saveGroup($new) {
        $old = $this->selectedGroup();

        if(count($old) == count($new)) {
            return;
        }
        if(!is_array($new) || empty($new)) {
            foreach ($old as $id) {
                $this->revokeGroupByID($id);
            }
            return;
        }

        if(count($old) > count($new)) {
            foreach ($old as $id) {
                if(!in_array($id, $new)) {
                    $this->revokeGroupByID($id);
                }
            }
        } else {
            foreach ($new as $id) {
                if(!in_array($id, $old)) {
                    $this->assignGroupByID($id);
                }
            }
        }
    }



}
