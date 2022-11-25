<?php

namespace App\Observers;

use App\Models\SchoolYear;

class SchoolYearObserver
{
    /**
     * Handle the SchoolYear "created" event.
     *
     * @param  \App\Models\SchoolYear  $schoolYear
     * @return void
     */
    public function saving(SchoolYear $schoolYear)
    {
        //
        $schoolYear->school_year_name = $schoolYear->school_year_start.'/'.$schoolYear->school_year_end;
    }

    /**
     * Handle the SchoolYear "created" event.
     *
     * @param  \App\Models\SchoolYear  $schoolYear
     * @return void
     */
    public function created(SchoolYear $schoolYear)
    {
        //
    }

    /**
     * Handle the SchoolYear "updated" event.
     *
     * @param  \App\Models\SchoolYear  $schoolYear
     * @return void
     */
    public function updated(SchoolYear $schoolYear)
    {
        //
    }

    /**
     * Handle the SchoolYear "deleted" event.
     *
     * @param  \App\Models\SchoolYear  $schoolYear
     * @return void
     */
    public function deleted(SchoolYear $schoolYear)
    {
        //
    }

    /**
     * Handle the SchoolYear "restored" event.
     *
     * @param  \App\Models\SchoolYear  $schoolYear
     * @return void
     */
    public function restored(SchoolYear $schoolYear)
    {
        //
    }

    /**
     * Handle the SchoolYear "force deleted" event.
     *
     * @param  \App\Models\SchoolYear  $schoolYear
     * @return void
     */
    public function forceDeleted(SchoolYear $schoolYear)
    {
        //
    }
}
