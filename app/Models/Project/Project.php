<?php

namespace App\Models\Project;

use App\Models\Module;
use App\Models\Requirement\Requirement;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'description'];

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function requirements()
    {
        return $this->morphMany(Requirement::class, 'requirementable');
    }
}
