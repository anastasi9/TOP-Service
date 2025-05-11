document.addEventListener('DOMContentLoaded', function() {
    // Подтверждение опасных действий
    document.querySelectorAll('.btn-delete, .btn-ban').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm('Вы уверены, что хотите выполнить это действие?')) {
                e.preventDefault();
            }
        });
    });
    
    // Редактор текста для HTML-контента
    document.querySelectorAll('textarea').forEach(textarea => {
        if (textarea.closest('.content-item-form')) {
            // Инициализация простого редактора для текстовых областей
            textarea.style.minHeight = '150px';
            textarea.style.fontFamily = 'monospace';
        }
    });
    
    // Динамическая загрузка контента при смене страницы/секции
    const pageSelect = document.getElementById('page');
    if (pageSelect) {
        pageSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
    
    // Переключение видимости пароля
    const togglePassword = document.querySelector('.toggle-password');
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }
});