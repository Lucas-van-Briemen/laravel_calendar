{{-- Load the CSS --}}
@vite('resources/css/calendar.css')

<x-app-layout>

    @include('calendar.menu')


    <div class="calendar-overview">
        @include('calendar.manager', ['agendaItems' => $agendaItems])
        @include('calendar.calendar')
    </div>

    <form action="{{ route('calendar.store') }}" method="POST" hidden>
        @csrf
        <input type="text" name="title" placeholder="Title">
        <input type="text" name="description" placeholder="Description">
        <input type="datetime-local" name="start" placeholder="Start" id="start">
        <input type="datetime-local" name="end" placeholder="End" id="end">

        <button type="submit">Create</button>
    </form>

</x-app-layout>
