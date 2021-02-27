<?php

namespace App\Http\Controllers\API\TestCase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentCreateRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment\Comment;
use App\Models\TestCase\TestCase;
use PHPUnit\Util\Test;

class TestCaseCommentController extends Controller
{
    public function index(TestCase $testCase)
    {
        return CommentResource::collection($testCase->comments()->with(['user'])->get());
    }

    public function store(CommentCreateRequest $request, TestCase $testCase)
    {
        return $testCase->comments()->create($request->validated());
    }
}
