<?php

namespace App\Models;

use App\Models\Project\Project;
use App\Models\Requirement\Requirement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'numbering', 'parent_id', 'uuid'];

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

    public function scopeCompleteInformation($query)
    {
        return $query->where('parent_id', null)
            ->with([
                'children.requirements.assignees',
                'children.requirements.priority',
                'requirements.assignees',
                'requirements.priority']);
    }
}
