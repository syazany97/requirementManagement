<?php

namespace App\Models\Project;

use App\Models\Module;
use App\Models\Requirement\Requirement;
use App\Models\TestCase\TestCase;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    protected $availableRelations = ['requirements', 'modules', 'user'];

    protected $fillable = ['name', 'description', 'project_status_id', 'uuid'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Project $project) {
            $modules = $project->modules()->with(
                ['requirements', 'requirements.assignees',
                    'requirements.comments', 'requirements.testCases.steps',
                    'requirements.testCases.comments'
                ])->get();

            if ($modules->isNotEmpty()) {
                $modules->each(function ($module) {
                    if ($module->requirements->isNotEmpty()) {
                        $module->requirements->each(function (Requirement $requirement) {
                            if ($requirement->testCases->isNotEmpty()) {
                                $requirement->testCases->each(function (TestCase $testCase) {
                                    $testCase->steps()->delete();
                                    $testCase->comments()->delete();
                                    $testCase->delete();
                                });
                            }

                            if ($requirement->comments->isNotEmpty()) {
                                $requirement->comments()->delete();
                            }

                            if ($requirement->assignees->isNotEmpty()) {
                                $requirement->assignees()->detach();
                            }

                            $requirement->delete();
                        });
                    }
                    $module->delete();
                });
            }
        });
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function requirements()
    {
        return $this->hasManyThrough(Requirement::class, Module::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function collaborators()
    {
//        return $this->belongsToMany(User::class, 'user_id', ProjectUserRole::class);
    }

    public function scopeIndex($query, $search = null)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        })->withCount(['modules'])->with(['user:id,name']);
    }
}
