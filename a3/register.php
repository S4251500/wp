<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$username = "";
$email = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $postedUsername = $_POST["username"] ?? "";
    $postedEmail = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";

    $username = is_string($postedUsername) ? trim($postedUsername) : "";
    $email = is_string($postedEmail) ? trim($postedEmail) : "";
    $password = is_string($password) ? $password : "";
    $confirmPassword = is_string($confirmPassword) ? $confirmPassword : "";

    if ($username === "" || strlen($username) > 50) {
        $errors[] = "Enter a username of up to 50 characters.";
    }
    if (
        $email === ""
        || strlen($email) > 100
        || strpos($email, "@") === false
        || filter_var($email, FILTER_VALIDATE_EMAIL) === false
    ) {
        $errors[] = "Enter a valid email address containing an @ symbol.";
    }
    if ($password === "") {
        $errors[] = "Enter a password.";
    } elseif (strlen($password) > 72) {
        $errors[] = "Password must be 72 bytes or fewer.";
    }
    if ($password !== $confirmPassword) {
        $errors[] = "The passwords do not match.";
    }

    if (!$errors) {
        include __DIR__ . "/assets/includes/database_connectivity.inc";

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO users (username, email, `password`, phone, location, bio, joined_at)
            VALUES (?, ?, ?, '', '', '', NOW())"
        );

        if ($stmt === false) {
            error_log("Unable to prepare user registration: " . mysqli_error($conn));
            $errors[] = "Registration is unavailable right now. Please try again later.";
        } elseif (
            !mysqli_stmt_bind_param($stmt, "sss", $username, $email, $passwordHash)
            || !mysqli_stmt_execute($stmt)
        ) {
            if (mysqli_stmt_errno($stmt) === 1062) {
                $errors[] = "That username or email address is already registered.";
            } else {
                error_log("Unable to register user: " . mysqli_stmt_error($stmt));
                $errors[] = "Your account could not be created. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        } else {
            mysqli_stmt_close($stmt);
            header("Location: login.php?registered=1");
            exit;
        }
    }
}

$pageTitle = "Register - BookVerse";
include __DIR__ . "/assets/includes/header.inc";
include __DIR__ . "/assets/includes/nav.inc";
?>
<main class="auth-main">
    <section class="auth-card" aria-labelledby="register-title">
        <h1 id="register-title" class="auth-title">
            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m7-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm10-4v6m-3-3h6"></path>
            </svg>
            Create Account
        </h1>
        <?php if ($errors): ?>
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0">
                    <?php foreach (array_unique($errors) as $error): ?>
                        <li><?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form class="auth-form" method="post">
            <div class="auth-field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" maxlength="50" placeholder="Choose a username"
                    autocomplete="username" required
                    value="<?php echo htmlspecialchars($username, ENT_QUOTES, "UTF-8"); ?>">
            </div>
            <div class="auth-field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" maxlength="100" placeholder="Enter your email"
                    autocomplete="email" required
                    value="<?php echo htmlspecialchars($email, ENT_QUOTES, "UTF-8"); ?>">
            </div>
            <div class="auth-field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password"
                    autocomplete="new-password" required>
            </div>
            <div class="auth-field">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm password"
                    autocomplete="new-password" required>
            </div>
            <button class="auth-submit" type="submit">
                <span aria-hidden="true">&#9673;</span> Register
            </button>
        </form>
        <p class="auth-switch">Already have an account? <a href="login.php">Login here</a></p>
    </section>
</main>
<?php
include __DIR__ . "/assets/includes/footer.inc";
?>
