<?php

namespace App\Observers;

use App\Models\Module;
use App\Models\Requirement\Requirement;

class RequirementObserver
{
    public function creating(Module $module, Requirement $requirement)
    {
        if(empty($requirement->numbering)) {
            $latestModule = $module->requirements->sortByDesc('numbering')->first();

            if($latestModule) {
                $numbering = intval($latestModule->numbering) + 1;
            } else {
                $numbering = 1.0;
            }

            $requirement->numbering = $numbering;
        }

    }
    public function created(Requirement $requirement)
    {
        //
    }

    public function updated(Requirement $requirement)
    {
        //
    }

    public function deleted(Requirement $requirement)
    {
        //
    }

    public function restored(Requirement $requirement)
    {
        //
    }

    public function forceDeleted(Requirement $requirement)
    {
        //
    }
}
