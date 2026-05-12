// js/admin_modal.js — финальная версия (только одна кнопка "Сохранить")

document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('adminModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalBody = document.getElementById('modalBody');
    const closeBtn = document.querySelector('.admin_modal_close');

    window.openAdminModal = function (title, content) {
        modalTitle.textContent = title;
        modalBody.innerHTML = content;
        modal.style.display = 'flex';
    };

    window.closeModal = function () {
        modal.style.display = 'none';
    };

    closeBtn.onclick = closeModal;
    modal.onclick = function (e) {
        if (e.target === modal) closeModal();
    };
});