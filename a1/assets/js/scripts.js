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
