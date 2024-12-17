# Sports Social Media Web Application  

Arnav A platform designed to connect sports enthusiasts by allowing them to post and discover sports activities, find teammates or opponents, and foster a community around shared interests in sports and fitness.  

## Features  

### User Profiles  
- Personalized profiles displaying user details like bio, location, age, interests, and social media links (Instagram, Twitter).  
- Profile pictures with default placeholders if not uploaded.  

### Friends System  
- Add or remove friends with real-time UI updates.  
- Friend status is dynamically displayed based on user interaction (Add Friend/Remove Friend).  
- Friendship management integrated into user profiles.  

### Posts  
- Users can create posts detailing sports activities, including titles, content, tags, and playtime.  
- Posts can include filters (e.g., by sport or date) and sorting options (by time, popularity, or upcoming events).  
- Like functionality with real-time updates for the count and button status (Like/Unlike).  

### Post Sorting and Filtering  
- **Sorting Options**:  
  - *Time*: Displays posts in reverse chronological order.  
  - *Hot*: Displays posts with the highest number of likes.  
  - *Rising*: Displays posts by the soonest playtime.  
- **Filtering Options**:  
  - Filter by specific sports or dates to focus on relevant activities.  

### Theme Management  
- Toggle between light and dark themes, with user preference saved in `localStorage`.  

### Responsive Design  
- Fully responsive UI using Bootstrap, ensuring accessibility on all devices.  

## Tech Stack  
- **Frontend**: HTML, CSS (including Bootstrap), JavaScript  
- **Backend**: PHP, MySQL  
- **Database**: MySQL for user data, posts, likes, and friendships.  
- **Tools**: Fetch API for AJAX calls, localStorage for theme persistence.  

## Features in Progress and Known Issues

Here are the functionalities that are either not working at the moment or are still being worked on:

1. **Likes Functionality**: 
   - The like/unlike functionality for posts is still under development. This will allow users to interact with posts by liking or unliking them. The front-end interface is ready, but back-end integration and real-time updates are pending.

2. **Dark-Light Theme Functionality**:
   - The toggle for switching between dark and light themes is not fully operational. While the interface exists, the dynamic theme switch functionality and storing the user's theme preference are still in progress.

3. **Sorting and Filtering Functionality**:
   - Sorting posts by time, popularity (hot), and rising trends is yet to be fully implemented. The filters for date and sport selection are in place but need improvements to handle post-filtering correctly in real time.

4. **Remove Friends Functionality**:
   - The feature to remove friends from your friends list is still under development. Users can send friend requests, but the removal process from the friend list hasn't been completed yet.

5. **Notifications**:
   - A notification system for activities such as new friend requests likes on posts, and other interactions is being worked on. This feature will provide real-time alerts for various actions within the app.

6. **Sending Pending Friend Requests to Notification System for Acceptance**:
   - Pending friend requests are yet to be integrated into the notification system. Users will be able to see pending requests in the notifications section for easier management and acceptance/rejection.


## Installation  

### Prerequisites  
- A web server (e.g., Apache or Nginx) with PHP support.  
- MySQL server for database operations.  

### Steps  
1. Clone the repository:  
   ```bash  
   git clone https://github.com/your-username/sports-social-media.git  
   cd sports-social-media  
2. Import the `database.sql` file into your MySQL database.  
   - Use a tool like phpMyAdmin or the MySQL command line to import the file:  
     ```bash
     mysql -u your_username -p your_database_name < database.sql
     ```  

3. Update the database credentials in the `db_connection.php` file to match your MySQL setup:  
   ```php
   $servername = "your_server";
   $username = "your_username";
   $password = "your_password";
   $dbname = "your_database_name";
   
4. Start your web server and ensure the application is accessible in your browser.  
   - If using **XAMPP**, move the project folder to the `htdocs` directory and access it at:  
     ```
     http://localhost/sports-social-media
     ```  
   - If using another web server, configure the server to point to the project directory.  

5. Login or sign up to begin using the platform.

## Features  
### 1. **User Management**  
   - Sign up and login securely.  
   - View and update user profiles.  

### 2. **Friends Functionality**  
   - Send and receive friend requests.  
   - Accept or reject friend requests.  
   - View a list of friends on your profile.  

### 3. **Posts and Activities**  
   - Create posts to share sports activities, including time, location, and participant details.  
   - View and filter posts by sport or date.  
   - Like or unlike posts and see the like count update in real time.  

### 4. **Sorting and Filtering**  
   - Sort posts by:  
     - Time (recent posts).  
     - Hot (most liked).  
     - Rising (upcoming activities).  
   - Filter posts by sport and date.  

### 5. **Dynamic Themes**  
   - Toggle between dark and light themes.  
   - Theme preference is saved in local storage.  

## Folder Structure  
```plaintext
project-root/
├── homepage.html       # Homepage
├── db_connection.php   # Database connection file
├── fetch_posts.php     # Fetch posts from the database
├── add_friend.php      # Handle friend requests
├── styles.css          # Custom styles
├── dark-theme.css      # Dark theme styles
├── app.js              # JavaScript for interactivity
├── database.sql        # SQL file to set up the database
├── navbar.php          # Reusable navigation bar
├── README.md           # Project documentation
└── ...

```
## Future Enhancements

This project has immense potential for future development. Below are some planned enhancements:

1. **Improved Recommendation System**:  
   Develop a machine learning-based recommendation system to suggest nearby players or activities based on a user's preferences, location, and activity history.

2. **Push Notifications**:  
   Integrate push notifications to alert users about new friend requests, upcoming activities, or nearby events.

3. **Real-Time Chat**:  
   Implement a real-time chat feature for users to interact while organizing or participating in activities.

4. **User Badges and Achievements**:  
   Introduce user badges or achievements for milestones such as "Top Player", "Activity Organizer", or "Most Active".

5. **Social Media Integration**:  
   Allow users to share their activities or achievements directly to social media platforms like Facebook, Instagram, or Twitter.

6. **Mobile App Version**:  
   Convert the web application into a mobile app using frameworks like React Native or Flutter to enhance accessibility and usability on smartphones.

7. **Activity Insights and Analytics**:  
   Provide users with statistics on their activity patterns, such as the most played sports, frequent locations, or the number of times they have participated in a game.
   
8. **User Profile Customization**:  
   Offer more customization options for user profiles, such as themes, custom backgrounds, and the ability to display personal achievements.

9. **Expanded Sports Categories**:  
   Add more sports categories to cater to a broader range of users and activities, including niche sports.

---
