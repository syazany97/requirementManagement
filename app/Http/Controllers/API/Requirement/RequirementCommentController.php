<?php

namespace App\Http\Controllers\API\Requirement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentCreateRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment\Comment;
use App\Models\Requirement\Requirement;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RequirementCommentController extends Controller
{
    public function index(Requirement $requirement)
    {
        return CommentResource::collection(Comment::show($requirement)->get());
    }

    public function store(Requirement $requirement, CommentCreateRequest $request)
    {
        return new CommentResource($requirement->comments()->create($request->validated()));
    }

    public function destroy(Comment $comment) {

        try {
            return $comment->delete();
        } catch (\Exception $e) {
            return response()->json($e, 400);
        }
    }
}
