<?php
include __DIR__ . "/assets/includes/database_connectivity.inc";

$pageTitle = "Gallery - BookVerse";
$books = [];
$booksQueryFailed = false;
$stmt = mysqli_prepare($conn, "SELECT title, coverID FROM books ORDER BY id DESC LIMIT 12");

if ($stmt === false) {
    error_log("Unable to prepare gallery query: " . mysqli_error($conn));
    $booksQueryFailed = true;
} elseif (!mysqli_stmt_execute($stmt)) {
    error_log("Unable to retrieve gallery books: " . mysqli_stmt_error($stmt));
    $booksQueryFailed = true;
    mysqli_stmt_close($stmt);
} elseif (!mysqli_stmt_bind_result($stmt, $title, $coverID)) {
    error_log("Unable to read gallery query results: " . mysqli_stmt_error($stmt));
    $booksQueryFailed = true;
    mysqli_stmt_close($stmt);
} else {
    while (mysqli_stmt_fetch($stmt)) {
        $coverImage = null;
        if (is_string($coverID) && preg_match('/\A[a-f0-9]{1,13}\z/i', $coverID)) {
            foreach (["jpg", "png"] as $extension) {
                $coverPath = __DIR__ . "/assets/images/covers/" . $coverID . "." . $extension;
                if (is_file($coverPath)) {
                    $coverImage = "./assets/images/covers/" . rawurlencode($coverID) . "." . $extension;
                    break;
                }
            }
        }

        $books[] = [
            "title" => $title,
            "image" => $coverImage
        ];
    }
    mysqli_stmt_close($stmt);
}

include __DIR__ . "/assets/includes/header.inc";
include __DIR__ . "/assets/includes/nav.inc";
?>

<main class="container content">
    <h1><img src="./assets/images/gallerySearch.svg" alt="" aria-hidden="true"> Book Cover Gallery</h1>
    <section class="gallery-grid" aria-label="Book cover gallery">
        <?php if ($booksQueryFailed): ?>
            <p class="gallery-empty-state" role="alert">Book covers could not be loaded. Please try again later.</p>
        <?php elseif (!$books): ?>
            <div class="gallery-empty-state">
                <img src="./assets/images/allBooks.svg" alt="" aria-hidden="true">
                <span>No book images available</span>
            </div>
        <?php else: ?>
            <?php foreach ($books as $index => $book): ?>
                <?php
                $safeTitle = htmlspecialchars($book["title"], ENT_QUOTES, "UTF-8");
                $imagePath = $book["image"] ?? "./assets/images/allBooks.svg";
                $imageAlt = $book["image"] === null
                    ? "No cover image available for " . $book["title"]
                    : $book["title"] . " cover";
                ?>
                <button class="gallery-trigger" type="button"
                    aria-label="View <?php echo $safeTitle; ?> cover"
                    data-image-index="<?php echo $index; ?>"
                    data-image-src="<?php echo htmlspecialchars($imagePath, ENT_QUOTES, "UTF-8"); ?>"
                    data-image-title="<?php echo $safeTitle; ?>"
                    data-bs-toggle="modal" data-bs-target="#galleryModal">
                    <img src="<?php echo htmlspecialchars($imagePath, ENT_QUOTES, "UTF-8"); ?>"
                        alt="<?php echo htmlspecialchars($imageAlt, ENT_QUOTES, "UTF-8"); ?>"
                        class="gallery-img<?php echo $book["image"] === null ? " gallery-img-placeholder" : ""; ?>">
                </button>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>

<div class="modal fade gallery-modal" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered gallery-modal-dialog">
        <div class="modal-content gallery-modal-content">
            <div class="modal-header gallery-modal-header">
                <h2 class="modal-title gallery-modal-title" id="galleryModalLabel"></h2>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body gallery-modal-body">
                <div class="gallery-modal-stage">
                    <div class="gallery-modal-preview">
                        <img src="" alt="Selected book cover" class="gallery-modal-image" id="modalImage">
                    </div>
                </div>

                <div class="gallery-modal-actions">
                    <button type="button" class="btn btn-light btn-prev" aria-label="Previous image">
                        <span aria-hidden="true">&lsaquo;</span> Previous
                    </button>
                    <button type="button" class="btn btn-light btn-next" aria-label="Next image">
                        Next <span aria-hidden="true">&rsaquo;</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include __DIR__ . "/assets/includes/footer.inc";
?>
