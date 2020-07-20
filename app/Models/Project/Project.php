<?php

namespace App\Models\Project;

use App\Models\Module;
use App\Models\Requirement\Requirement;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'description', 'project_status_id'];

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function requirements()
    {
        return $this->morphMany(Requirement::class, 'requirementable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
