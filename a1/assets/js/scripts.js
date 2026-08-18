/* Common site JavaScript
   - file extension validation: validateFileExtension(inputElement, allowedExtensions)
   - simple modal helpers: openModal(id), closeModal(id)
*/

function validateFileExtension(inputElement, allowedExtensions) {
    if (!inputElement || !inputElement.value) return false;
    const fileName = inputElement.value.split('\\').pop();
    const ext = (fileName.split('.').pop() || '').toLowerCase();
    return allowedExtensions.map(e => e.toLowerCase()).includes(ext);
}

function showFileValidationMessage(inputElement, allowedExtensions, msgElement) {
    const ok = validateFileExtension(inputElement, allowedExtensions);
    if (!ok) {
        msgElement && (msgElement.textContent = `Invalid file type. Allowed: ${allowedExtensions.join(', ')}`);
        return false;
    }
    msgElement && (msgElement.textContent = '');
    return true;
}

function openModal(id) {
    const backdrop = document.getElementById(id);
    if (!backdrop) return;
    backdrop.classList.add('show');
    backdrop.style.display = 'flex';
}

function closeModal(id) {
    const backdrop = document.getElementById(id);
    if (!backdrop) return;
    backdrop.classList.remove('show');
    backdrop.style.display = 'none';
}

// Close modal when clicking backdrop
document.addEventListener('click', function (e) {
    const target = e.target;
    if (target.classList && target.classList.contains('modal-backdrop')) {
        target.classList.remove('show');
        target.style.display = 'none';
    }
});

// Export functions for inline use
window.validateFileExtension = validateFileExtension;
window.showFileValidationMessage = showFileValidationMessage;
window.openModal = openModal;
window.closeModal = closeModal;

// Gallery Image Cycling
let currentImageIndex = 0;
const galleryImages = [
    { index: 0, src: './assets/images/covers/1.png', title: 'Book 1' },
    { index: 1, src: './assets/images/covers/2.png', title: 'Book 2' },
    { index: 2, src: './assets/images/covers/3.png', title: 'Book 3' },
    { index: 3, src: './assets/images/covers/4.png', title: 'Book 4' },
    { index: 4, src: './assets/images/covers/5.png', title: 'Book 5' },
    { index: 5, src: './assets/images/covers/6.png', title: 'Book 6' },
    { index: 6, src: './assets/images/covers/7.png', title: 'Book 7' },
    { index: 7, src: './assets/images/covers/8.png', title: 'Book 8' },
    { index: 8, src: './assets/images/covers/9.png', title: 'Book 9' },
    { index: 9, src: './assets/images/covers/10.png', title: 'Book 10' },
    { index: 10, src: './assets/images/covers/11.png', title: 'Book 11' },
    { index: 11, src: './assets/images/covers/12.png', title: 'Book 12' }
];

function updateModalDisplay() {
    const image = galleryImages[currentImageIndex];
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('galleryModalLabel');

    if (modalImage) {
        modalImage.src = image.src;
        modalImage.alt = image.title;
    }
    if (modalTitle) {
        modalTitle.textContent = image.title;
    }
}

function goToPreviousImage() {
    currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
    updateModalDisplay();
}

function goToNextImage() {
    currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
    updateModalDisplay();
}

// Attach click handlers to gallery images
document.addEventListener('DOMContentLoaded', function () {
    const galleryImgs = document.querySelectorAll('.gallery-img');

    galleryImgs.forEach(img => {
        img.addEventListener('click', function () {
            currentImageIndex = parseInt(this.dataset.imageIndex);
            updateModalDisplay();
        });
    });

    // Attach previous/next button handlers
    const btnPrev = document.querySelector('.btn-prev');
    const btnNext = document.querySelector('.btn-next');

    if (btnPrev) {
        btnPrev.addEventListener('click', goToPreviousImage);
    }
    if (btnNext) {
        btnNext.addEventListener('click', goToNextImage);
    }
});

