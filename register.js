// Ждём загрузки DOM, чтобы элемент точно был на странице
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('register-btn');
    if (!btn) return;
  
    btn.addEventListener('click', function() {
      // Здесь можно открыть форму регистрации, показать модальное окно и т.д.
      // Для примера — просто выводим сообщение:
      alert('Спасибо за вашу заявку! Мы свяжемся с вами в ближайшее время.');
    });
  });
  
