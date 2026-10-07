<?php
$pageTitle = "Home - BookVerse";
include __DIR__ . "/assets/includes/database_connectivity.inc";

$featuredBooks = [];
$featuredBooksQueryFailed = false;
$stmt = mysqli_prepare(
    $conn,
    "SELECT title, author, genre, price, availability, isbn, coverID
    FROM books
    ORDER BY id DESC
    LIMIT 4"
);

if ($stmt === false) {
    error_log("Unable to prepare featured books query: " . mysqli_error($conn));
    $featuredBooksQueryFailed = true;
} elseif (!mysqli_stmt_execute($stmt)) {
    error_log("Unable to retrieve featured books: " . mysqli_stmt_error($stmt));
    $featuredBooksQueryFailed = true;
    mysqli_stmt_close($stmt);
} elseif (!mysqli_stmt_bind_result($stmt, $title, $author, $genre, $price, $availability, $isbn, $coverID)) {
    error_log("Unable to read featured books query results: " . mysqli_stmt_error($stmt));
    $featuredBooksQueryFailed = true;
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

        $featuredBooks[] = [
            "title" => $title,
            "author" => $author,
            "genre" => $genre,
            "price" => $price,
            "availability" => strtolower(trim($availability)),
            "isbn" => $isbn,
            "image" => $coverImage
        ];
    }
    mysqli_stmt_close($stmt);
}

include __DIR__ . "/assets/includes/header.inc";
include __DIR__ . "/assets/includes/nav.inc";
?>
<section id="featuredCarousel" class="hero-carousel carousel slide" data-bs-ride="carousel" data-bs-interval="5000"
    aria-label="Featured book covers">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#featuredCarousel" data-bs-slide-to="0" class="active"
            aria-current="true" aria-label="Show The Midnight Library"></button>
        <button type="button" data-bs-target="#featuredCarousel" data-bs-slide-to="1"
            aria-label="Show Project Hail Mary"></button>
        <button type="button" data-bs-target="#featuredCarousel" data-bs-slide-to="2"
            aria-label="Show Dune"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="./assets/images/covers/1.png" alt="The Midnight Library book cover">
            <div class="carousel-caption">
                <h3>The Midnight Library</h3>
            </div>
        </div>
        <div class="carousel-item">
            <img src="./assets/images/covers/2.png" alt="Project Hail Mary book cover">
            <div class="carousel-caption">
                <h3>Project Hail Mary</h3>
            </div>
        </div>
        <div class="carousel-item">
            <img src="./assets/images/covers/3.png" alt="Dune book cover">
            <div class="carousel-caption">
                <h3>Dune</h3>
            </div>
        </div>
    </div>
    <button class="carousel-control carousel-control-prev" type="button" data-bs-target="#featuredCarousel"
        data-bs-slide="prev" aria-label="Show previous featured book">
        <span aria-hidden="true">&#10094;</span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control carousel-control-next" type="button" data-bs-target="#featuredCarousel"
        data-bs-slide="next" aria-label="Show next featured book">
        <span aria-hidden="true">&#10095;</span>
        <span class="visually-hidden">Next</span>
    </button>
</section>

<main class="container content">
    <section class="featured-books" aria-labelledby="featured-books-title">
        <h1 id="featured-books-title"><img src="./assets/images/favourite.svg" alt="" aria-hidden="true"> Featured
            Books</h1>
        <div class="featured-books-grid">
            <?php if ($featuredBooksQueryFailed): ?>
                <p class="featured-books-message" role="alert">Featured books could not be loaded. Please try again later.</p>
            <?php elseif (!$featuredBooks): ?>
                <p class="featured-books-message">No books have been added yet.</p>
            <?php else: ?>
                <?php foreach ($featuredBooks as $book): ?>
                    <?php
                    $status = in_array($book["availability"], ["available", "unavailable", "sold"], true)
                        ? $book["availability"]
                        : "unavailable";
                    $image = $book["image"] ?? "./assets/images/allBooks.svg";
                    ?>
                    <article class="featured-book-card">
                        <img class="<?php echo $book["image"] === null ? "featured-book-placeholder" : ""; ?>"
                            src="<?php echo htmlspecialchars($image, ENT_QUOTES, "UTF-8"); ?>"
                            alt="<?php echo htmlspecialchars(
                                $book["image"] === null ? "No cover image available for " . $book["title"] : $book["title"] . " cover",
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>">
                        <div class="featured-book-info">
                            <h3><?php echo htmlspecialchars($book["title"], ENT_QUOTES, "UTF-8"); ?></h3>
                            <p><?php echo htmlspecialchars($book["genre"], ENT_QUOTES, "UTF-8"); ?> &middot;
                                <?php echo htmlspecialchars($book["author"], ENT_QUOTES, "UTF-8"); ?></p>
                            <strong>$<?php echo htmlspecialchars(number_format((float)$book["price"], 2), ENT_QUOTES, "UTF-8"); ?></strong>
                            <?php if ($book["isbn"] !== ""): ?>
                                <a class="featured-book-details"
                                    href="details.php?isbn=<?php echo rawurlencode($book["isbn"]); ?>">
                                    <span aria-hidden="true">&#9673;</span> View Details
                                </a>
                            <?php else: ?>
                                <span class="book-badge <?php
                                    echo $status === "available" ? "available" : ($status === "sold" ? "sold" : "reserved");
                                ?>">
                                    <?php echo htmlspecialchars(ucfirst($status), ENT_QUOTES, "UTF-8"); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php
include __DIR__ . "/assets/includes/footer.inc";
?>