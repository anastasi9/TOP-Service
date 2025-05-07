// Валидация формы регистрации
document.getElementById('register-form').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    if (!email.includes('@')) {
        e.preventDefault();
        alert('Введите корректный email!');
        return;
    }

    if (password.length < 8) {
        e.preventDefault();
        alert('Пароль должен быть не менее 8 символов!');
    }
});