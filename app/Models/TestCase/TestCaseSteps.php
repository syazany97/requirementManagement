<?php

namespace App\Models\TestCase;

use Illuminate\Database\Eloquent\Model;

class TestCaseSteps extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_passed' => 'boolean'
    ];
}
