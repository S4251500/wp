<?php
include __DIR__ . "/assets/includes/header.inc";
include __DIR__ . "/assets/includes/nav.inc";
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
            <!-- Books will be dynamically rendered here -->
        </ul>
    </div>
</main>

<?php
include __DIR__ . "/assets/includes/footer.inc";
?>