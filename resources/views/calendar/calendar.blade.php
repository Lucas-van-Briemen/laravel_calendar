{{-- Show all the agenda items --}}
<div class="calendar-wrapper">
    <div class="calendar-hours">
        @for ($i = 0; $i < 24; $i++)
            <div class="calendar-hour">{{ $i }}</div>
        @endfor
    </div>

    <div class="calendar">
        @foreach($agendaItems as $agendaItem)
            <div class="hidden ">
                <h2>{{ $agendaItem->title }}</h2>
            </div>
        @endforeach
    </div>
</div>

{{-- Load the JS --}}
@vite('resources/js/calendar.js')
