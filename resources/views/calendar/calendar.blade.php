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
            </div>
        @endforeach
    </div>
</div>

{{-- Load the JS --}}
@vite('resources/js/calendar.js')
