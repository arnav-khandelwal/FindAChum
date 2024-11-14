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

function formatTiming() {
  const timingInput = document.getElementById('timing').value;
  const formattedTimingElement = document.getElementById('formattedTiming');

  if (timingInput) {
      const date = new Date(timingInput);
      const options = { 
          weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', 
          hour: '2-digit', minute: '2-digit' 
      };
      const formattedDate = date.toLocaleDateString(undefined, options);
      formattedTimingElement.textContent = `Selected date: ${formattedDate}`;
  } else {
      formattedTimingElement.textContent = '';
  }
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
  const playTime = document.getElementById("timing").value;

  if (!postTitle || !postContent) {
    alert("Please fill out the title and content.");
    return;
  }
  const formattedPlayTime = playTime ? formatPlayTime(playTime) : 'not specified';

  // Create a new post object with an initial like count
  const newPost = {
    title: postTitle,
    tags: postTags,
    content: postContent,
    playTime: playTime,
    date: new Date().toLocaleString(), // Store the current date and time
    likes: 0 // Initial like count
  };

  // Add the new post to localStorage
  const existingPosts = JSON.parse(localStorage.getItem("posts")) || [];
  existingPosts.push(newPost);
  localStorage.setItem("posts", JSON.stringify(existingPosts));

  // Display the new post in the UI
  displayPosts();

  // Clear the draft and close the modal
 
  deleteDraft();
  closePostModal();
}
function formatPlayTime(playTime) {
  const date = new Date(playTime);
  const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
  return date.toLocaleDateString(undefined, options);
}
function likePost(index) {
  // Get posts from localStorage
  const existingPosts = JSON.parse(localStorage.getItem("posts")) || [];

  // Increment like count for the specific post
  existingPosts[index].likes = (existingPosts[index].likes || 0) + 1;

  // Update localStorage with the new like count
  localStorage.setItem("posts", JSON.stringify(existingPosts));

  // Update the like count in the UI
  document.getElementById(`like-count-${index}`).innerText = existingPosts[index].likes;
}
 
// Display all posts from localStorage
function displayPosts() {
  const postList = document.getElementById("post-list");
  postList.innerHTML = ""; // Clear the current list

  const existingPosts = JSON.parse(localStorage.getItem("posts")) || [];

  // Add each post to the post list
  existingPosts.forEach((post , index) => {
    const postCard = document.createElement("div");
    postCard.classList.add("card", "mb-3");
    if (post.likes === undefined) post.likes = 0;
    postCard.innerHTML = `
      <div class="card-body">
        <h6 class="card-title">${post.title}</h6>
       <p class="card-text"><strong>Play Time:</strong> ${post.playTime}</p>
        <p class="card-text">${post.content}</p>
        <p><small class="text-muted">Tags: ${post.tags || 'None'} | Posted on: ${post.date}</small></p>
        <div>
          <button onclick="likePost(${index})" class="btn btn-outline-primary btn-sm">Like</button>
          <span id="like-count-${index}">${post.likes}</span> likes
        </div>
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
