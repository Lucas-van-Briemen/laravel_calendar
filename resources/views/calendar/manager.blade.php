<div class="calendar-manager">
    <div class="calendar-manager-header">
        <div class="calendar-manager-blob"></div>
        <div class='calendar-manager-active calendar-manager-header-item'>{{ __('Display') }}</div>
        <div class='calendar-manager-header-item'>{{ __('Info') }}</div>
    </div>

    <div class='calendar-manager-display'>
        <div class='manager-item'>
            <h1 class='manager-item-title'>Filter</h1>
            <div class='manager-item-content'>
                <a href="/manage-filters">Manage filters</a>
            </div>
        </div>

        <div class='manager-item'>
            <h1 class='manager-item-title'>Calendars</h1>
        </div>

            <div class='manager-item'>
            <h1 class='manager-item-title'>Display</h1>
            <div class='manager-item-content'>
                <select name="view">
                    <option value="month">Month</option>
                    <option value="week">Week</option>
                    <option value="day">Day</option>
                </select>
            </div>
        </div>
    </div>

</div>

@vite('resources/js/calendar-manager.js')
