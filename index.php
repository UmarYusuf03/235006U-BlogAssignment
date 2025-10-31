<?php
// Include functions
require_once './functions.php';

// Initialize search variable
$search = $_GET['search'] ?? '';

// If search term is provided, fetch matching posts
if (!empty($search)) {
    $posts = searchPosts($search);
} else {
    // Otherwise, fetch all posts
    $posts = getAllPosts();
}

// Include header
include './header.php';
?>

<!-- Search bar section -->
<h2>Search Blogs</h2>

<form method="get" action="index.php" class="form searchBar" style="margin-bottom: 20px;">
    <input
        type="text"
        name="search"
        placeholder="Search by title or content..."
        value="<?php echo htmlspecialchars($search); ?>"
        style="padding: 8px; width: 450px; ">
    <button type="submit" style="padding: 8px 12px;">Search</button>
</form>

<!-- Latest Blogs Section -->
<h1>Latest Blogs</h1>

<div class="posts">

    <!-- If there are no posts in the database -->
    <?php if (empty($posts)): ?>
        <p>
            <?php if (!empty($search)): ?>
                No posts found for "<strong><?php echo htmlspecialchars($search); ?></strong>".
            <?php else: ?>
                No posts yet.
                <?php if (isLoggedIn()) echo '<a href="./create.php">Create the first post</a>.'; ?>
            <?php endif; ?>
        </p>

        <!-- If there are blog posts -->
    <?php else: ?>

        <!-- Loop through all posts -->
        <?php foreach ($posts as $p): ?>
            <article class="post-card">
                <h2>
                    <a href="./view.php?id=<?php echo $p['id']; ?>" style="color: #19183B">
                        <?php echo $p['title']; ?>
                    </a>
                </h2>

                <div class="meta">
                    By <?php echo $p['username']; ?> — <?php echo $p['created_at']; ?>
                </div>

                <p class="excerpt">
                    <?php echo substr(strip_tags($p['content']), 0, 200); ?>...
                </p>

                <a class="read-more" href="./view.php?id=<?php echo $p['id']; ?>" style="color: #4a6c67ff;">Read</a>
            </article>
        <?php endforeach; ?>

    <?php endif; ?>
</div>

<!-- Include footer layout -->
<?php include './footer.php'; ?>