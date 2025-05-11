document.addEventListener('DOMContentLoaded', function() {
    // Табы с тарифами
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            // Убираем активные классы
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            // Добавляем активные классы
            this.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        });
    });
    
    // Плавная прокрутка
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Валидация формы
    const serviceForm = document.getElementById('service-form');
    if (serviceForm) {
        serviceForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Простая валидация
            const name = document.getElementById('name').value;
            const phone = document.getElementById('phone').value;
            const serviceType = document.getElementById('service-type').value;
            
            if (!name || !phone || !serviceType) {
                alert('Пожалуйста, заполните обязательные поля');
                return;
            }
            
            // Отправка формы (заглушка)
            alert('Спасибо за заявку! Мы свяжемся с вами в ближайшее время.');
            this.reset();
        });
    }
    
    // Инициализация слайдеров (если подключены библиотеки)
    // $('.testimonials-slider').slick({...});
    // $('.clients-slider').slick({...});
});