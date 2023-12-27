<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Resources\Tag\TagsCollection;
use App\Http\Resources\Tag\TagResource;
use App\Http\Requests\Admin\TagRequest;

class OtherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $list = Tag::when($search, function ($q, $search) {
            $q->where('name', 'like', "%$search%");
        })->orderBy('name')->get();
        $tags = new TagsCollection($list);
        return inertia('admin/other/template', compact(
            'tags', 'search'
        ));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        $data = $request->all();
        Tag::create($data);
        $state = 'Se ha agregado un nuevo tag.';
        return redirect()->back()->with(compact(
            'state'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $data = $request->all();
        $tag->fill($data);
        $tag->save();
        $state = 'Se ha actualizado un tag.';
        return redirect()->back()->with(compact(
            'state'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->videos()->detach();
        $tag->delete();
        $state = 'Se ha eliminado un tag.';
        return redirect()->back()->with(compact(
            'state'
        ));
    }
}
