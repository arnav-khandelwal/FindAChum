// Open the post modal
function openPostModal() {
  document.getElementById("postModal").style.display = "block";
  loadDraft(); // Load the saved draft, if any
}

// Close the post modal
function closePostModal() {
  document.getElementById("postModal").style.display = "none";
  document.getElementById("newPostForm").reset(); // Reset the form after closing
}

// Save the post draft to localStorage
function saveDraft() {
  const postTitle = document.getElementById("postTitle").value;
  const postTags = document.getElementById("postTags").value;
  const postContent = document.getElementById("postContent").value;
  const playTime = document.getElementById("timing").value; // Corrected to "timing"
  
  if (!postTitle || !postContent) {
    alert("Please fill out the title and content.");
    return;
  }

  // Save the draft to localStorage
  const postDraft = {
    title: postTitle,
    tags: postTags,
    content: postContent,
    playTime: playTime
  };
  localStorage.setItem("postDraft", JSON.stringify(postDraft));

  console.log("Draft saved:", postDraft);
}

// Load the saved draft from localStorage
function loadDraft() {
  const savedDraft = localStorage.getItem("postDraft");
  if (savedDraft) {
    const { title, tags, content, playTime } = JSON.parse(savedDraft); // Include playTime in destructuring
    document.getElementById("postTitle").value = title;
    document.getElementById("postTags").value = tags;
    document.getElementById("postContent").value = content;
    document.getElementById("timing").value = playTime || ''; // Corrected to "timing"
    console.log("Draft loaded:", { title, tags, content, playTime });
  }
}

// Submit the post and add it to the Recent Posts section, saving to localStorage
function submitPost() {
  const postTitle = document.getElementById("postTitle").value;
  const postTags = document.getElementById("postTags").value;
  const postContent = document.getElementById("postContent").value;
  const playTimeInput = document.getElementById("timing").value; // Input from datetime-local

  if (!postTitle || !postContent) {
    alert("Please fill out the title and content.");
    return;
  }

  // Format playTime for display (e.g., "Saturday, September 23, 2024, 10:00 AM")
  const playTime = playTimeInput ? new Date(playTimeInput).toLocaleString("en-US", {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "numeric",
    minute: "numeric",
    hour12: true
  }) : 'not specified';

  // Create a new post object
  const newPost = {
    title: postTitle,
    tags: postTags,
    content: postContent,
    playTime: playTime, // Store formatted play time
    date: new Date().toLocaleString() // Store the current date and time
  };

  // Add the new post to localStorage
  const existingPosts = JSON.parse(localStorage.getItem("posts")) || [];
  existingPosts.push(newPost);
  localStorage.setItem("posts", JSON.stringify(existingPosts));
  closePostModal();
  
  // Display the new post in the UI
  displayPosts();

  // Clear the draft and close the modal
  deleteDraft();
}


// Display all posts from localStorage
function displayPosts() {
  const postList = document.getElementById("post-list");
  postList.innerHTML = ""; // Clear the current list

  const existingPosts = JSON.parse(localStorage.getItem("posts")) || [];

  // Add each post to the post list
  existingPosts.forEach(post => {
    const postCard = document.createElement("div");
    postCard.classList.add("card", "mb-3");
    postCard.innerHTML = `
      <div class="card-body">
        <h6 class="card-title">${post.title}</h6>
        <p class="card-text">${post.playTime || 'not specified'}</p>
        <p class="card-text">${post.content}</p>
        <p><small class="text-muted">Tags: ${post.tags || 'None'} | Posted on: ${post.date}</small></p>
      </div>
    `;
    postList.prepend(postCard); // Add the post at the top of the list
  });
}

// Clear draft from localStorage after posting
function deleteDraft() {
  localStorage.removeItem("postDraft");
  console.log("Draft cleared");
  closePostModal();
}

// Set max date for the date filter (7 days ahead)
document.getElementById("dateFilter").setAttribute("max", new Date(new Date().setDate(new Date().getDate() + 7)).toISOString().split('T')[0]);

// Load posts from localStorage on page load
document.addEventListener('DOMContentLoaded', function() {
  loadDraft(); // Load the saved draft, if any
  displayPosts(); // Load the saved posts
});
