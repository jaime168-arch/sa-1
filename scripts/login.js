document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm') || document.querySelector('form'); 
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    if (!loginForm) return;

    loginForm.addEventListener('submit', (event) => {
        event.preventDefault();

        const email = emailInput.value.trim();
        const password = passwordInput.value.trim();
        if (email === '' || password === '') {
            alert('Por favor, preencha todos os campos.');
            return;
        }
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Por favor, insira um e-mail válido.');
            return;
        }

      
        if (password.length < 4) {
            alert('A senha deve conter pelo menos 4 caracteres.');
            return;
        }

   
        console.log("Login realizado com sucesso para:", email);
        alert('Login realizado com sucesso! Bem-vindo de volta.');

       
        window.location.href = "home.html"; 
    });
});