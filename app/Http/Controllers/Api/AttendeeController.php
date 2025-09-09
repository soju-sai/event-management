<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    use CanLoadRelationships;

    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        $query = $this->loadRelationship($event->attendees());

        return AttendeeResource::collection($query->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $attendee = $event->attendees()->create(['user_id' => 1]);

        return new AttendeeResource($this->loadRelationship($attendee));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, Attendee $attendee)
    {
        return new AttendeeResource($this->loadRelationship($attendee));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Attendee $attendee)
    {
        if (request()->user()->id !== $attendee->user_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $attendee->delete();

        return response(status: 204);
    }
}
