<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ["name", "description"];

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @param $role
     */
    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }
        return $this->roles()->attach($role);
    }

    /**
     * @param $role
     */
    public function assignRoleByID($id)
    {
        if (is_string($id)) {
            $role = Role::find($id);
        }
        return $this->roles()->attach($role);
    }

    /**
     * @param $role
     * @return int
     */
    public function revokeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
            return $this->roles()->detach($role);
        }
    }

    /**
     * @param $role
     * @return int
     */
    public function revokeRoleByID($id)
    {
        if (is_numeric($id)) {
            $role = Role::find($id);
            return $this->roles()->detach($role);
        }
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasRole($name)
    {
        $names = array_map("trim", explode(",",$name));
        foreach($this->roles as $role)
        {
            if (in_array($role->name, $names)) return true;
        }
        return false;
    }

    public function createdby() {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedby() {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
