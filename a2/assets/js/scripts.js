// Keep these helpers available to the add-book form.
window.validateFileExtension = validateFileExtension;
window.showFileValidationMessage = showFileValidationMessage;

// Gallery Image Cycling
let currentImageIndex = 0;
let galleryImages = [];

function updateModalDisplay() {
    const image = galleryImages[currentImageIndex];
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('galleryModalLabel');

    if (image && modalImage) {
        modalImage.src = image.src;
        modalImage.alt = image.title;
    }
    if (image && modalTitle) {
        modalTitle.textContent = image.title;
    }
}

function goToPreviousImage() {
    if (galleryImages.length === 0) return;
    currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
    updateModalDisplay();
}

function goToNextImage() {
    if (galleryImages.length === 0) return;
    currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
    updateModalDisplay();
}

// Attach click handlers to gallery images
document.addEventListener('DOMContentLoaded', function () {
    const addBookForm = document.getElementById('addBookForm');
    if (addBookForm) {
        const coverInput = document.getElementById('cover');
        const validationMessage = document.getElementById('coverValidationMessage');

        addBookForm.addEventListener('submit', function (event) {
            if (!showFileValidationMessage(coverInput, ['jpg', 'jpeg', 'png'], validationMessage)) {
                event.preventDefault();
            }
        });
    }

    const galleryImgs = document.querySelectorAll('.gallery-trigger');
    galleryImages = Array.from(galleryImgs, img => ({
        src: img.dataset.imageSrc,
        title: img.dataset.imageTitle
    }));

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
