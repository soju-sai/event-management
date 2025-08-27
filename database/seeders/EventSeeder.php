<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        for ($i=0; $i < 50; $i++) {
            $user = $users->random();
            Event::factory()->create([
                'user_id' => $user->id
            ]);
        }
    }
}
