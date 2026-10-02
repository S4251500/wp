<?php
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
            <article class="featured-book-card">
                <img src="./assets/images/covers/1.png" alt="The Midnight Library cover">
                <h3>The Midnight Library</h3>
                <p>Fiction &middot; Matt Haig</p>
                <strong>$24.99</strong>
                <span class="book-badge available">Available</span>
            </article>
            <article class="featured-book-card">
                <img src="./assets/images/covers/2.png" alt="Project Hail Mary cover">
                <h3>Project Hail Mary</h3>
                <p>Science Fiction &middot; Andy Weir</p>
                <strong>$28.99</strong>
                <span class="book-badge available">Available</span>
            </article>
            <article class="featured-book-card">
                <img src="./assets/images/covers/3.png" alt="Dune cover">
                <h3>Dune</h3>
                <p>Science Fiction &middot; Frank Herbert</p>
                <strong>$22.99</strong>
                <span class="book-badge available">Available</span>
            </article>
            <article class="featured-book-card">
                <img src="./assets/images/covers/4.png" alt="The Hobbit cover">
                <h3>The Hobbit</h3>
                <p>Fantasy &middot; J.R.R. Tolkien</p>
                <strong>$18.99</strong>
                <span class="book-badge available">Available</span>
            </article>
            <article class="featured-book-card">
                <img src="./assets/images/covers/5.png" alt="1984 cover">
                <h3>1984</h3>
                <p>Dystopian &middot; George Orwell</p>
                <strong>$16.99</strong>
                <span class="book-badge available">Available</span>
            </article>
            <article class="featured-book-card">
                <img src="./assets/images/covers/6.png" alt="Pride and Prejudice cover">
                <h3>Pride and Prejudice</h3>
                <p>Romance &middot; Jane Austen</p>
                <strong>$14.99</strong>
                <span class="book-badge reserved">Reserved</span>
            </article>
            <article class="featured-book-card">
                <img src="./assets/images/covers/7.png" alt="To Kill a Mockingbird cover">
                <h3>To Kill a Mockingbird</h3>
                <p>Fiction &middot; Harper Lee</p>
                <strong>$19.99</strong>
                <span class="book-badge available">Available</span>
            </article>
            <article class="featured-book-card">
                <img src="./assets/images/covers/8.png" alt="The Great Gatsby cover">
                <h3>The Great Gatsby</h3>
                <p>Fiction &middot; F. Scott Fitzgerald</p>
                <strong>$15.99</strong>
                <span class="book-badge sold">Sold</span>
            </article>
        </div>
    </section>
</main>
<?php
include __DIR__ . "/assets/includes/footer.inc";
?>