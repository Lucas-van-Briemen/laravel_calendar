{{-- Load the CSS --}}
@vite('resources/css/agenda-item.css')

<x-app-layout>

    <div class="go-back">
        <a href="{{ route('calendar.index') }}">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
    </div>

    <form action="{{ route('agenda-items.update', $agendaItem) }}" method="POST">
        @csrf
        @method('patch')

        <div class="form-group">
            <h1>{{ "General Details" }}</h1>

            <div class="input-wrapper">
                <input type="text" name="title" placeholder=" " id="title" value='{{ $agendaItem["title"] }}'>
                <label for="title" class="form-label">Title</label>
            </div>

            <div class="input-wrapper">
                <textarea type="text" name="description" placeholder=" " id="description">{{ $agendaItem["description"] }}</textarea>
                <label for="description" class="form-label">Description</label>
            </div>

            <div class="input-wrapper">
                <input type="datetime-local" name="start" placeholder=" " id="start" value='{{ $agendaItem["start"] }}'>
                <label for="start" class="form-label">Start</label>
            </div>

            <div class="input-wrapper">
                <input type="datetime-local" name="end" placeholder=" " id="end" value='{{ $agendaItem["end"] }}'>
                <label for="end" class="form-label">End</label>
            </div>

            <button type="submit" class='btn btn-save'>Save</button>
        </div>


    </form>

</x-app-layout>
