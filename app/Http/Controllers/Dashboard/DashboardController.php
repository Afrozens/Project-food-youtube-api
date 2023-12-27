<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Profile\ImageRequest;
use Illuminate\Support\Facades\Storage;

use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard');
    }

    public function image(ImageRequest $request)
    {
        $user = $request->user();
        if ($user->img_url)
            Storage::delete($user->img_url);
        $img_path = $request->image->store('profile/users', 'public');
        $user->fill([
            'img_url' => Storage::url($img_path)
        ]);
        $user->save();
        $message = 'Su imagen ha sido actualizada.';
        return back()->with([
            'state' => $message
        ]);
    }
}