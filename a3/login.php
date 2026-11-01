<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$username = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $postedUsername = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";
    $username = is_string($postedUsername) ? trim($postedUsername) : "";
    $password = is_string($password) ? $password : "";

    if ($username === "" || strlen($username) > 50) {
        $errors[] = "Enter your username.";
    }
    if ($password === "") {
        $errors[] = "Enter your password.";
    } elseif (strlen($password) > 72) {
        $errors[] = "The username or password is incorrect.";
    }

    if (!$errors) {
        include __DIR__ . "/assets/includes/database_connectivity.inc";

        $stmt = mysqli_prepare(
            $conn,
            "SELECT user_id, username, `password` FROM users WHERE username = ? LIMIT 1"
        );

        if ($stmt === false) {
            error_log("Unable to prepare user login: " . mysqli_error($conn));
            $errors[] = "Login is unavailable right now. Please try again later.";
        } elseif (
            !mysqli_stmt_bind_param($stmt, "s", $username)
            || !mysqli_stmt_execute($stmt)
            || !mysqli_stmt_bind_result($stmt, $userId, $accountUsername, $passwordHash)
        ) {
            error_log("Unable to retrieve login account: " . mysqli_stmt_error($stmt));
            $errors[] = "Login is unavailable right now. Please try again later.";
            mysqli_stmt_close($stmt);
        } else {
            $userFound = mysqli_stmt_fetch($stmt);
            $fetchError = mysqli_stmt_errno($stmt);
            mysqli_stmt_close($stmt);

            if ($userFound === true && password_verify($password, $passwordHash)) {
                session_regenerate_id(true);
                $_SESSION["user_id"] = (int)$userId;
                $_SESSION["username"] = $accountUsername;
                $_SESSION["login_success"] = "Logged in successfully. Welcome back, " . $accountUsername . "!";
                header("Location: index.php");
                exit;
            }

            if ($userFound === false && $fetchError !== 0) {
                error_log("Unable to read login account: MySQLi error " . $fetchError);
                $errors[] = "Login is unavailable right now. Please try again later.";
            } else {
                $errors[] = "The username or password is incorrect.";
            }
        }
    }
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
        <?php if (isset($_GET["registered"])): ?>
            <p class="alert alert-success" role="status">Account created. You can now log in.</p>
        <?php endif; ?>
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
                <input type="text" id="username" name="username" maxlength="50" placeholder="Enter your username"
                    autocomplete="username" required
                    value="<?php echo htmlspecialchars($username, ENT_QUOTES, "UTF-8"); ?>">
            </div>
            <div class="auth-field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password"
                    autocomplete="current-password" required>
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
