<?php

namespace App\Modules\AdminManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Role;
use App\Models\BaseModel\Admin as BaseAdmin;

class Admin extends BaseAdmin
{

    public function advancedSearch(Request $request) {
        $user = new Admin();
        return $user
            ->where("name", 'like', "%$request->name%")
            ->orWhere("username", "like", "%$request->search%")
            ->paginate(10)
            ->load("invoices");
    }

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
        if(count($new) == 0) {
            foreach ($old as $id) {
                if(!in_array($id, $new)) {
                    $this->revokeGroupByID($id);
                }
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
