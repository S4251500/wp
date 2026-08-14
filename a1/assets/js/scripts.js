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
