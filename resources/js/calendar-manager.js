const managerItems = document.querySelectorAll('.calendar-manager-header-item');


managerItems.forEach(item => {
    item.addEventListener('click', () => {

        const activeItem = document.querySelector('.calendar-manager-active');
        activeItem.classList.remove('calendar-manager-active');

        if(item === activeItem){
            return;
        }

        const blob = document.querySelector('.calendar-manager-blob');
        // move the blob
        blob.style.left = item.offsetLeft;

        item.classList.toggle('calendar-manager-active');
    });
});
