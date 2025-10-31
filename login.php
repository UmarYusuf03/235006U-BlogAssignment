<?php
// Include functions
require_once './functions.php';

// empty array to store error messages
$errors = [];

// Check if the form was submitted using the POST method

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    //Find the user record by their email
    $user = findUserByEmail($email);

    // Check if the user exists AND if the password matches
    if (!$user || !password_verify($password, $user['password'])) {

        $errors[] = 'Invalid credentials.';
    } else {
        unset($user['password']);

        $_SESSION['user'] = $user;

        // Redirect the user to homepage after successful login
        header('Location: ./index.php');
        exit;
    }
}

// Include the site header (navigation bar, CSS, etc.)
include './header.php';
?>

<!-- Page Title -->
<h1>Login</h1>


<?php
if ($errors) {
    echo '<div class="errors">' . implode('<br>', $errors) . '</div>';
}
?>

<!-- Login Form -->
<form method="post" class="form">
    <!-- Email input -->
    <label>Email
        <input type="email" name="email" required>
    </label>

    <!-- Password input -->
    <label>Password
        <input type="password" name="password" required>
    </label>

    <!-- Submit button -->
    <button type="submit">Login</button>
</form>

<!-- Include footer -->
<?php include './footer.php'; ?>