const booksList = [
    { id: 1, title: "The Midnight Library", author: "Matt Haig", genre: "Fiction", year: 2020, price: "$24.99", status: "available" },
    { id: 2, title: "Project Hail Mary", author: "Andy Weir", genre: "Science Fiction", year: 2021, price: "$28.99", status: "available" },
    { id: 3, title: "Dune", author: "Frank Herbert", genre: "Science Fiction", year: 1965, price: "$22.99", status: "available" },
    { id: 4, title: "The Hobbit", author: "J.R.R. Tolkien", genre: "Fantasy", year: 1937, price: "$18.99", status: "available" },
    { id: 5, title: "1984", author: "George Orwell", genre: "Dystopian", year: 1949, price: "$16.99", status: "available" },
    { id: 6, title: "Pride and Prejudice", author: "Jane Austen", genre: "Romance", year: 1813, price: "$14.99", status: "reserved" },
    { id: 7, title: "To Kill a Mockingbird", author: "Harper Lee", genre: "Fiction", year: 1960, price: "$19.99", status: "available" },
    { id: 8, title: "The Great Gatsby", author: "F. Scott Fitzgerald", genre: "Fiction", year: 1925, price: "$15.99", status: "sold" },
    { id: 9, title: "Educated", author: "Tara Westover", genre: "Memoir", year: 2018, price: "$20.99", status: "available" },
    { id: 10, title: "The Seven Husbands", author: "Taylor Jenkins Reid", genre: "Fiction", year: 2017, price: "$18.99", status: "reserved" },
    { id: 11, title: "Atomic Habits", author: "James Clear", genre: "Self-Help", year: 2018, price: "$26.99", status: "available" },
    { id: 12, title: "Sapiens", author: "Yuval Noah Harari", genre: "Non-Fiction", year: 2014, price: "$27.99", status: "available" }
];


/**
 * Render books to the DOM
 * @param {Array} books - Array of book objects to render
 */
function renderBooks(books) {
    const booksList_el = document.getElementById('booksList');
    if (!booksList_el) return;

    if (books.length === 0) {
        booksList_el.innerHTML = '<li class="book-item empty-state"><p>No books found for this status.</p></li>';
        return;
    }

    booksList_el.innerHTML = books.map(book => `
        <li class="book-item" data-status="${book.status}">
            <div class="book-info">
                <span class="book-title">${book.title}</span>
                <span class="book-author">${book.author}</span>
            </div>
            <span class="book-year">${book.year}</span>
            <span class="book-status status-${book.status}">${book.status}</span>
        </li>
    `).join('');
}

/**
 * Filter books by status
 * @param {string} status - Status to filter by ('all' shows all books)
 */
function filterBooksByStatus(status) {
    const booksList_el = document.getElementById('booksList');


    // Wait for fade out animation to complete, then render new books
    setTimeout(() => {
        let filteredBooks = booksList;

        if (status !== 'all') {
            filteredBooks = booksList.filter(book => book.status === status);
        }

        booksList_el.classList.remove('filtering');
        renderBooks(filteredBooks);

    });
}

// Initialize books page functionality
document.addEventListener('DOMContentLoaded', function () {
    const dropdownItems = document.querySelectorAll('.dropdown-menu .dropdown-item');
    const filterDropdownBtn = document.getElementById('filterDropdown');

    // Add click handlers to dropdown items
    dropdownItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const status = this.dataset.status;

            // Update dropdown button text
            if (filterDropdownBtn) {
                filterDropdownBtn.textContent = this.textContent;
            }

            // Update active dropdown item
            dropdownItems.forEach(itm => itm.classList.remove('active'));
            this.classList.add('active');

            // Filter and render books
            filterBooksByStatus(status);
        });
    });

    // Render all books on initial load
    renderBooks(booksList);
});

// Export for potential external use
window.filterBooksByStatus = filterBooksByStatus;
window.renderBooks = renderBooks;
