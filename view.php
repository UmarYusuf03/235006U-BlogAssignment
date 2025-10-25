<?php
// Include functions
require_once 'functions.php';

//Get the post ID from the URL
$id = $_GET['id'] ?? null;

// If no post ID is provided in the URL, redirect to homepage
if (!$id) {
  header('Location: ./index.php');
  exit;
}

// Fetch the blog post
$post = getPost($id);

// If post is not found 
if (!$post) {
  echo 'Post not found';
  exit;
}

// Include the page heade
include './header.php';
?>


<article class="single-post">

  <!-- Post title -->
  <h1><?php echo $post['title']; ?></h1>


  <div class="meta">
    By <?php echo $post['username']; ?> — <?php echo $post['created_at']; ?>
  </div>


  <div class="content" id="post-content"></div>

  <!--If user is logged in AND is the post owner, show Edit/Delete buttons -->
  <?php if (isLoggedIn() && currentUserId() == $post['user_id']): ?>
    <div class="actions">
      <!-- Edit button -->
      <a class="btn" href="edit.php?id=<?php echo $post['id']; ?>">Edit</a>

      <!-- Delete button with confirmation popup -->
      <a class="btn danger" href="delete.php?id=<?php echo $post['id']; ?>"
        onclick="return confirm('Delete this post?');">
        Delete
      </a>
    </div>
  <?php endif; ?>

</article>


<script>
  const md = `<?php echo str_replace('`', '\`', $post['content']); ?>`;

  // Convert HTML and display it inside #post-content
  document.getElementById('post-content').innerHTML = marked.parse(md);
</script>

<!-- Include the footer section -->
<?php include './footer.php'; ?>