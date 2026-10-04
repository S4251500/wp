// Keep these helpers available for the add-book form when it is connected later.
window.validateFileExtension = validateFileExtension;
window.showFileValidationMessage = showFileValidationMessage;

// Gallery Image Cycling
let currentImageIndex = 0;
const galleryImages = [
    { index: 0, src: './assets/images/covers/1.png', title: 'The Midnight Library' },
    { index: 1, src: './assets/images/covers/2.png', title: 'Project Hail Mary' },
    { index: 2, src: './assets/images/covers/3.png', title: 'Dune' },
    { index: 3, src: './assets/images/covers/4.png', title: 'The Hobbit' },
    { index: 4, src: './assets/images/covers/5.png', title: '1984' },
    { index: 5, src: './assets/images/covers/6.png', title: 'Pride and Prejudice' },
    { index: 6, src: './assets/images/covers/7.png', title: 'To Kill a Mockingbird' },
    { index: 7, src: './assets/images/covers/8.png', title: 'The Great Gatsby' },
    { index: 8, src: './assets/images/covers/9.png', title: 'Educated' },
    { index: 9, src: './assets/images/covers/10.png', title: 'The Seven Husbands of Evelyn Hugo' },
    { index: 10, src: './assets/images/covers/11.png', title: 'Atomic Habits' },
    { index: 11, src: './assets/images/covers/12.png', title: 'Sapiens' }
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
    const galleryImgs = document.querySelectorAll('.gallery-trigger');

    galleryImgs.forEach(img => {
        img.addEventListener('click', function () {
            currentImageIndex = Number(this.dataset.imageIndex);
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


// Book Filter page

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

function filterBooksByStatus(status) {
    const booksListElement = document.getElementById('booksList');
    if (!booksListElement) return;

    booksListElement.classList.add('filtering');
    window.setTimeout(() => {
        const bookItems = booksListElement.querySelectorAll('.book-item[data-status]');
        const emptyState = document.getElementById('booksEmptyState');
        let visibleCount = 0;

        bookItems.forEach(book => {
            const isVisible = status === 'all' || book.dataset.status === status;
            book.classList.toggle('d-none', !isVisible);
            if (isVisible) visibleCount++;
        });

        if (emptyState) {
            emptyState.classList.toggle('d-none', visibleCount > 0);
            emptyState.querySelector('p').textContent = 'No books found for this status.';
        }

        booksListElement.classList.remove('filtering');
    }, 120);
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

});

// Export for potential external use
window.filterBooksByStatus = filterBooksByStatus;
