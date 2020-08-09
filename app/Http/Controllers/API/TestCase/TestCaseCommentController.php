<?php

namespace App\Http\Controllers\API\TestCase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentCreateRequest;
use App\Http\Resources\CommentResource;
use App\Models\TestCase\TestCase;

class TestCaseCommentController extends Controller
{
    public function index(TestCase $testCase)
    {
        return CommentResource::collection($testCase->comments);
    }

    public function store(CommentCreateRequest $request, TestCase $testCase)
    {
        $testCase->comments()->create($request->validated());
    }
}
