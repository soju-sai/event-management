<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Notifications\EventEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class EmailReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:email-reminder-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders for events';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $events = Event::with('user')
            ->whereBetween('start_time', [Carbon::now(), Carbon::now()->add(1, 'day')])
            ->get();

        $events->each(
            fn($event) => $event->attendees->each(
                fn($attendee) => $attendee->user->notify(new EventEmail($event))
                // fn($attendee) => $this->info("Notifying the user {$attendee->user->id}")
            )
        );
    }
}
