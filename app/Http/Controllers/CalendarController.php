<?php

namespace App\Http\Controllers;

use App\Models\calendar;
use App\Models\AgendaItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agendaItems = AgendaItem::where('user_id', auth()->id())->get();

        $date = request('date') ? request('date') : date('Y-m-d');

        // get the first day of the week
        $date = date('Y-m-d', strtotime($date . " -" . (date('N', strtotime($date)) - 1) . " day"));

        $weekDays = [];

        for ($i = 0; $i < 7; $i++) {
            $format = "D, d M";

            //if it issnt the current year
            if (date('Y') != date('Y', strtotime($date . " +$i day"))) {
                $format = "D, d M Y";
            }

            $weekDays[] = date($format, strtotime($date . " +$i day"));
        }

        $previousWeek = date('Y-m-d', strtotime($date . " -7 day"));
        $nextWeek = date('Y-m-d', strtotime($date . " +7 day"));
        return view(
            'calendar.index',
            [
                'previousWeek' => $previousWeek,
                'nextWeek' => $nextWeek,

                'weekDays' => $weekDays,
                'agendaItems' => $agendaItems
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => '',
            'description' => '',
            'start' => '',
            'end' => ''
        ]);

        $request->user()->agendaItems()->create($validatedData);

        return response()->json(['message' => 'Agenda item created successfully'], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(calendar $calendar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(calendar $calendar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, calendar $calendar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(calendar $calendar)
    {
        //
    }
}
