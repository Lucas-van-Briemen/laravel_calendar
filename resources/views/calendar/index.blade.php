{{-- Load the CSS --}}
@vite('resources/css/calendar-menu.css')
@vite('resources/css/calendar.css')

<x-app-layout>

    @include('calendar.menu')


    <div class="calendar-overview">
        @include('calendar.manager', ['agendaItems' => $agendaItems])
        @include('calendar.calendar')
    </div>

    <form action="{{ route('agenda-items.store') }}" method="POST" hidden>
        @csrf
        <input type="text" name="title" placeholder="Title" id="title">
        <input type="text" name="description" placeholder="Description" id="description">
        <input type="datetime-local" name="start" placeholder="Start" id="start">
        <input type="datetime-local" name="end" placeholder="End" id="end">

        <button type="submit" id="save">Create</button>
    </form>

</x-app-layout>
