<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Channel $channel)
    {
        $channel->subscriptions()->create([
            'user_id' => auth()->user()->id
        ]);

        return redirect()->back();
    }

    public function destroy(Channel $channel, Subscription $subscription)
    {

        $subscription->delete();

        return redirect()->back();
    }
}
