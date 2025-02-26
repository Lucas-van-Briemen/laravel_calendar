const databases = document.querySelectorAll('.database-item');

databases.forEach(database => {
    database.addEventListener('click', function () {
        databases.forEach(database => {
            database.classList.remove('active');
        });
        database.classList.add('active');

        const databaseName = database.querySelector('.database-name').innerHTML;
        getTables(databaseName);
    });
});

function getTables(databaseName) {
    fetch('/database/' + databaseName + '/get-tables')
        .then(response => response.json())
        .then(data => {
            console.log(data);
        });
}