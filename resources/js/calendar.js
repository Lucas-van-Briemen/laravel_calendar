const agendaGrid = document.querySelector('.calendar');

const AGENDA_ROW_COUNT = 4 * 24; // 4 rows per 15 minutes
const AGENDA_COLUMN_COUNT = 7; // 7 days a week

let mouseDown = false;

let mouseStart = { x: 0, y: 0 };

agendaGrid.addEventListener('mousedown', (e) => {
    mouseStart = calculateRelativePosition(e.pageX, e.pageY);

    mouseDown = true;
});

agendaGrid.addEventListener('mouseup', (e) => {
    mouseDown = false;
});


agendaGrid.addEventListener('mousemove', (e) => {
    if (mouseDown) {
        const { x, y } = calculateRelativePosition(e.pageX, e.pageY);

        createAgendaItem(x, y);
    }
});


function createAgendaItem(x, y) {
    // Remove all the other agenda items
    removeAllUncreatedAgendaItems();

    const agendaItem = document.createElement('div');
    agendaItem.classList.add('agenda-item-new');

    agendaGrid.appendChild(agendaItem);

    const startPosition = calculateGridPosition(mouseStart.x, mouseStart.y);
    const endPosition = calculateGridPosition(x, y);

    agendaItem.style.gridColumnStart = startPosition.column;
    agendaItem.style.gridRowStart = startPosition.row;

    agendaItem.style.gridColumnEnd = endPosition.column + 1;
    agendaItem.style.gridRowEnd = endPosition.row + 1;

    const startDateTime = calculateDateTime(startPosition.column, startPosition.row - 1);
    const endDateTime = calculateDateTime(endPosition.column, endPosition.row);

    document.querySelector("#start").value = startDateTime;
    document.querySelector("#end").value = endDateTime;
}

function removeAllUncreatedAgendaItems() {
    const agendaItems = agendaGrid.querySelectorAll('.agenda-item-new');
    for (const agendaItem of agendaItems) {
        agendaGrid.removeChild(agendaItem);
    }
}

function calculateGridPosition(x, y) {
    const agendaWidth = agendaGrid.clientWidth;
    const agendaHeight = agendaGrid.scrollHeight;

    const column = Math.ceil(x / agendaWidth * AGENDA_COLUMN_COUNT);
    const row = Math.ceil(y / agendaHeight * AGENDA_ROW_COUNT);

    return { column, row };
}


function calculateRelativePosition(pressX, pressY) {
    const agendaRect = agendaGrid.getBoundingClientRect();
    const scrollTop = agendaGrid.scrollTop;

    const x = pressX - agendaRect.left;
    const y = pressY - agendaRect.top + scrollTop;
    return { x, y };
}
function calculateDateTime(column, row) {
    const DateTime = new Date();

    const dayOfWeek = DateTime.getDay();
    const difference = (dayOfWeek + 6) % 7;
    DateTime.setDate(DateTime.getDate() - difference);

    DateTime.setDate(DateTime.getDate() + column - 1);

    let hours = Math.floor(row / 4);
    let minutes = row % 4 * 15;

    const year = DateTime.getFullYear();
    let month = DateTime.getMonth() + 1;
    let day = DateTime.getDate();

    if (month < 10) {
        month = `0${month}`;
    }

    if (day < 10) {
        day = `0${day}`;
    }

    if (hours < 10) {
        hours = `0${hours}`;
    }

    if (minutes < 10) {
        minutes = `0${minutes}`;
    }

    if (hours === 24) {
        hours = 23;
        minutes = 45;
    }

    const dateString = `${year}-${month}-${day}T${hours}:${minutes}:00`;

    return dateString;
}
