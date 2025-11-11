// assets/js/Login.js
class Login {
    constructor() {
        this.form = document.getElementById('loginForm');
        this.usernameInput = document.getElementById('username'); 
        this.passwordInput = document.getElementById('password');
        this.passwordToggle = document.getElementById('passwordToggle');
        this.submitButton = this.form ? this.form.querySelector('.login-btn') : null;
        this.successMessage = document.getElementById('successMessage');
        
        this.init();
    }
    
    init() {
        if (!this.form) {
            console.error('Login form not found!');
            return;
        }
        this.bindEvents();
        this.setupPasswordToggle();
    }
    
    bindEvents() {
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        this.usernameInput.addEventListener('blur', () => this.validateUsername());
        this.passwordInput.addEventListener('blur', () => this.validatePassword());
        this.usernameInput.addEventListener('input', () => this.clearError('username'));
        this.passwordInput.addEventListener('input', () => this.clearError('password'));
    }
    
    setupPasswordToggle() {
        if (!this.passwordToggle) return;
        
        this.passwordToggle.addEventListener('click', () => {
            const type = this.passwordInput.type === 'password' ? 'text' : 'password';
            this.passwordInput.type = type;
            
            const icon = this.passwordToggle.querySelector('.toggle-icon');
            if (icon) {
                icon.classList.toggle('show-password', type === 'text');
            }
        });
    }
    
    validateUsername() {
        const username = this.usernameInput.value.trim();
        
        if (!username) {
            this.showError('username', 'Username is required');
            return false;
        }
        
        this.clearError('username');
        return true;
    }
    
    validatePassword() {
        const password = this.passwordInput.value;
        
        if (!password) {
            this.showError('password', 'Password is required');
            return false;
        }
        
        this.clearError('password');
        return true;
    }
    
    showError(field, message) {
        const inputElement = document.getElementById(field);
        const errorElement = document.getElementById(`${field}Error`);
        const formGroup = inputElement ? inputElement.closest('.form-group') : null;
        
        if (formGroup && errorElement) {
            formGroup.classList.add('error');
            errorElement.textContent = message;
            errorElement.style.display = 'block';
            errorElement.style.opacity = '1';
        }
    }
    
    clearError(field) {
        const inputElement = document.getElementById(field);
        const errorElement = document.getElementById(`${field}Error`);
        const formGroup = inputElement ? inputElement.closest('.form-group') : null;
        
        if (formGroup && errorElement) {
            formGroup.classList.remove('error');
            errorElement.style.display = 'none';
            errorElement.style.opacity = '0';
            setTimeout(() => {
                errorElement.textContent = '';
            }, 300);
        }
    }
    
    async handleSubmit(e) {
        e.preventDefault();
        
        console.log('Form submitted');
        
        const isUsernameValid = this.validateUsername();
        const isPasswordValid = this.validatePassword();
        
        if (!isUsernameValid || !isPasswordValid) {
            console.log('Validation failed');
            return;
        }
        
        this.setLoading(true);
        
        try {
            const formData = new FormData(this.form);
            
            console.log('Sending request to login_process.php');
            
            // Tambahkan timeout untuk fetch
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 detik timeout
            
            const response = await fetch('Login_Proses.php', {
                method: 'POST',
                body: formData,
                signal: controller.signal
            });
            
            clearTimeout(timeoutId);
            
            console.log('Response status:', response.status);
            
            if (!response.ok) {
                throw new Error(`Server error: ${response.status} ${response.statusText}`);
            }

            const data = await response.json();
            console.log('Response data:', data);

            if (data.status === 'success') {
                this.showSuccess();
            } else {
                // Tampilkan error di field yang sesuai
                if (data.message.includes('Username')) {
                    this.showError('username', data.message);
                } else {
                    this.showError('password', data.message);
                }
            }

        } catch (error) {
            console.error('Fetch error:', error);
            if (error.name === 'AbortError') {
                this.showError('password', 'Request timeout. Please try again.');
            } else {
                this.showError('password', 'Cannot connect to server. Please check your connection.');
            }
        } finally {
            this.setLoading(false);
        }
    }
    
    setLoading(loading) {
        if (this.submitButton) {
            this.submitButton.classList.toggle('loading', loading);
            this.submitButton.disabled = loading;
            
            const btnText = this.submitButton.querySelector('.btn-text');
            const btnLoader = this.submitButton.querySelector('.btn-loader');
            
            if (btnText) btnText.style.opacity = loading ? '0' : '1';
            if (btnLoader) btnLoader.style.display = loading ? 'block' : 'none';
        }
    }
    
    showSuccess() {
        if (this.form) {
            this.form.style.display = 'none';
        }
        if (this.successMessage) {
            this.successMessage.style.display = 'block';
            this.successMessage.classList.add('show');
        }
        
        setTimeout(() => {
            console.log('Redirecting to dashboard...');
            window.location.href = 'dashboard.php';
        }, 2000);
    }
}

// Initialize the form when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM loaded, initializing Login...');
    new Login();
});