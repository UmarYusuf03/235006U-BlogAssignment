<?php
// Include functions
require_once './functions.php';

// Fetch all blog posts from the database
$posts = getAllPosts();

// Include header 
include './header.php';
?>

<h2>Search Blogs</h2>

<h1>Latest Blogs</h1>

<div class="posts">

    <!-- If there are no posts in the database -->
    <?php if (empty($posts)): ?>
        <p>
            No posts yet.

            <?php if (isLoggedIn()) echo '<a href="./create.php">Create the first post</a>.'; ?>
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

<!--Include footer layout -->
<?php include './footer.php'; ?>