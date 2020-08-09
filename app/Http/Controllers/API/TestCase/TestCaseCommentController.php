<?php

namespace App\Http\Controllers\API\TestCase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentCreateRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment\Comment;
use App\Models\TestCase\TestCase;

class TestCaseCommentController extends Controller
{
    public function index(TestCase $testCase)
    {
        $comments = Comment::where('commentable_type', TestCase::class)
            ->where('commentable_id', $testCase->id)
            ->with(['user'])
            ->get();
        return CommentResource::collection($comments);
    }

    public function store(CommentCreateRequest $request, TestCase $testCase)
    {
        $testCase->comments()->create($request->validated());
    }
}
