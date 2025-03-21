

  document.addEventListener("DOMContentLoaded", function() {
    // Get the elements
    var updateBtn = document.querySelector(".Updatebtn");
    var updateContainer = document.querySelector(".update-container");

    // Add click event listener to the "Update Profile" button
    updateBtn.addEventListener("click", function(event) {
      // Prevent the default link behavior
      event.preventDefault();

      // Toggle the visibility of the update container
      updateContainer.style.display = (updateContainer.style.display === "none" || updateContainer.style.display === "") ? "flex" : "none";
    });

    // Add click event listener to the "Cancel" button inside the update container
    var closeEditBtn = document.getElementById("close-edit");
    if (closeEditBtn) {
      closeEditBtn.addEventListener("click", function(event) {
        // Prevent the default button behavior
        event.preventDefault();

        // Hide the update container
        updateContainer.style.display = "none";
      });
    }
  });

