<?php

namespace App\Http\Controllers;

use App\Models\calendar;
use App\Models\AgendaItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Pest\Mutate\Mutators\Math\RoundToCeil;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agendaItems = AgendaItem::where('user_id', auth()->id())->get()
                                ->whereBetween('start', [date('Y-m-d', strtotime(request('date'))), date('Y-m-d', strtotime(request('date') . ' +7 day'))]);
        $agendaItems = $this->formatAgendaItems($agendaItems);


        $date = request('date') ? request('date') : date('Y-m-d');

        // get the first day of the week
        $date = date('Y-m-d', strtotime($date . " -" . (date('N', strtotime($date)) - 1) . " day"));

        $weekDays = $this->getWeekDays($date);

        $currentDate = date("D, d M");

        $previousWeek = date('Y-m-d', strtotime($date . " -7 day"));
        $nextWeek = date('Y-m-d', strtotime($date . " +7 day"));
        return view(
            'calendar.index',
            [
                'previousWeek' => $previousWeek,
                'nextWeek' => $nextWeek,

                'currentDate' => $currentDate,

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
        //
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

    private function getWeekDays($date)
    {
        $weekDays = [];

        for ($i = 0; $i < 7; $i++) {
            $format = 'D, d M';

            if (date('Y') != date('Y', strtotime($date . " +$i day"))) {
                $format .= ' Y';
            }

            $weekDays[] = date($format, strtotime($date . " +$i day"));
        }

        return $weekDays;
    }

    private function formatAgendaItems($agendaItems)
    {
        $formattedAgendaItems = [];

        foreach ($agendaItems as $agendaItem) {
            $startRow = 0;
            $endRow = 0;
            $startColumn = 0;
            $endColumn = 0;

            $startRow = (date('H', strtotime($agendaItem->start)) * 4) + 1;
            $startRow = $startRow + (round(date('i', strtotime($agendaItem->start)) / 15));

            $endRow = (date('H', strtotime($agendaItem->end)) * 4) + 1;
            $endRow = $endRow + (round(date('i', strtotime($agendaItem->end)) / 15));

            $startColumn = date('N', strtotime($agendaItem->start));
            $endColumn = date('N', strtotime($agendaItem->end));

            $formattedAgendaItems[] = [
                'id' => $agendaItem->id,
                'title' => $agendaItem->title,
                'description' => $agendaItem->description,
                'startRow' => $startRow,
                'endRow' => $endRow,
                'startColumn' => $startColumn,
                'endColumn' => $endColumn
            ];
        }

        return $formattedAgendaItems;
    }
}
