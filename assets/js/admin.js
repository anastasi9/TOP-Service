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

document.querySelector('.sidebar').classList.add('collapsed');


if (window.innerWidth > 768) {
    document.querySelector('.sidebar').classList.remove('collapsed');
} else {
    document.querySelector('.sidebar').classList.add('collapsed');
}

document.addEventListener('DOMContentLoaded', function() {
    // Модальное окно новой заявки
    const modal = document.getElementById('newTicketModal');
    const btn = document.getElementById('newTicketBtn');
    const span = document.getElementsByClassName('close')[0];
    
    if (btn) {
        btn.onclick = function() {
            modal.style.display = 'block';
        }
    }
    
    span.onclick = function() {
        modal.style.display = 'none';
    }
    
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
    
    // Фильтрация заявок
    const searchInput = document.getElementById('ticketSearch');
    const statusFilter = document.getElementById('statusFilter');
    
    if (searchInput) {
        searchInput.addEventListener('input', filterTickets);
    }
    
    if (statusFilter) {
        statusFilter.addEventListener('change', filterTickets);
    }
    
    function filterTickets() {
        const searchValue = searchInput ? searchInput.value.toLowerCase() : '';
        const statusValue = statusFilter ? statusFilter.value : '';
        
        const rows = document.querySelectorAll('.tickets-table tbody tr');
        
        rows.forEach(row => {
            const title = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const status = row.getAttribute('data-status');
            
            const matchesSearch = title.includes(searchValue);
            const matchesStatus = statusValue === '' || status === statusValue;
            
            if (matchesSearch && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
});


document.addEventListener('DOMContentLoaded', function() {
    // Модальное окно новой заявки
    const modal = document.getElementById('newTicketModal');
    const btn = document.getElementById('newTicketBtn');
    const span = document.getElementsByClassName('close')[0];
    
    if (btn) {
        btn.onclick = function() {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
    }
    
    span.onclick = function() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }
    
    // Отображение выбранных файлов
    const fileInput = document.getElementById('attachments');
    const fileList = document.getElementById('fileList');
    
    if (fileInput && fileList) {
        fileInput.addEventListener('change', function() {
            fileList.innerHTML = '';
            
            if (this.files.length > 0) {
                for (let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];
                    const fileItem = document.createElement('div');
                    
                    // Определяем иконку в зависимости от типа файла
                    let iconClass = 'fa-file';
                    if (file.type.match('image.*')) {
                        iconClass = 'fa-file-image';
                    } else if (file.type.match('video.*')) {
                        iconClass = 'fa-file-video';
                    } else if (file.type.match('application/pdf')) {
                        iconClass = 'fa-file-pdf';
                    } else if (file.type.match('application/msword') || 
                               file.type.match('application/vnd.openxmlformats-officedocument.wordprocessingml.document')) {
                        iconClass = 'fa-file-word';
                    }
                    
                    fileItem.innerHTML = `
                        <i class="fas ${iconClass}"></i>
                        ${file.name} (${formatFileSize(file.size)})
                    `;
                    fileList.appendChild(fileItem);
                }
            }
        });
    }
    
    // Форматирование размера файла
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
});