<?php

namespace App\Models\TestCase;

use Illuminate\Database\Eloquent\Model;

class TestCaseSteps extends Model
{
    protected $fillable = ['id', 'comment',
        'description',
        'input',
        'expected_result',
        'order',
        'is_passed'];

    protected $casts = [
        'is_passed' => 'boolean'
    ];
}
