// Function to toggle between view and edit modes
function toggleEditMode() {
    const profileSection = document.querySelector('.card-body');
    const editForm = document.getElementById('editProfileForm');

    if (editForm.style.display === 'none') {
        editForm.style.display = 'block'; // Show edit form
        profileSection.style.display = 'none'; // Hide profile view

        // Prefill form fields with current profile info
        document.getElementById('editName').value = document.getElementById('userName').textContent;
        document.getElementById('editBio').value = document.getElementById('userBio').textContent.replace('Bio: ', '');
        document.getElementById('editInterests').value = document.getElementById('userInterests').textContent.replace('Sport Interests: ', '');
        document.getElementById('editLocation').value = document.getElementById('userLocation').textContent.replace('Location: ', '');
    } else {
        editForm.style.display = 'none'; // Hide edit form
        profileSection.style.display = 'block'; // Show profile view
    }
}

// Function to save changes and update profile view
function saveProfile() {
    const name = document.getElementById('editName').value;
    const bio = document.getElementById('editBio').value;
    const interests = document.getElementById('editInterests').value;
    const location = document.getElementById('editLocation').value;

    // Update profile with the new values
    document.getElementById('userName').textContent = name;
    document.getElementById('userBio').textContent = 'Bio: ' + bio;
    document.getElementById('userInterests').textContent = 'Sport Interests: ' + interests;
    document.getElementById('userLocation').textContent = 'Location: ' + location;

    // Toggle back to view mode
    toggleEditMode();
}