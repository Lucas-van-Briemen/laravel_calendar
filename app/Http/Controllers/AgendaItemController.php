<?php

namespace App\Http\Controllers;

use App\Models\AgendaItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgendaItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validatedData = $request->validate([
            'title' => '',
            'description' => '',
            'start' => '',
            'end' => ''
        ]);

        $request->user()->agendaItems()->create($validatedData);

        return redirect()->route('calendar.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(AgendaItem $agendaItem)
    {
        $agendaItem = AgendaItem::find($agendaItem)->first();

        if (!$agendaItem) {
            return redirect()->route('calendar.index');
        }

        return view('agenda-items.show', [
            'agendaItem' => $agendaItem
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AgendaItem $agendaItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AgendaItem $agendaItem)
    {
        //
        $validatedData = $request->validate([
            'title' => '',
            'description' => '',
            'start' => '',
            'end' => ''
        ]);

        $agendaItem->update($validatedData);

        return redirect()->route('calendar.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($agendaItem)
    {
        $agendaItem = AgendaItem::find($agendaItem);
        $agendaItem->delete();

        return redirect()->route('calendar.index');
    }
}
