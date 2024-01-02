<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Alaouy\Youtube\Facades\Youtube;

use App\Models\Tag;
use App\Http\Resources\Tag\TagsCollection;
use App\Http\Resources\Video\VideoCollection;
use App\Http\Resources\Video\VideoResource;
use App\Http\Requests\Admin\VideoRequest;


class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $videos = Video::when($search, function ($q, $search) {
            $q->where('title', 'like', "%$search%");
        })->orderBy('title')->paginate();
        return inertia('Admin/Video', [
            'videos' => new VideoCollection($videos),
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::orderBy('name')->get();
        return inertia('Admin/VideoCreate', [
            'tags' => new TagsCollection($tags),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VideoRequest $request)
    {
        $data = $request->except('tags');
        $data['user_id'] = $request->user()->id;
        $data['code'] = '<>';
        $video = Video::create($data);
        $video->tags()->attach($request->tags);
        return redirect()->route('admin.videos.index')->with([
            'state' => 'El video ha sido agregado'
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
        return inertia('Admin/VideoEach', [
            'video' => new VideoResource($video)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        $tags = Tag::orderBy('name')->get();
        return inertia('Admin/VideoEdit', [
            'tags' => new TagsCollection($tags),
            'video' => new VideoResource($video)
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(VideoRequest $request, Video $video)
    {
        $data = $request->except('tags');
        $video->fill($data);
        $video->save();
        $video->tags()->detach();
        $video->tags()->sync($request->tags);
        return redirect()->route('admin.videos.index')->with([
            'state' => 'El video ha sido actualizado'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        $video->tags()->detach();
        $video->delete();
        return redirect()->back()->with([
            'state' => 'El video ha sido eliminado'
        ]);
    }


    public function youtubeInfo(Request $request)
    {
        $request->validate([
            'url' => ['required', 'regex:"(?:https?:\/\/)?(?:www\.|studio\.)?youtu\.?be(?:\.com)?\/?.*(?:watch|embed|video)?(?:.*v=|v\/|\/)([\w\-_]+)\&?"']
        ]);
        $url = $request->url;
        $video_id = Youtube::parseVidFromURL($url);
        $video_info = Youtube::getVideoInfo($video_id);
        if ($video_info) {
            return response()->json(
                compact(
                    'video_id'
                ),
                200
            );
        } else {
            $message = 'El video no existe o fue eliminado';
            return response()->json([
                'errors' => [
                    'url' => $message
                ]
            ], 422);
        }

    }
}
