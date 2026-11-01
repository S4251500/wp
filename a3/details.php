<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$currentUserId = filter_var($_SESSION["user_id"] ?? null, FILTER_VALIDATE_INT);
$bookNotice = $_SESSION["book_notice"] ?? "";
unset($_SESSION["book_notice"]);

include __DIR__ . "/assets/includes/database_connectivity.inc";

$pageTitle = "Book Details - BookVerse";
$book = null;
$queryFailed = false;
$isbn = $_GET["isbn"] ?? "";
$isbn = is_string($isbn) ? trim($isbn) : "";

if ($isbn !== "" && strlen($isbn) <= 20) {
    $stmt = mysqli_prepare(
        $conn,
        "SELECT book_id, user_ID, title, author, genre, publication_year, price, isbn, book_condition, description, status, image_path
        FROM books
        WHERE isbn = ?
        LIMIT 1"
    );

    if ($stmt === false) {
        error_log("Unable to prepare book details query: " . mysqli_error($conn));
        $queryFailed = true;
    } elseif (!mysqli_stmt_bind_param($stmt, "s", $isbn)) {
        error_log("Unable to bind book details query: " . mysqli_stmt_error($stmt));
        $queryFailed = true;
        mysqli_stmt_close($stmt);
    } elseif (!mysqli_stmt_execute($stmt)) {
        error_log("Unable to retrieve book details: " . mysqli_stmt_error($stmt));
        $queryFailed = true;
        mysqli_stmt_close($stmt);
    } elseif (!mysqli_stmt_bind_result(
        $stmt,
        $bookId,
        $ownerId,
        $title,
        $author,
        $genre,
        $publication_year,
        $price,
        $isbn,
        $book_condition,
        $description,
        $status,
        $image_path
    )) {
        error_log("Unable to read book details query results: " . mysqli_stmt_error($stmt));
        $queryFailed = true;
        mysqli_stmt_close($stmt);
    } else {
        if (mysqli_stmt_fetch($stmt)) {
            $book = [
                "book_id" => $bookId,
                "owner_id" => $ownerId,
                "title" => $title,
                "author" => $author,
                "genre" => $genre,
                "publication_year" => $publication_year === null ? "" : (string)$publication_year,
                "price" => $price,
                "isbn" => $isbn,
                "book_condition" => $book_condition,
                "description" => $description,
                "status" => $status,
                "image_path" => $image_path
            ];
        }
        mysqli_stmt_close($stmt);
    }
}

include __DIR__ . "/assets/includes/header.inc";
include __DIR__ . "/assets/includes/nav.inc";
?>

