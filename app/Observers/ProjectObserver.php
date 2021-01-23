<?php

namespace App\Observers;

use App\Models\Project\Project;
use Illuminate\Http\Request;

class ProjectObserver
{
    public function creating(Project $project)
    {
        if (empty($project->user_id)) {
            $project->user_id = auth()->id();
        }
    }

    public function created(Project $project)
    {
        //
    }

    public function updated(Project $project)
    {
        //
    }

    public function deleting(Project $project)
    {
//        $project->requirements()->delete();
//
//        $project->modules()->delete();
    }

    public function deleted(Project $project)
    {
        //
    }

    public function restored(Project $project)
    {
        //
    }

    public function forceDeleted(Project $project)
    {
        //
    }
}
