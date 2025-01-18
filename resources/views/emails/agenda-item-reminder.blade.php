
<!DOCTYPE html>

<html>

<head>
    <title>Test Email</title>

    @vite (['resources/css/app.css', "resources/css/calendar-email.css"])
</head>

<body
    style="
        background-color: var(--background-color) !important;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: var(--gray-text);">

    <main
        style='
            background-color: var(--background-color-one);
            width: 35%;
            height: 50vh;
            padding: 1.5rem;
            border-radius: 32px;
            box-sizing: content-box;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;'>
        <h1
            style="
                font-size: 1.5rem;
                color: var(--header-text);"
        >{{ $agendaItem->title }}</h1>

        <p>{{ $agendaItem->description }}</p>
        <p>{{ "You have an event comming up at " . date($agendaItem->start) }}</p>

        <a
            style="
                padding: 0.5rem;
                border: 1px solid var(--background-color);

                border-radius: 1rem;
                margin-top: 1rem;
                width: 100%;
                text-align: center;

                transition: all .2s ease-in-out;"
            href="{{ route('agenda-items.show', ['agenda_item' => $agendaItem['id']]) }}" class='details-link'>View more details</a>
    </main>

    <style>

    .details-link:hover{
        background-color: var(--background-color);
        color: var(--header-text);
        border-radius: 32px;
    }
    </style>

</body>

</html>
