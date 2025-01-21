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
        if (request('date')) {
            $date = request('date');
        } else {
            // first day of the week
            $dateOffset = date('N') - 1;
            $date = date('Y-m-d', strtotime(date('Y-m-d') . " -$dateOffset day"));
        }

        $agendaItems = $this->getAgendaItems();
        $agendaItems = $this->formatAgendaItems($agendaItems, $date);

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
                'agendaItems' => $agendaItems,

                'timeLineColumn' => date('N', strtotime($date)) + 1,
                'timeLineRow' => (date('H') * 4 + 1 + round(date('i') / 15)) + 4
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

    private function getAgendaItems()
    {
        return
            AgendaItem::
                where('user_id', auth()->id())
                ->where(function ($query) {
                    $query->where('repeating', 'never');
                    $query->whereBetween('start', [
                        date('Y-m-d', strtotime(request('date'))),
                        date('Y-m-d', strtotime(request('date') . ' +7 day'))
                    ]);
                })

                ->orWhere(function ($query) {
                    $query->where('repeating', 'weekly');
                })

                ->orWhere(function ($query) {
                    $query->where('repeating', 'monthly');
                    $startDay = date('j', strtotime(request('date')));
                    $endDay = date('j', strtotime(request('date') . ' +6 day'));

                    $query->whereRaw('DAY(start) BETWEEN ? AND ?', [$startDay, $endDay]);
                })

                ->orWhere(function ($query) {
                    $query->where('repeating', 'yearly');
                    $startDay = date('j', strtotime(request('date')));
                    $endDay = date('j', strtotime(request('date') . ' +6 day'));

                    $startMonth = date('m', strtotime(request('date')));
                    $endMonth = date('m', strtotime(request('date') . ' +6 day'));

                    $query->whereRaw('DAY(start) BETWEEN ? AND ? AND MONTH(start) BETWEEN ? AND ?', [$startDay, $endDay, $startMonth, $endMonth]);
                })

                ->orWhere(function ($query) {
                    $query->where('repeating', 'daily');
                })

                ->orWhere(function ($query) {
                    $query->where('repeating', 'weekdays');
                })

                ->get();
    }

    private function formatAgendaItems($agendaItems, $date)
    {
        $agendaItemsLooped = [];
        foreach ($agendaItems as $agendaItem) {
            $shouldCreateMultipleArray = ["daily", "weekdays"];

            if (!in_array($agendaItem->repeating, $shouldCreateMultipleArray)) {
                $agendaItemsLooped[] = $agendaItem;
            }

            if ($agendaItem->repeating == 'daily') {
                for ($i = 0; $i < 7; $i++) {
                    $agendaItemCopy = clone $agendaItem;

                    //Add I days to the start and end
                    $agendaItemCopy->start = date('Y-m-d H:i:s', strtotime($agendaItemCopy->start . " +$i day"));

                    $agendaItemCopy->end = date('Y-m-d H:i:s', strtotime($agendaItemCopy->end . " +$i day"));

                    $agendaItemsLooped[] = $agendaItemCopy;
                }
            }

            if ($agendaItem->repeating == 'weekdays') {
                for ($i = 0; $i < 5; $i++) {
                    $agendaItemCopy = clone $agendaItem;

                    //Add I days to the start and end
                    $agendaItemCopy->start = date('Y-m-d H:i:s', strtotime($agendaItemCopy->start . " +$i day"));
                    $agendaItemCopy->end = date('Y-m-d H:i:s', strtotime($agendaItemCopy->end . " +$i day"));

                    $agendaItemsLooped[] = $agendaItemCopy;
                }
            }
        }

        $formattedAgendaItems = [];
        foreach ($agendaItemsLooped as $agendaItem) {
            // if the item is repeating weekly, we need to calculate the correct date
            if ($agendaItem->repeating == 'weekly') {
                $dbDateStart = $agendaItem->start;
                $dbDateEnd = $agendaItem->end;

                // swap the date with the date of the current week (but we keep the time and dayoffset)
                $dbOffsetStart = date('N', strtotime($date)) - 1;
                $dbOffsetEnd = date('N', strtotime($date)) - 1;

                //apply the offset
                $agendaItem->start = date('Y-m-d H:i:s', strtotime($date . " +" . $dbOffsetStart . " day " . date('H:i:s', strtotime($dbDateStart))));
                $agendaItem->end = date('Y-m-d H:i:s', strtotime($date . " +" . $dbOffsetEnd . " day " . date('H:i:s', strtotime($dbDateEnd))));
            }

            // If the item is repeating monthly, calculate the correct date
            if ($agendaItem->repeating === 'monthly') {
                $dbDateStart = $agendaItem->start;
                $dbDateEnd = $agendaItem->end;

                $dbTimeStart = date('H:i:s', strtotime($dbDateStart));
                $dbTimeEnd = date('H:i:s', strtotime($dbDateEnd));

                $startDay = date('j', strtotime($dbDateStart));
                $endDay = date('j', strtotime($dbDateEnd));

                $agendaItem->start = date("Y-m-{$startDay} {$dbTimeStart}", strtotime($date));
                $agendaItem->end = date("Y-m-{$endDay} {$dbTimeEnd}", strtotime($date));
            }

            if ($agendaItem->repeating === 'yearly') {
                $dbDateStart = $agendaItem->start;
                $dbDateEnd = $agendaItem->end;

                $dbTimeStart = date('H:i:s', strtotime($dbDateStart));
                $dbTimeEnd = date('H:i:s', strtotime($dbDateEnd));

                $startDay = date('j', strtotime($dbDateStart));
                $endDay = date('j', strtotime($dbDateEnd));

                $startMonth = date('m', strtotime($dbDateStart));
                $endMonth = date('m', strtotime($dbDateEnd));

                $agendaItem->start = date("Y-{$startMonth}-{$startDay} {$dbTimeStart}", strtotime($date));
                $agendaItem->end = date("Y-{$endMonth}-{$endDay} {$dbTimeEnd}", strtotime($date));
            }


            $agendaItem->start = date('Y-m-d H:i:s', strtotime($agendaItem->start));
            $agendaItem->end = date('Y-m-d H:i:s', strtotime($agendaItem->end));

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
                'endColumn' => $endColumn,
                'start' => $agendaItem->start,
                'end' => $agendaItem->end
            ];
        }

        return $formattedAgendaItems;
    }
}
