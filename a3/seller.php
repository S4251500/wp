<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$userId = filter_var($_SESSION["user_id"] ?? null, FILTER_VALIDATE_INT);
if ($userId === false || $userId < 1) {
    header("Location: login.php");
    exit;
}

include __DIR__ . "/assets/includes/database_connectivity.inc";

$pageTitle = "My Profiles and Books - BookVerse";
$profile = null;
$profileQueryFailed = false;
$profileStmt = mysqli_prepare(
    $conn,
    "SELECT username, location, bio, joined_at FROM users WHERE user_id = ? LIMIT 1"
);

if ($profileStmt === false) {
    error_log("Unable to prepare profile query: " . mysqli_error($conn));
    $profileQueryFailed = true;
} elseif (
    !mysqli_stmt_bind_param($profileStmt, "i", $userId)
    || !mysqli_stmt_execute($profileStmt)
    || !mysqli_stmt_bind_result($profileStmt, $profileUsername, $profileLocation, $profileBio, $joinedAt)
) {
    error_log("Unable to retrieve profile: " . mysqli_stmt_error($profileStmt));
    $profileQueryFailed = true;
    mysqli_stmt_close($profileStmt);
} else {
    if (mysqli_stmt_fetch($profileStmt)) {
        $profile = [
            "username" => $profileUsername,
            "location" => $profileLocation,
            "bio" => $profileBio,
            "joined_at" => $joinedAt
        ];
    }
    mysqli_stmt_close($profileStmt);
}

$books = [];
$booksQueryFailed = false;
$booksStmt = mysqli_prepare(
    $conn,
    "SELECT title, price, isbn, image_path FROM books WHERE user_ID = ? ORDER BY book_id DESC"
);

if ($booksStmt === false) {
    error_log("Unable to prepare seller books query: " . mysqli_error($conn));
    $booksQueryFailed = true;
} elseif (
    !mysqli_stmt_bind_param($booksStmt, "i", $userId)
    || !mysqli_stmt_execute($booksStmt)
    || !mysqli_stmt_bind_result($booksStmt, $title, $price, $isbn, $imagePath)
) {
    error_log("Unable to retrieve seller books: " . mysqli_stmt_error($booksStmt));
    $booksQueryFailed = true;
    mysqli_stmt_close($booksStmt);
} else {
    while (mysqli_stmt_fetch($booksStmt)) {
        $coverImage = null;
        $coverNumber = filter_var($imagePath, FILTER_VALIDATE_INT);
        if ($coverNumber !== false && $coverNumber > 0 && $coverNumber <= 2147483647) {
            foreach (["jpg", "png"] as $extension) {
                $coverPath = __DIR__ . "/assets/images/covers/" . $coverNumber . "." . $extension;
                if (is_file($coverPath)) {
                    $coverImage = "./assets/images/covers/" . $coverNumber . "." . $extension;
                    break;
                }
            }
        }

        $books[] = [
            "title" => $title,
            "price" => $price,
            "isbn" => $isbn,
            "cover" => $coverImage
        ];
    }
    mysqli_stmt_close($booksStmt);
}

include __DIR__ . "/assets/includes/header.inc";
include __DIR__ . "/assets/includes/nav.inc";
?>
<main class="container content seller-content">
    <?php if ($profileQueryFailed): ?>
        <div class="details-message" role="alert">
            <h1>Profile unavailable</h1>
            <p>Your profile could not be loaded. Please try again later.</p>
        </div>
    <?php elseif ($profile === null): ?>
        <div class="details-message" role="alert">
            <h1>Profile not found</h1>
            <p>Your account profile could not be found.</p>
        </div>
    <?php else: ?>
        <div class="seller-layout">
            <aside class="seller-profile" aria-labelledby="seller-username">
                <h1 id="seller-username"><?php echo htmlspecialchars($profile["username"], ENT_QUOTES, "UTF-8"); ?></h1>
                <?php if (is_string($profile["location"]) && trim($profile["location"]) !== ""): ?>
                    <p class="seller-location"><?php echo htmlspecialchars($profile["location"], ENT_QUOTES, "UTF-8"); ?></p>
                <?php endif; ?>
                <?php if (is_string($profile["bio"]) && trim($profile["bio"]) !== ""): ?>
                    <p class="seller-bio"><?php echo nl2br(htmlspecialchars($profile["bio"], ENT_QUOTES, "UTF-8")); ?></p>
                <?php else: ?>
                    <p class="seller-bio">Book collector and seller</p>
                <?php endif; ?>
            </aside>

            <section class="seller-books-section" aria-labelledby="seller-books-heading">
                <h2 id="seller-books-heading">Books by <?php echo htmlspecialchars($profile["username"], ENT_QUOTES, "UTF-8"); ?></h2>
                <?php if ($booksQueryFailed): ?>
                    <p class="alert alert-danger" role="alert">Your books could not be loaded. Please try again later.</p>
                <?php elseif (!$books): ?>
                    <div class="seller-empty-state">
                        <p>You have not added any books yet.</p>
                        <a class="btn seller-view-button" href="add.php">Add a Book</a>
                    </div>
                <?php else: ?>
                    <div class="seller-books-grid">
                        <?php foreach ($books as $book): ?>
                            <?php
                            $bookCover = $book["cover"] ?? "./assets/images/allBooks.svg";
                            $bookAlt = $book["cover"] === null
                                ? "No cover image available"
                                : "Cover of " . $book["title"];
                            ?>
                            <article class="seller-book-card">
                                <a class="seller-book-cover"
                                    href="details.php?isbn=<?php echo rawurlencode($book["isbn"]); ?>">
                                    <img src="<?php echo htmlspecialchars($bookCover, ENT_QUOTES, "UTF-8"); ?>"
                                        alt="<?php echo htmlspecialchars($bookAlt, ENT_QUOTES, "UTF-8"); ?>">
                                </a>
                                <div class="seller-book-info">
                                    <h3><?php echo htmlspecialchars($book["title"], ENT_QUOTES, "UTF-8"); ?></h3>
                                    <p>$<?php echo htmlspecialchars(number_format((float)$book["price"], 2), ENT_QUOTES, "UTF-8"); ?></p>
                                    <a class="btn seller-view-button"
                                        href="details.php?isbn=<?php echo rawurlencode($book["isbn"]); ?>">View</a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    <?php endif; ?>
</main>
<?php
include __DIR__ . "/assets/includes/footer.inc";
?>
