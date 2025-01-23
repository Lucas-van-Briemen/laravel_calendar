const colorInputs = document.querySelectorAll('.filter-color');

colorInputs.forEach((colorInput) => {
   colorInput.addEventListener('click', () => {
       colorInput.querySelector('form input[type="hidden"]').click();
   });
});
