<x-app-layout>
   <div class="database-menu-wrapper">
        @foreach ($databases as $database)
            <div class="database-item">
                <div class="database-name">{{ $database->Database }}</div>
            </div>
        @endforeach
   </div>

   @include('database.tables')

    @vite('resources/css/database/side-menu.css')
    @vite('resources/js/database/side-menu.js')
</x-app-layout>