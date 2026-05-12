<div class="modal" id="modal_window">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <h2 id="modal_title">Заголовок</h2>
    <p id="modal_message">Текст сообщения</p>
    <button onclick="closeModal()">OK</button>
  </div>
</div>

<script>
function openModal(title, message) {
  document.getElementById('modal_title').textContent = title;
  document.getElementById('modal_message').textContent = message;
  document.getElementById('modal_window').style.display = 'flex';
}

function closeModal() {
  document.getElementById('modal_window').style.display = 'none';
}

// Закрытие по клику вне окна
window.onclick = function(event) {
  let modal = document.getElementById('modal_window');
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
