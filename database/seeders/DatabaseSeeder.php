<?php

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory(10)->create()->each(function($user) {
            Channel::factory()->create([
                'user_id' => $user->id
            ])->each(function($channel) use ($user) {
                Subscription::factory()->create([
                    'user_id' => $user->id,
                    'channel_id' => $channel->id
                ]);
            });
        });
    }
}
