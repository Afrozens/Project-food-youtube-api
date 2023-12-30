<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Video;
use App\Models\Tag;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $total_videos = Video::count();
        $total_tags = Tag::count();
        $total_admin = 0;
        $total_users = 0;
        if ($request->user()->hasRole('Super Admin')) {
            $total_admin = User::role('admin')->count();
            $total_users = User::doesntHave('roles')->count();
        }

        return inertia('Admin/Home', compact(
            'total_videos', 'total_tags', 'total_admin', 'total_users'
        ));

    }
}
