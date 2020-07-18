<?php

namespace App\Models;

use App\Models\Project\Project;
use App\Models\Requirement\Requirement;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['name'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function requirements()
    {
        return $this->morphMany(Requirement::class, 'requirementable');
    }
}
