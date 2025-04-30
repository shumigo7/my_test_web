document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('register-modal');
    const closeBtn = document.getElementById('close-modal');
    const form = document.getElementById('register-form');
    const resultDiv = document.getElementById('register-result');
  
    // Показываем окно регистрации при заходе на страницу
    modal.style.display = 'block';
  
    // Закрытие модалки по крестику
    closeBtn.addEventListener('click', () => {
      modal.style.display = 'none';
    });
  
    // Если клик вне модалки — тоже закрыть
    window.addEventListener('click', event => {
      if (event.target === modal) {
        modal.style.display = 'none';
      }
    });
  
    // Обработка отправки формы
    form.addEventListener('submit', async event => {
      event.preventDefault();
      resultDiv.textContent = '';
  
      const formData = new FormData(form);
      try {
        const resp = await fetch(form.action, {
          method: 'POST',
          body: formData
        });
        const data = await resp.json();
  
        if (data.success) {
          resultDiv.style.color = 'green';
          resultDiv.textContent = 'Регистрация прошла успешно!';
          // Закрыть окно через 2 секунды
          setTimeout(() => modal.style.display = 'none', 2000);
        } else {
          resultDiv.style.color = 'red';
          resultDiv.textContent = data.error || 'Ошибка регистрации';
        }
      } catch (err) {
        console.error(err);
        resultDiv.style.color = 'red';
        resultDiv.textContent = 'Сетевая ошибка';
      }
    });
  });
  
  