<main class="container content details-content">
    <?php if (is_string($bookNotice) && $bookNotice !== ""): ?>
        <p class="alert alert-info" role="status"><?php echo htmlspecialchars($bookNotice, ENT_QUOTES, "UTF-8"); ?></p>
    <?php endif; ?>
    <?php if ($queryFailed): ?>
        <div class="details-message" role="alert">
            <h1>Book details unavailable</h1>
            <p>We could not load this book right now. Please try again later.</p>
            <a class="btn details-back" href="books.php">&larr; Back to Books</a>
        </div>
    <?php elseif ($book === null): ?>
        <div class="details-message" role="status">
            <h1>Book not found</h1>
            <p>
                <?php echo $isbn === ""
                    ? "Choose a book from the browse page to view its details."
                    : "No book was found with that ISBN."; ?>
            </p>
            <a class="btn details-back" href="books.php">&larr; Back to Books</a>
        </div>
    <?php else: ?>
        <?php
        $isOwner = $currentUserId !== false
            && $currentUserId > 0
            && (int)$book["owner_id"] === $currentUserId;
        if ($isOwner && !isset($_SESSION["csrf_token"])) {
            $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
        }
        $status = in_array($book["status"], ["available", "unavailable", "sold"], true)
            ? $book["status"]
            : "unavailable";
        $statusLabel = ucfirst($status);
        $statusClass = $status;
        $coverImage = null;
        $image_path = $book["image_path"];
        $coverNumber = filter_var($image_path, FILTER_VALIDATE_INT);
        if ($coverNumber !== false && $coverNumber > 0 && $coverNumber <= 2147483647) {
            foreach (["jpg", "png"] as $extension) {
                $coverPath = __DIR__ . "/assets/images/covers/" . $coverNumber . "." . $extension;
                if (is_file($coverPath)) {
                    $coverImage = "./assets/images/covers/" . $coverNumber . "." . $extension;
                    break;
                }
            }
        }
        ?>
        <article class="details-layout">
            <?php if ($coverImage !== null): ?>
                <div class="details-cover">
                    <img class="details-cover-image"
                        src="<?php echo htmlspecialchars($coverImage, ENT_QUOTES, "UTF-8"); ?>"
                        alt="Cover of <?php echo htmlspecialchars($book["title"], ENT_QUOTES, "UTF-8"); ?>">
                </div>
            <?php else: ?>
                <div class="details-cover" role="img" aria-label="Cover image unavailable for this book">
                    <img src="./assets/images/allBooks.svg" alt="" aria-hidden="true">
                    <span>Cover image unavailable</span>
                </div>
            <?php endif; ?>

            <div class="details-info">
                <h1><?php echo htmlspecialchars($book["title"], ENT_QUOTES, "UTF-8"); ?></h1>
                <p class="details-author">by <?php echo htmlspecialchars($book["author"], ENT_QUOTES, "UTF-8"); ?></p>
                <span class="details-status status-<?php echo htmlspecialchars($statusClass, ENT_QUOTES, "UTF-8"); ?>">
                    <?php echo htmlspecialchars($statusLabel, ENT_QUOTES, "UTF-8"); ?>
                </span>

                <dl class="details-list">
                    <div>
                        <dt>Genre:</dt>
                        <dd><?php echo htmlspecialchars($book["genre"], ENT_QUOTES, "UTF-8"); ?></dd>
                    </div>
                    <div>
                        <dt>Publication Year:</dt>
                        <dd><?php echo htmlspecialchars($book["publication_year"], ENT_QUOTES, "UTF-8"); ?></dd>
                    </div>
                    <div>
                        <dt>ISBN:</dt>
                        <dd><?php echo htmlspecialchars($book["isbn"], ENT_QUOTES, "UTF-8"); ?></dd>
                    </div>
                    <div>
                        <dt>Condition:</dt>
                        <dd><?php echo htmlspecialchars(ucfirst($book["book_condition"]), ENT_QUOTES, "UTF-8"); ?></dd>
                    </div>
                    <div>
                        <dt>Price:</dt>
                        <dd class="details-price">$<?php echo htmlspecialchars(number_format((float)$book["price"], 2), ENT_QUOTES, "UTF-8"); ?></dd>
                    </div>
                </dl>

                <section class="details-description" aria-labelledby="description-heading">
                    <h2 id="description-heading">Description</h2>
                    <p><?php echo nl2br(htmlspecialchars($book["description"], ENT_QUOTES, "UTF-8")); ?></p>
                </section>

                <div class="details-actions">
                    <a class="btn details-back" href="books.php">&larr; Back to Books</a>
                    <?php if ($isOwner): ?>
                        <a class="btn details-edit" href="edit.php?id=<?php echo (int)$book["book_id"]; ?>">Edit</a>
                        <form class="details-delete-form" method="post" action="delete.php"
                            onsubmit="return confirm('Delete this book permanently?');">
                            <input type="hidden" name="book_id" value="<?php echo (int)$book["book_id"]; ?>">
                            <input type="hidden" name="csrf_token"
                                value="<?php echo htmlspecialchars($_SESSION["csrf_token"], ENT_QUOTES, "UTF-8"); ?>">
                            <button class="btn details-delete" type="submit">Delete</button>
                        </form>
                    <?php elseif ($currentUserId !== false && $currentUserId > 0): ?>
                        <a class="btn details-similar" href="add.php">+ Add Similar Book</a>
                    <?php endif; ?>
                </div>
            </div>
        </article>
    <?php endif; ?>
</main>

<?php
include __DIR__ . "/assets/includes/footer.inc";
?>