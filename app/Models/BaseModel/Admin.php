<?php

namespace App\Models\BaseModel;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'birthdate', 'password', 'address', 'phone', 'idnumber', 'email_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * constraint role
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function hasGroup($name) {
        if($this->id == 1) return true;
        $names = array_map("trim", explode(",",$name));
        foreach($this->groups as $group)
        {
            if (in_array($group->name, $names)) return true;
        }
        return false;
    }

    /**
     * @param $role
     */
    public function assignGroup($role)
    {
        if (is_string($role)) {
            $role = Group::where('name', $role)->first();
        }
        return $this->groups()->attach($role);
    }

    /**
     * @param $role
     */
    public function assignGroupByID($id)
    {
        if (is_numeric($id)) {
            $group = Group::find($id);
        }
        return $this->groups()->attach($group);
    }

    /**
     * @param $group
     * @return mixed
     */
    public function revokeGroup($group)
    {
        if (is_string($group)) {
            $group = Group::where('name', $group)->first();
        }
        return $this->groups()->detach($group);
    }

    /**
     * @param $group
     * @return mixed
     */
    public function revokeGroupByID($id)
    {
        if (is_numeric($id)) {
            $group = Group::find($id);
        }
        return $this->groups()->detach($group);
    }


    /**
     * @param $name
     * @return bool
     */
    public function hasRole($name)
    {
        if($this->id == 1) return true;
        foreach($this->groups as $group)
        {
            if ($group->hasRole($name)) return true;
        }
        return false;
    }

    public function createdby() {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedby() {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public static function getByRole($role) {
        $admin = self::query()->has('groups')->get();
        $tmp = [];
        foreach ($admin as $a) {
            if($a->hasRole($role))
                $tmp[$a->id] = $a->name;
        }
        return $tmp;
    }

    public static function getByGroup($group) {
        $group = Group::where('name', $group)->first();
        $tmp = [];
        if(empty($group))
            return $tmp;
        foreach ($group->admins as $a) {
            $tmp[$a->id] = $a->name;
        }
        return $tmp;
    }

    public function admin_tasks() {
        return $this->hasMany(AdminTask::class);
    }

    public function taskList() {
        $at = $this->admin_tasks;
        $tmp = [];
        if(!empty($at))
            foreach ($at as $a)
                $tmp[] = $a->submission_id;
        return $tmp;
    }

}