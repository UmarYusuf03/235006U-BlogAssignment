<?php
// Include all helper functions and database connection
require_once './functions.php';

// Check if the user is logged in
// If not logged in, redirect to login page 
if (!isLoggedIn()) {
    header('Location: ./login.php');
    exit;
}

// Initialize an array to hold form validation errors
$errors = [];

// Check if the form was submitted using POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Validate input — both fields are required
    if (!$title || !$content) {
        $errors[] = 'Title and content are required.';
    }

    // If there are no errors, insert the post into the database
    if (empty($errors)) {
        // Create a new post for the currently logged-in user
        createPost(currentUserId(), $title, $content);

        // Redirect to homepage after successful post creation
        header('Location: ./index.php');
        exit;
    }
}

// Include the HTML header layout
include './header.php';
?>


<h1>New Post</h1>

<!--Show error messages -->
<?php
if ($errors) {
    echo '<div class="errors">' . implode('<br>', $errors) . '</div>';
}
?>

<!-- Blog post creation form -->
<form method="post" class="form">
    <!-- Title input -->
    <label>Title
        <input name="title" required>
    </label>

    <!-- Content textarea -->
    <label>Content
        <textarea name="content" id="md-input" rows="5" required></textarea>
    </label>

    <!-- Markdown live preview area -->
    <div class="md-preview">
        <h3>Preview</h3>
        <div id="preview"></div>
    </div>

    <!-- Submit button -->
    <button type="submit">Create</button>
</form>

<!-- JavaScript to update Markdown preview in real-time -->
<script>
    // Get input and preview elements
    const input = document.getElementById('md-input');
    const preview = document.getElementById('preview');

    // Function to render Markdown into HTML using marked.js library
    function render() {
        preview.innerHTML = marked.parse(input.value || '');
    }

    // Update preview every time user types
    input.addEventListener('input', render);

    // Initial render (empty by default)
    render();
</script>

<?php
// Include footer layout
include 'footer.php';
?>