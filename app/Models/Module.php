<?php

namespace App\Models;

use App\Models\Project\Project;
use App\Models\Requirement\Requirement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Module extends Model
{
    protected $fillable = ['name', 'numbering', 'parent_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function requirements()
    {
        return $this->hasMany(Requirement::class, 'module_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')
            ->with('children')
            ->orderBy('numbering', 'asc');
    }

    public function scopeCompleteInformation($query, $projectId )
    {
        return $query->where('parent_id', null)
            ->where('project_id', $projectId)
            ->with([
                'children.requirements.assignees',
                'children.requirements.priority',
                'children.requirements.comments.user'
            ]);
    }

}
