{{-- Show all the agenda items --}}
<div class="calendar-wrapper">
    <div class="calendar-lines">
        <div class="calendar-hour-line-wrapper">
            @for ($i = 0; $i < 24; $i++)
                <div class="calendar-hour-line"></div>
            @endfor
        </div>

        <div class="calendar-day-line-wrapper">
            @for ($i = 0; $i < 7; $i++)
                <div class="calendar-day-line"></div>
            @endfor
        </div>
    </div>

    <div class="calendar-hours">
        @for ($i = 0; $i < 24; $i++)
            {{-- IF i is < 10, add a 0 --}}
            @if($i < 10)
                <div class="calendar-hour">{{ "0" . $i }}</div>
            @else
                <div class="calendar-hour">{{ $i }}</div>
            @endif
        @endfor
    </div>

    <div class="calendar">
        @foreach($agendaItems as $agendaItem)
            <div class="agenda-item"
                style="grid-row: {{ $agendaItem["startRow"] }} / {{ $agendaItem["endRow"] }}; grid-column: {{ $agendaItem["startColumn"] }} / {{ $agendaItem["endColumn"] }};"
            >
                <h1 class="agenda-item-title">{{ $agendaItem["title"] }}</h1>
                <p class="agenda-item-description">{{ $agendaItem["description"] }}</p>

                <div class="agenda-item-time">
                </div>

                <div class="agenda-item-actions">
                    <form action="{{ route('agenda-items.destroy', ['agenda_item' => $agendaItem['id']]) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- Load the JS --}}
@vite('resources/js/calendar.js')
