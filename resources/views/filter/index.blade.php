<x-app-layout>

    @vite('resources/css/filter/filter.css')

    <div class="filter-wrapper">
        @foreach ($filters as $filter)
            <div class="filter-item" style="background: linear-gradient(155deg, var(--background-color-one) 50%, {{$filter->color}} 110%);">
                <div class='filter-text'>
                    <h1 class="filter-header">{{ $filter->name }}</h1>
                    <div class='filter-color'>
                        {{ $filter->color }}
                    </div>
                </div>

                <form action="{{ route('manage-filters.update', $filter->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <x-color-picker name="color" :options="[
                        'opacity' => false,
                        'value' => '#000000',
                        'default' => '#000000',
                        'theme' => 'classic',
                        'swatches' => null,
                    ]" />
                    <button type="submit" class='filter-update'><i class="fa fa-paint-brush"></i></button>
                </form>

                <div class="filter-delete">
                    <form action="{{ route('manage-filters.destroy', $filter->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"><i class="fa fa-trash"></i></button>
                    </form>
                </div>
            </div>
        @endforeach

            <form action="{{ route('manage-filters.store') }}" method="POST" class="filter-item-create">
                @csrf
                <input type="text" name="name" placeholder="Filter name">
                <x-color-picker name="color" :options="[
                    'opacity' => false,
                    'value' => '#000000',
                    'default' => '#000000',
                    'theme' => 'classic',
                    'swatches' => null,
                ]" />
                <button type="submit" class='filter-save'><i class="fa fa-plus"></i></button>
            </form>

        @vite('resources/js/filter/filter.js')
</x-app-layout>
