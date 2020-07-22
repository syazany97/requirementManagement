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
    /**
     * Display a listing of the resource.
     *
     * @param Requirement $requirement
     * @return AnonymousResourceCollection
     */
    public function index(Requirement $requirement)
    {
        $comments = Comment::where('commentable_type', Requirement::class)
            ->where('commentable_id', $requirement->id)
            ->get();

        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Requirement $requirement
     * @param CommentCreateRequest $request
     * @return CommentResource
     */
    public function store(Requirement $requirement, CommentCreateRequest $request)
    {
        return new CommentResource($requirement->comments()->create($request->validated()));
    }

    /** Delete comment
     * @param Comment $comment
     * @return bool|null
     */
    public function destroy(Comment $comment) {

        try {
            return $comment->delete();
        } catch (\Exception $e) {
            return response()->json($e, 400);
        }
    }
}
