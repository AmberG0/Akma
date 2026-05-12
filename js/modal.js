// modal.js
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("loginModal");
    const openBtn = document.getElementById("openLoginModal");
    const closeBtn = document.querySelector(".close");

    // Проверка, что все элементы найдены
    if (!modal || !openBtn || !closeBtn) {
        console.warn("Модальное окно: один из элементов не найден.");
        return;
    }

    // Открыть модальное окно
    openBtn.addEventListener("click", function (e) {
        e.preventDefault(); // отменяем действие по умолчанию (если бы это была ссылка)
        modal.style.display = "flex";
    });

    // Закрыть по крестику
    closeBtn.addEventListener("click", function () {
        modal.style.display = "none";
    });

    // Закрыть при клике на затемнённый фон
    window.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });

    // Опционально: закрытие по клавише Esc
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && modal.style.display === "flex") {
            modal.style.display = "none";
        }
    });
});