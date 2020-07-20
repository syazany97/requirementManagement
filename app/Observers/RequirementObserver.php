<?php

namespace App\Observers;

use App\Models\Requirement\Requirement;

class RequirementObserver
{
    /**
     * Handle the requirement "created" event.
     *
     * @param  \App\Models\Requirement\Requirement  $requirement
     * @return void
     */
    public function created(Requirement $requirement)
    {
        //
    }

    /**
     * Handle the requirement "updated" event.
     *
     * @param  \App\Models\Requirement\Requirement  $requirement
     * @return void
     */
    public function updated(Requirement $requirement)
    {
        //
    }

    /**
     * Handle the requirement "deleted" event.
     *
     * @param  \App\Models\Requirement\Requirement  $requirement
     * @return void
     */
    public function deleted(Requirement $requirement)
    {
        //
    }

    /**
     * Handle the requirement "restored" event.
     *
     * @param  \App\Models\Requirement\Requirement  $requirement
     * @return void
     */
    public function restored(Requirement $requirement)
    {
        //
    }

    /**
     * Handle the requirement "force deleted" event.
     *
     * @param  \App\Models\Requirement\Requirement  $requirement
     * @return void
     */
    public function forceDeleted(Requirement $requirement)
    {
        //
    }
}
