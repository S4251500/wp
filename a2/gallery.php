<?php
include __DIR__ . "/assets/includes/header.inc";
include __DIR__ . "/assets/includes/nav.inc";
?>

<main class="container content">
    <h1><img src="./assets/images/gallerySearch.svg" alt="" aria-hidden="true"> Book Cover Gallery</h1>
    <section class="gallery-grid" aria-label="Book cover gallery">
        <button class="gallery-trigger" type="button" aria-label="View The Midnight Library cover"
            data-image-index="0" data-bs-toggle="modal" data-bs-target="#galleryModal"><img
                src="./assets/images/covers/1.png" alt="The Midnight Library cover" class="gallery-img"></button>
        <button class="gallery-trigger" type="button" aria-label="View Project Hail Mary cover" data-image-index="1"
            data-bs-toggle="modal" data-bs-target="#galleryModal"><img src="./assets/images/covers/2.png"
                alt="Project Hail Mary cover" class="gallery-img"></button>
        <button class="gallery-trigger" type="button" aria-label="View Dune cover" data-image-index="2"
            data-bs-toggle="modal" data-bs-target="#galleryModal"><img src="./assets/images/covers/3.png"
                alt="Dune cover" class="gallery-img"></button>
        <button class="gallery-trigger" type="button" aria-label="View The Hobbit cover" data-image-index="3"
            data-bs-toggle="modal" data-bs-target="#galleryModal"><img src="./assets/images/covers/4.png"
                alt="The Hobbit cover" class="gallery-img"></button>
        <button class="gallery-trigger" type="button" aria-label="View 1984 cover" data-image-index="4"
            data-bs-toggle="modal" data-bs-target="#galleryModal"><img src="./assets/images/covers/5.png"
                alt="1984 cover" class="gallery-img"></button>
        <button class="gallery-trigger" type="button" aria-label="View Pride and Prejudice cover"
            data-image-index="5" data-bs-toggle="modal" data-bs-target="#galleryModal"><img
                src="./assets/images/covers/6.png" alt="Pride and Prejudice cover" class="gallery-img"></button>
        <button class="gallery-trigger" type="button" aria-label="View To Kill a Mockingbird cover"
            data-image-index="6" data-bs-toggle="modal" data-bs-target="#galleryModal"><img
                src="./assets/images/covers/7.png" alt="To Kill a Mockingbird cover" class="gallery-img"></button>
        <button class="gallery-trigger" type="button" aria-label="View The Great Gatsby cover" data-image-index="7"
            data-bs-toggle="modal" data-bs-target="#galleryModal"><img src="./assets/images/covers/8.png"
                alt="The Great Gatsby cover" class="gallery-img"></button>
        <button class="gallery-trigger" type="button" aria-label="View Educated cover" data-image-index="8"
            data-bs-toggle="modal" data-bs-target="#galleryModal"><img src="./assets/images/covers/9.png"
                alt="Educated cover" class="gallery-img"></button>
        <button class="gallery-trigger" type="button" aria-label="View The Seven Husbands of Evelyn Hugo cover"
            data-image-index="9" data-bs-toggle="modal" data-bs-target="#galleryModal"><img
                src="./assets/images/covers/10.png" alt="The Seven Husbands of Evelyn Hugo cover"
                class="gallery-img"></button>
        <button class="gallery-trigger" type="button" aria-label="View Atomic Habits cover" data-image-index="10"
            data-bs-toggle="modal" data-bs-target="#galleryModal"><img src="./assets/images/covers/11.png"
                alt="Atomic Habits cover" class="gallery-img"></button>
        <button class="gallery-trigger" type="button" aria-label="View Sapiens cover" data-image-index="11"
            data-bs-toggle="modal" data-bs-target="#galleryModal"><img src="./assets/images/covers/12.png"
                alt="Sapiens cover" class="gallery-img"></button>
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