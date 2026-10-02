<?php
include __DIR__ . "/assets/includes/header.inc";
include __DIR__ . "/assets/includes/nav.inc";
?>

<main class="container content add-content">
    <h1 class="add-title"><img src="./assets/images/addIcon.svg" alt="">Add New Book</h1>
    <form class="add-form" id="addBookForm">
        <div class="form-field full-width">
            <label for="book-title"><img src="./assets/images/title.svg" alt="" aria-hidden="true">Book
                Title</label>
            <input type="text" id="book-title" name="title" placeholder="Enter book title">
        </div>

        <div class="form-field full-width">
            <label for="author-name"><img src="./assets/images/author.svg" alt="" aria-hidden="true">Author
                Name</label>
            <input type="text" id="author-name" name="author" placeholder="Enter author name">
        </div>

        <div class="form-field full-width">
            <label for="genre"><img src="./assets/images/genre.svg" alt="" aria-hidden="true">Genre</label>
            <select id="genre" name="genre">
                <option value="" selected>Select a genre</option>
                <option>Fiction</option>
                <option>Non-Fiction</option>
                <option>Science Fiction</option>
                <option>Fantasy</option>
            </select>
        </div>

        <div class="form-field">
            <label for="publication-year"><img src="./assets/images/year.svg" alt="" aria-hidden="true">Publication
                Year</label>
            <input name="year" placeholder="2024">
        </div>

        <div class="form-field">
            <label for="price"><img src="./assets/images/money.svg" alt="" aria-hidden="true">Price ($)</label>
            <input name="price" placeholder="19.99">
        </div>

        <div class="form-field">
            <label for="isbn">ISBN</label>
            <input id="isbn" name="isbn" placeholder="978-1-234567-89-0">
        </div>

        <div class="form-field">
            <label for="condition"><img src="./assets/images/bookCondition.svg" alt="" aria-hidden="true">Book
                Condition</label>
            <select id="condition" name="condition">
                <option value="" selected>Select condition</option>
                <option>New</option>
                <option>Good</option>
                <option>Used</option>
            </select>
        </div>

        <div class="form-field full-width">
            <label for="description"><img src="./assets/images/writeDescription.svg" alt=""
                    aria-hidden="true">Description</label>
            <textarea id="description" name="description" placeholder="Describe the book..."></textarea>
        </div>

        <div class="form-field full-width">
            <label for="cover"><img src="./assets/images/uploadImage.svg" alt="" aria-hidden="true">Upload Cover
                Image</label>
            <input type="file" id="cover" name="cover" accept=".jpg,.jpeg,.png">
        </div>

        <div class="form-field full-width">
            <label for="availability"><img src="./assets/images/availability.svg" alt=""
                    aria-hidden="true">Availability Status</label>
            <select id="availability" name="availability">
                <option selected>Available</option>
                <option>Reserved</option>
                <option>Sold</option>
            </select>
        </div>

        <label class="agreement" for="agreement">
            <input type="checkbox" id="agreement" name="agreement">
            <span>I agree that this book information
                is accurate and complete</span>
        </label>

        <button type="button" class="btn add-submit">Add Book to Collection</button>
    </form>
</main>
<?php
include __DIR__ . "/assets/includes/footer.inc";
?>