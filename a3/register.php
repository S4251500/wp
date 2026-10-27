<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"] ?? "";
    $_SESSION["username"] = is_string($username) ? $username : "";
    header("Location: index.php");
    exit;
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
        <form class="auth-form" method="post">
            <div class="auth-field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Choose a username"
                    autocomplete="username">
            </div>
            <div class="auth-field">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Enter your email"
                    autocomplete="email">
            </div>
            <div class="auth-field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password"
                    autocomplete="new-password">
            </div>
            <div class="auth-field">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm password"
                    autocomplete="new-password">
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
