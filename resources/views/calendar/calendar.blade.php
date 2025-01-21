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
            @if($i < 10)
                <div class="calendar-hour">{{ "0" . $i }}</div>
            @else
                <div class="calendar-hour">{{ $i }}</div>
            @endif
        @endfor
    </div>

    <div class="calendar">

        <div class="current-time-line" style="grid-row: {{ $timeLineRow }}; grid-column: {{ $timeLineColumn }};"></div>

        @foreach($agendaItems as $agendaItem)
            <div class="agenda-item"
                style="grid-row: {{ $agendaItem["startRow"] }} / {{ $agendaItem["endRow"] }}; grid-column: {{ $agendaItem["startColumn"] }} / {{ $agendaItem["endColumn"] }};"
            >

                <div class="agenda-item-details">
                    <h1 class="agenda-item-title">{{ $agendaItem["title"] }}</h1>
                    <p class="agenda-item-description">{{ $agendaItem["description"] }}</p>

                    <div class="agenda-item-time">
                        <p>{{ date('H:i', strtotime($agendaItem["start"])) }} - {{ date('H:i', strtotime($agendaItem["end"])) }}</p>
                    </div>
                </div>

                <div class="agenda-item-actions">
                    <a href="{{ route('agenda-items.show', ['agenda_item' => $agendaItem['id']]) }}">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>


                    <form action="{{ route('agenda-items.destroy', ['agenda_item' => $agendaItem['id']]) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- Load the JS --}}
@vite('resources/js/calendar.js')
