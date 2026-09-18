    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script de Redirecionamento -->
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Impede o envio padrão do formulário (recarregar a página)

            // Pegar os dados digitados (caso queira usar depois)
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Insira aqui sua validação de login se necessário.
            // Se tudo estiver certo, redireciona para a página principal:
            window.location.href = 'dashboard.php'; 
        });
    </script>
</body>
</html>
