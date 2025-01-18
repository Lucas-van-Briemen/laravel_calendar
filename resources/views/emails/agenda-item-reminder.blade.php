
<!DOCTYPE html>

<html>

<head>
    <title>Test Email</title>

    @vite (['resources/css/app.css', "resources/css/calendar-email.css"])
</head>

<body>

    <main>
        <h1>{{ $agendaItem->title }}</h1>

        <p>{{ $agendaItem->description }}</p>
        <p>{{ "You have an event comming up at " . date($agendaItem->start) }}</p>

        <a href="{{ route('agenda-items.show', ['agenda_item' => $agendaItem['id']]) }}" class='details-link'>View more details</a>
    </main>

</body>

</html>
