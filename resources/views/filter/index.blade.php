<x-app-layout>

    @vite('resources/css/filter/filter.css')

    <div class="filter-wrapper">
        @foreach ($filters as $filter)
            <div class="filter-item">
                <h1 class="filter-header">{{ $filter->name }}</h1>
                <div class='filter-color'>
                    {{ $filter->color }}
                    <form action="{{ route('manage-filters.update', $filter->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="color" value="{{ $filter->color }}">
                        <button type="submit"><i class="fa fa-paint-brush"></i></button>
                    </form>
                </div>

                <div class="filter-delete">
                    <form action="{{ route('manage-filters.destroy', $filter->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"><i class="fa fa-trash"></i></button>
                    </form>
                </div>
            </div>
        @endforeach
</x-app-layout>
