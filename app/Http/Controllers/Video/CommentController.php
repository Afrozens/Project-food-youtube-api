<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Video;
use App\Helpers\CommentsHelper;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Video $video)
    {
        $comment_list = CommentsHelper::getComments($video);
        $comment_user = CommentsHelper::getCommentsUser($video);
        return response()->json([
            'comments' => $comment_list,
            'chats' => $comment_user
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Video|null $video
     * @return Response
     */
    public function store(Request $request, ?Video $video)
    {
        $content = $request->all();
        $user = $request->user();
        $comment = $video->comments()->create([
            'user_id' => $user->id,
            'content' => \request("content")
        ]);
        $message = 'Comentario agregado.';
        $comment->load('user');
        return response()->json([
            'message' => $message,
            'comment' => new CommentResource($comment)
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video, Comment $comment)
    {
        $content = \request("content");
        $comment->fill([
            'content' => $content
        ]);
        $comment->save();
        $comment->fresh();
        $message = 'Comentario editado.';
        $comment->load('user');
        return response()->json([
            'message' => $message,
            'comment' => new CommentResource($comment)
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video, Comment $comment)
    {
        $comment->delete();
        $message = 'El comentario ha sido eliminado.';
        return response()->json(compact(
            'message'
        ), 200);
    }
}
