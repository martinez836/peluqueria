function togglePassword() {
    const passwordInput = document.getElementById('contrasena');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
};