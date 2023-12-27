<?php

namespace App\Helpers;

use Alaouy\Youtube\Facades\Youtube;
use App\Models\Video;

class CommentsHelper
{

    public static function getComments(Video $video)
    {
        $c_youtube = self::youtube($video->videoId);
        $list = collect();
        $list->push($c_youtube);
        $list = $list->collapse();
        return $list->sortBy([
            ['created_at', 'desc']
        ]);
    }
    public static function getCommentsUser(Video $video)
    {
        $c_list = self::comments($video);
        $list = collect();
        $list->push($c_list);
        $list = $list->collapse();
        return $list->sortBy([
            ['created_at', 'asc']
        ]);
    }

    public static function youtube($video_id)
    {
        $comment_list = collect(Youtube::getCommentThreadsByVideoId($video_id));
        $list = $comment_list->map(function ($comment) {
            $data = $comment->snippet->topLevelComment->snippet;
            return [
                'id' => $comment->id,
                'name' => $data->authorDisplayName,
                'img' => $data->authorProfileImageUrl,
                'content' => $data->textDisplay,
                'created_at' => $data->publishedAt
            ];
        });
        return $list;
    }

    public static function comments(Video $video)
    {
        $comment_list = $video->comments()->whereHas('user')->with('user')->get();
        $list = $comment_list->map(function ($comment) {
            return [
                'id' => $comment->id,
                'user_id' => $comment->user->id,
                'name' => $comment->user->name,
                'img' => $comment->user->img,
                'content' => $comment->content,
                'created_at' => $comment->created_at
            ];
        });
        return $list;
    }
}
