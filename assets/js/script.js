document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('automation-form');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Получаем данные формы
            const formData = new FormData(form);
            const solutionType = document.getElementById('solution-type').value;
            
            // Валидация
            if (!formData.get('name') || !formData.get('phone')) {
                alert('Пожалуйста, заполните обязательные поля');
                return;
            }
            
            // Здесь можно добавить AJAX-отправку
            console.log('Отправка данных:', {
                solution: solutionType,
                name: formData.get('name'),
                phone: formData.get('phone'),
                businessType: formData.get('business_type'),
                message: formData.get('message')
            });
            
            // Показ сообщения об успехе
            alert('Спасибо за заявку! Мы свяжемся с вами в ближайшее время.');
            form.reset();
        });
    }
    
    // Подсветка выбранного решения в форме
    const solutionLinks = document.querySelectorAll('[data-solution]');
    solutionLinks.forEach(link => {
        link.addEventListener('click', function() {
            const solutionName = this.getAttribute('data-solution');
            document.getElementById('solution-type').value = solutionName;
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Обработка кнопки заказа звонка
    const callbackBtn = document.querySelector('.callback-btn');
    if (callbackBtn) {
        callbackBtn.addEventListener('click', function() {
            // Здесь можно открыть модальное окно
            alert('Форма заказа звонка будет здесь');
            // Или: window.location.href = '/callback';
        });
    }
    
    // Обработка кнопки оставить заявку
    const requestBtn = document.querySelector('.request-btn');
    if (requestBtn) {
        requestBtn.addEventListener('click', function(e) {
            if (this.getAttribute('href') === '#request-form') {
                e.preventDefault();
                // Прокрутка к форме заявки
                document.querySelector('#request-form').scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    }
    
    // Мобильное меню (если нужно)
    const menuToggle = document.createElement('button');
    menuToggle.className = 'menu-toggle';
    menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
    const navList = document.querySelector('.nav-list');
    
    if (navList) {
        navList.parentNode.insertBefore(menuToggle, navList);
        
        menuToggle.addEventListener('click', function() {
            navList.classList.toggle('active');
        });
    }
});