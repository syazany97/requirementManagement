<?php

namespace App\Http\Controllers\API\TestCase;

use App\Http\Controllers\Controller;
use App\Models\TestCase\TestCase;
use Illuminate\Http\Request;

class TestCaseLogController extends Controller
{
    public function __invoke(TestCase $testCase)
    {
        return $testCase->activities;
    }
}
