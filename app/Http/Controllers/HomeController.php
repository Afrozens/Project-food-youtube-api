<?php

namespace App\Http\Controllers;

use App\Http\Resources\Tag\TagsCollection;
use App\Models\Tag;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $tags = new TagsCollection(Tag::orderBy('name')->get());
        return Inertia::render('Index', compact('tags'));
    }
}