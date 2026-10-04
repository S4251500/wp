<?php
include __DIR__ . "/assets/includes/header.inc";
include __DIR__ . "/assets/includes/nav.inc";
include __DIR__ . "/assets/includes/databse_connectivity.inc";

$booksQueryError = false;
$booksResult = false;
$booksStatement = mysqli_prepare($conn, "SELECT * FROM books");

if ($booksStatement === false) {
    error_log("Unable to prepare the books query: " . mysqli_error($conn));
    $booksQueryError = true;
} elseif (!mysqli_stmt_execute($booksStatement)) {
    error_log("Unable to execute the books query: " . mysqli_stmt_error($booksStatement));
    $booksQueryError = true;
} else {
    $booksResult = mysqli_stmt_get_result($booksStatement);
    if ($booksResult === false) {
        error_log("Unable to retrieve books query results: " . mysqli_stmt_error($booksStatement));
        $booksQueryError = true;
    }
}

if ($booksStatement !== false) {
    mysqli_stmt_close($booksStatement);
}

$hasBooks = $booksResult !== false && mysqli_num_rows($booksResult) > 0;
?>

<main class="container content">
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
                    <li><a class="dropdown-item" href="#" data-status="sold">Sold</a></li>
                    <li><a class="dropdown-item" href="#" data-status="reserved">Reserved</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Books Display Section -->
    <div class="books-card">
        <ul class="books-list" id="booksList">
            <?php if ($hasBooks): ?>
                <?php while ($book = mysqli_fetch_assoc($booksResult)): ?>
                    <?php
                    $title = (string) ($book["title"] ?? "");
                    $author = (string) ($book["author"] ?? "");
                    $year = (string) ($book["publication_year"] ?? $book["year"] ?? "");
                    $status = trim((string) ($book["availability"] ?? $book["status"] ?? "Unknown"));
                    $statusKey = preg_replace('/[^a-z0-9-]/', '', strtolower($status));
                    if ($statusKey === "") {
                        $statusKey = "unknown";
                    }
                    ?>
                    <li class="book-item" data-status="<?php echo htmlspecialchars($statusKey, ENT_QUOTES, "UTF-8"); ?>">
                        <div class="book-info">
                            <span class="book-title"><?php echo htmlspecialchars($title, ENT_QUOTES, "UTF-8"); ?></span>
                            <span class="book-author"><?php echo htmlspecialchars($author, ENT_QUOTES, "UTF-8"); ?></span>
                        </div>
                        <span class="book-year"><?php echo htmlspecialchars($year, ENT_QUOTES, "UTF-8"); ?></span>
                        <span class="book-status status-<?php echo htmlspecialchars($statusKey, ENT_QUOTES, "UTF-8"); ?>">
                            <?php echo htmlspecialchars($status, ENT_QUOTES, "UTF-8"); ?>
                        </span>
                    </li>
                <?php endwhile; ?>
            <?php endif; ?>
            <li class="book-item empty-state<?php echo $hasBooks ? " d-none" : ""; ?>" id="booksEmptyState">
                <p><?php
                    if ($booksQueryError) {
                        echo "Books could not be loaded right now.";
                    } else {
                        echo "No books found for this status.";
                    }
                ?></p>
            </li>
        </ul>
    </div>
</main>

<?php
include __DIR__ . "/assets/includes/footer.inc";
?>