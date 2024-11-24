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

function formatPlayTime(playTime) {
  const date = new Date(playTime);
  const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
  return date.toLocaleDateString(undefined, options);
}
function likePost(index) {
  // Get posts from localStorage
  const existingPosts = JSON.parse(localStorage.getItem("posts")) || [];

  // Check if the post is already liked
  const post = existingPosts[index];
  post.likedByUser = !post.likedByUser; // Toggle like status

  // Update the like count based on the like status
  post.likes = post.likedByUser ? (post.likes || 0) + 1 : (post.likes || 0) - 1;

  // Update localStorage with the new like count and status
  localStorage.setItem("posts", JSON.stringify(existingPosts));

  // Update the like count and button text in the UI
  const likeButton = document.getElementById(`like-button-${index}`);
  const likeCount = document.getElementById(`like-count-${index}`);
  
  likeCount.innerText = post.likes;
  likeButton.innerText = post.likedByUser ? "Unlike" : "Like";
}

 
// Function to fetch posts from the database
async function fetchPosts() {
  try {
      const response = await fetch('fetch_posts.php');
      const posts = await response.json();

      const postList = document.getElementById("post-list");
      postList.innerHTML = "";

      // Assuming 'userId' is globally available
      const userId = 1; // Replace this with the actual logged-in user ID (perhaps from session/localStorage)

      posts.forEach((post) => {
          const postCard = document.createElement("div");
          postCard.classList.add("card", "mb-3");

          // Check if the user has liked the post
          const hasLiked = post.liked_by_user; // Ensure 'liked_by_user' is returned by your 'fetch_posts.php'

          // Create the Like/Unlike button dynamically
          const likeButton = hasLiked
              ? `<button onclick="toggleLike(${post.id}, false, ${userId})" class="btn btn-outline-danger btn-sm">Unlike</button>`
              : `<button onclick="toggleLike(${post.id}, true, ${userId})" class="btn btn-outline-primary btn-sm">Like</button>`;

          postCard.innerHTML = `
              <div class="card-body">
                  <h6 class="card-title">${post.title}</h6>
                  <p class="card-text"><strong>Play Time:</strong> ${post.play_time}</p>
                  <p class="card-text">${post.content}</p>
                  <p><small class="text-muted">Tags: ${post.tags || 'None'} | Posted by: ${post.user_name} | On: ${post.date}</small></p>
                  ${likeButton}
                  <span id="like-count-${post.id}">${post.likes}</span> likes
              </div>
          `;
          postList.prepend(postCard);
      });
  } catch (error) {
      console.error('Error fetching posts:', error);
  }
}



// Function to handle Like/Unlike button click
async function toggleLike(postId, isLike) {
  try {
      const response = await fetch('toggle_like.php', {
          method: 'POST',
          body: JSON.stringify({ postId, isLike }), // Sending the 'isLike' value
          headers: {
              'Content-Type': 'application/json'
          }
      });
      const result = await response.json();

      if (result.success) {
          const likeButton = document.getElementById(`like-button-${postId}`);
          const likeCount = document.getElementById(`like-count-${postId}`);

          if (result.liked) {
              likeButton.textContent = 'Unlike';
          } else {
              likeButton.textContent = 'Like';
          }

          likeCount.textContent = result.likes;
      } else {
          console.error(result.error);
      }
  } catch (error) {
      console.error('Error toggling like:', error);
  }
}


fetchPosts();

//create posts 
function submitPost() {
  var postTitle = document.getElementById('postTitle').value;
  var postTags = document.getElementById('postTags').value;
  var postContent = document.getElementById('postContent').value;
  var timing = document.getElementById('timing').value;

  // Check if title and content are empty
  if (!postTitle || !postContent) {
      alert('Title and content are required');
      return;
  }

  // Prepare the data to send to the server
  var formData = new FormData();
  formData.append('postTitle', postTitle);
  formData.append('postTags', postTags);
  formData.append('postContent', postContent);
  formData.append('timing', timing);
  console.log(formData);
  
  // Send the data using fetch
  fetch('create_post.php', {
      method: 'POST',
      body: formData
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
        alert("POST CREATED SUCCESSFULLY!");
        window.location.reload();
        closePostModal(); // Close the modal after posting
      } else {
          alert(data.error); // Error message
      }
  })
  .catch(error => {
      console.error('Error creating post:', error);
  });
}




// Clear draft from localStorage after posting
function deleteDraft() {
  localStorage.removeItem("postDraft");
  console.log("Draft cleared");
  closePostModal();
}

// Function to check if the user is logged in
async function checkLoginStatus() {
  try {
      const response = await fetch('check_login.php');
      const result = await response.json();

      const createPostButton = document.getElementById('createPostButton');

      if (result.loggedIn) {
          createPostButton.disabled = false;  // Enable the button if logged in
      } else {
          createPostButton.disabled = true;   // Disable the button if not logged in
      }
  } catch (error) {
      console.error('Error checking login status:', error);
  }
}

// Call checkLoginStatus on page load to check the user’s login status
window.onload = function () {
  checkLoginStatus();
};


// Set max date for the date filter (7 days ahead)
document.getElementById("dateFilter").setAttribute("max", new Date(new Date().setDate(new Date().getDate() + 7)).toISOString().split('T')[0]);

// Load posts from localStorage on page load
document.addEventListener('DOMContentLoaded', function() {
  loadDraft(); // Load the saved draft, if any
});
