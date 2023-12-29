<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Response;
use App\Http\Resources\Video\VideoCollection;
use App\Http\Resources\Video\VideoResource;
use Illuminate\Http\Request;
use App\Http\Resources\Tag\TagsCollection;
use App\Models\Tag;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $has = $request->get('has');
        $except = $request->get('except');

        if (!$has) {
            return redirect()->route('index');
        }

        $videos_list = Video::when($has, function ($q, $has) {
            $q->whereHas('tags', function ($q) use ($has) {
                $q->whereIn('tags.id', $has);
            });
        })->when($except, function ($q, $except) {
            $q->whereDoesntHave('tags', function ($q) use ($except) {
                $q->whereIn('tags.id', $except);
            });
        })->withCount(['tags as total_has' => function ($q) use ($has) {
            $q->whereIn('tags.id', $has);
        }, 'tags as total_add' => function ($q) use ($has) {
            $q->whereNotIn('tags.id', $has);
        }])->orderBy('total_has', 'desc')->orderBy('total_add', 'asc')->orderBy('created_at', 'desc')->paginate(12);

        $tags_has = $has ? Tag::whereIn('id', $has)->get() : collect();
        $tags_except = $except ? Tag::whereIn('id', $except)->get() : collect();
        $tags = new TagsCollection(Tag::orderBy('name')->get());

        return inertia('Index', [
            'videos' => new VideoCollection($videos_list),
            'has' => $has,
            'except' => $except,
            'tags_has' => new TagsCollection($tags_has),
            'tags_except' => new TagsCollection($tags_except),
            'tags' => $tags,
            'current_page' => $videos_list->currentPage(),
            'last_page' => $videos_list->lastPage()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        $video->load('tags');
        return inertia('Video/Show', [
            'video' => new VideoResource($video),
        ]);
    }
}
