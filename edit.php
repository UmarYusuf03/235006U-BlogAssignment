<?php
// Include all helper functions and database connection
require_once './functions.php';

// Check if the user is logged in
// If not, redirect to login page
if (!isLoggedIn()) {
    header('Location: ./login.php');
    exit;
}

// Get post ID from URL
$id = $_GET['id'] ?? null;

// If ID is missing, send user back to homepage
if (!$id) {
    header('Location: ./index.php');
    exit;
}

// Fetch the post details from the database
$post = getPost($id);

// If no post found, show an error and stop
if (!$post) {
    echo 'Post not found';
    exit;
}

// Security check — only the owner can edit their post
if (currentUserId() != $post['user_id']) {
    echo 'Unauthorized';
    exit;
}

// Prepare for form validation errors
$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Check if both fields are filled
    if (!$title || !$content) {
        $errors[] = 'Title and content are required.';
    }

    // If no errors, update the post in database
    if (empty($errors)) {
        updatePost($id, $title, $content);

        // After successful update, redirect to the view page for this post
        header('Location: view.php?id=' . $id);
        exit;
    }
}

// Include page header layout
include 'header.php';
?>

<!-- Page Title -->
<h1>Edit Post</h1>

<!--Show error messages if there are validation issues -->
<?php
if ($errors) {
    echo '<div class="errors">' . implode('<br>', $errors) . '</div>';
}
?>

<!-- Edit Post Form -->
<form method="post" class="form">
    <label>Title
        <input name="title" value="<?php echo $post['title']; ?>" required>
    </label>

    <label>Content
        <textarea name="content" id="md-input" rows="8" required><?php echo $post['content']; ?></textarea>
    </label>

    <div class="md-preview">
        <h3>Preview</h3>
        <div id="preview"></div>
    </div>

    <button type="submit">Save Changes</button>
</form>

<script>
    const inputE = document.getElementById('md-input');
    const previewE = document.getElementById('preview');

    function renderE() {
        previewE.innerHTML = marked.parse(inputE.value || '');
    }

    inputE.addEventListener('input', renderE);

    renderE();
</script>

<?php
// Include footer layout
include 'footer.php';
?>