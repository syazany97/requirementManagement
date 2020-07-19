<?php

namespace App\Observers;

use App\Models\Project\Project;

class ProjectObserver
{
    public function creating(Project $project)
    {
//        $project->user_id = auth()->user()->id;
    }

    public function created(Project $project)
    {
        //
    }

    public function updated(Project $project)
    {
        //
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
