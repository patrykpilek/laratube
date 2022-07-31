<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UploadVideoController extends Controller
{
    public function index(Channel $channel)
    {
        return Inertia::render('Channels/Upload', [
            'channel' => $channel
        ]);

    }
}
