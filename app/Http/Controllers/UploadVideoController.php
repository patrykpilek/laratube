<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class UploadVideoController extends Controller
{
    public function index(Channel $channel)
    {
        return Inertia::render('Channels/Upload', [
            'channel' => $channel
        ]);

    }

    public function store(Request $request, Channel $channel)
    {

        $path = '';

        if ($request->hasFile('video')) {
            $path = Storage::disk('public')->putFile("channels/{$channel->id}", $request->file('video'));
        }

        $channel->videos()->create([
            'title' => $request->title,
            'path' => $path
        ]);

        return Redirect::back();
    }
}
