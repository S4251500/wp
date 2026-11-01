<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$bookNotice = $_SESSION["book_notice"] ?? "";
unset($_SESSION["book_notice"]);

include __DIR__ . "/assets/includes/header.inc";
include __DIR__ . "/assets/includes/nav.inc";
include __DIR__ . "/assets/includes/database_connectivity.inc";

$books = [];
$booksQueryFailed = false;
$stmt = mysqli_prepare(
    $conn,
    "SELECT title, author, publication_year, status, isbn
    FROM books
    ORDER BY book_id DESC"
);

if ($stmt === false) {
    error_log("Unable to prepare books query: " . mysqli_error($conn));
    $booksQueryFailed = true;
} elseif (!mysqli_stmt_execute($stmt)) {
    error_log("Unable to retrieve books: " . mysqli_stmt_error($stmt));
    $booksQueryFailed = true;
    mysqli_stmt_close($stmt);
} elseif (!mysqli_stmt_bind_result($stmt, $title, $author, $publication_year, $status, $isbn)) {
    error_log("Unable to read books query results: " . mysqli_stmt_error($stmt));
    $booksQueryFailed = true;
    mysqli_stmt_close($stmt);
} else {
    while (mysqli_stmt_fetch($stmt)) {
        $books[] = [
            "title" => $title,
            "author" => $author,
            "publication_year" => $publication_year === null ? "" : (string)$publication_year,
            "status" => $status,
            "isbn" => $isbn
        ];
    }
    mysqli_stmt_close($stmt);
}
?>

<main class="container content">
    <?php if (is_string($bookNotice) && $bookNotice !== ""): ?>
        <p class="alert alert-info" role="status"><?php echo htmlspecialchars($bookNotice, ENT_QUOTES, "UTF-8"); ?></p>
    <?php endif; ?>
    <h1><img src="./assets/images/gallery.svg" alt="" aria-hidden="true"> All Books</h1>

    <!-- Filter Section -->
    <div class="filter-card">
        <div class="filter-controls">
            <h2 id="filterLabel">Filter by Status</h2>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="filterDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false" aria-labelledby="filterLabel">
                    All Books
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown" aria-label="Filter books by status">
                    <li><a class="dropdown-item active" href="#" data-status="all">All Books</a></li>
                    <li><a class="dropdown-item" href="#" data-status="available">Available</a></li>
                    <li><a class="dropdown-item" href="#" data-status="unavailable">Unavailable</a></li>
                    <li><a class="dropdown-item" href="#" data-status="sold">Sold</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Books Display Section -->
    <div class="books-card">
        <ul class="books-list" id="booksList">
            <?php if ($booksQueryFailed): ?>
                <li class="book-item empty-state">
                    <p>Books could not be loaded. Please try again later.</p>
                </li>
            <?php else: ?>
                <?php foreach ($books as $book): ?>
                    <?php
                    $status = in_array($book["status"], ["available", "unavailable", "sold"], true)
                        ? $book["status"]
                        : "unavailable";
                    $statusLabel = ucfirst($status);
                    $statusClass = $status;
                    ?>
                    <li class="book-item" data-status="<?php echo htmlspecialchars($status, ENT_QUOTES, "UTF-8"); ?>">
                        <div class="book-info">
                            <?php if (is_string($book["isbn"]) && $book["isbn"] !== ""): ?>
                                <a class="book-title"
                                    href="details.php?isbn=<?php echo rawurlencode($book["isbn"]); ?>"
                                    aria-label="View details for <?php echo htmlspecialchars($book["title"], ENT_QUOTES, "UTF-8"); ?>">
                                    <?php echo htmlspecialchars($book["title"], ENT_QUOTES, "UTF-8"); ?>
                                </a>
                            <?php else: ?>
                                <span class="book-title"><?php echo htmlspecialchars($book["title"], ENT_QUOTES, "UTF-8"); ?></span>
                            <?php endif; ?>
                            <span class="book-author"><?php echo htmlspecialchars($book["author"], ENT_QUOTES, "UTF-8"); ?></span>
                        </div>
                        <span class="book-year"><?php echo htmlspecialchars($book["publication_year"], ENT_QUOTES, "UTF-8"); ?></span>
                        <span class="book-status status-<?php echo htmlspecialchars($statusClass, ENT_QUOTES, "UTF-8"); ?>"><?php echo htmlspecialchars($statusLabel, ENT_QUOTES, "UTF-8"); ?></span>
                    </li>
                <?php endforeach; ?>
                <li class="book-item empty-state<?php echo $books ? " d-none" : ""; ?>" id="booksEmptyState">
                    <p>No books found for this status.</p>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</main>