<?php
// Include functions
require_once 'functions.php';

// empty array to store error messages
$errors = [];

// Check if the form was submitted using POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form inputs and clean extra spaces
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm']; // password confirmation

    // Validate user inputs
    // Check if all required fields are filled
    if (!$username || !$email || !$password) 
        $errors[] = 'All fields are required.';

    // Check if passwords match
    if ($password !== $confirm) 
        $errors[] = 'Passwords do not match.';

    // Check if email already exists in the database
    if (findUserByEmail($email)) 
        $errors[] = 'Email already registered.';

    // If there are no errors, create a new user account
    if (empty($errors)) {

        // Hash the password securely before storing 
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL to insert new user record into database
        $stmt = $pdo->prepare('INSERT INTO user (username, email, password) VALUES (?, ?, ?)');

        // Execute SQL statement with actual form data
        $stmt->execute([$username, $email, $hash]);

        // Redirect to login page after successful registration
        header('Location: ./login.php');
        exit;
    }
}

// Include header
include 'header.php';
?>

<!--Page Title -->
<h1>Register</h1>


<?php 
if ($errors) {
    echo '<div class="errors">' . implode('<br>', $errors) . '</div>';
}
?>


<form method="post" class="form">
    <!-- Username-->
    <label>Username
        <input name="username" required>
    </label>

    <!-- Email-->
    <label>Email
        <input type="email" name="email" required>
    </label>

    <!-- Password-->
    <label>Password
        <input type="password" name="password" required>
    </label>

    <!-- Confirm Password-->
    <label>Confirm Password
        <input type="password" name="confirm" required>
    </label>

    <!-- Submit button -->
    <button type="submit">Register</button>
</form>

<!--Include footer-->
<?php include 'footer.php'; ?>
