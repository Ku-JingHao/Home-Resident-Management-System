/*Add Button*/
document.addEventListener('DOMContentLoaded', function() {
    // Get all elements with the class 'Addbtn'
    var addBtns = document.querySelectorAll('.Addbtn');

    // Get the edit container element
    var editContainer = document.querySelector('.edit-container');

    // Add a click event listener to each 'Addbtn'
    addBtns.forEach(function(addBtn) {
        addBtn.addEventListener('click', function(event) {
            // Prevent the default link behavior
            event.preventDefault();

            // Toggle the display of the edit container
            editContainer.style.display = 'block';
        });
    });

    // Get the close edit button element
    var closeEditBtn = document.getElementById('close-edit');

    // Add a click event listener to the close edit button
    closeEditBtn.addEventListener('click', function() {
        // Hide the edit container when the close button is clicked
        editContainer.style.display = 'none';
    });
});

