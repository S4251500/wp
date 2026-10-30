<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"] ?? "";
    $_SESSION["username"] = is_string($username) ? $username : "";

    if ($_SESSION["username"] !== "") {
        $_SESSION["login_success"] = "Logged in successfully. Welcome back, " . $_SESSION["username"] . "!";
    }

    header("Location: index.php");
    exit;
}

$pageTitle = "Login - BookVerse";
include __DIR__ . "/assets/includes/header.inc";
include __DIR__ . "/assets/includes/nav.inc";
?>
<main class="auth-main">
    <section class="auth-card" aria-labelledby="login-title">
        <h1 id="login-title" class="auth-title">
            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <path d="M10 17l5-5-5-5M15 12H3m9-9h8a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-8"></path>
            </svg>
            Login to BookVerse
        </h1>
        <form class="auth-form" method="post">
            <div class="auth-field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username"
                    autocomplete="username">
            </div>
            <div class="auth-field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password"
                    autocomplete="current-password">
            </div>
            <button class="auth-submit" type="submit">
                <span aria-hidden="true">&#9673;</span> Login
            </button>
        </form>
        <p class="auth-switch">Don't have an account? <a href="register.php">Register here</a></p>
    </section>
</main>
<?php
include __DIR__ . "/assets/includes/footer.inc";
?>
