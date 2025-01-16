<div class="calendar-menu">
    <div class="week-selecter">
        <a href="{{ route('calendar.index', ['date' => $previousWeek]) }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>
        </a>

        <a href="{{ route('calendar.index') }}">
            {{ "This week" }}
        </a>

        <a href="{{ route('calendar.index', ['date' => $nextWeek]) }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </a>
    </div>

    <div class="week-days-overview-wrapper">
        <div class="week-days-overview">
            @foreach($weekDays as $weekDay)
                @if($currentDate === $weekDay)
                    <div class="week-day-overview week-day-overview-current">{{ $weekDay }}</div>
                @else
                    <div class="week-day-overview">{{ $weekDay }}</div>
                @endif
            @endforeach
        </div>
    </div>
</div>
