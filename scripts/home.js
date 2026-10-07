const app = {
    navegarPara: (tela) => {
        const containers = ['login-section', 'cadastro-section', 'dashboard-section'];
        containers.forEach(id => {
            const elemento = document.getElementById(id);
            if (elemento) {
                elemento.style.display = (id === tela) ? 'block' : 'none';
            }
        });
    },


    validarLogin: (event) => {
        event.preventDefault();
        
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        
        if (!emailInput || !passwordInput) return;

        const email = emailInput.value.trim();
        const password = passwordInput.value.trim();

        if (email === '' || password === '') {
            alert('Por favor, preencha todos os campos do login.');
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
        
        app.navegarPara('dashboard-section'); 
    },



    inicializarGrafico: () => {
        const ctx = document.getElementById('graficoTelemetria');
        if (!ctx) return;

      
        if (window.meuGraficoIoT) {
            window.meuGraficoIoT.destroy();
        }

        window.meuGraficoIoT = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['06:00', '08:00', '10:00', '12:00', '14:00', '16:00'],
                datasets: [{
                    label: 'Detecções por Hora',
                    data: [35, 72, 45, 90, 60, 85],
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    },

  
    despacharTrem: () => {
        const kpiTrens = document.getElementById('kpi-trens');
        if (!kpiTrens) return;

        let totalTrens = parseInt(kpiTrens.textContent) || 0;
        totalTrens++;
        kpiTrens.textContent = totalTrens;

        const codTrem = 'TRM-' + Math.floor(100 + Math.random() * 900);
        alert(`Sucesso! Trem [${codTrem}] foi despachado e integrado à malha via RFID.`);
        
        app.atualizarLogs('SISTEMA', `Novo ativo ${codTrem} acoplado à central.`);
    },


    gerarRelatorio: (botao) => {
        if (!botao) return;
        const textoOriginal = botao.innerHTML;
        botao.innerHTML = `<i class="fa-solid fa-spinner fa-spin me-2"></i> Processando...`;
        botao.disabled = true;

        setTimeout(() => {
            alert("Relatório de Telemetria e Alertas de Manutenção Preditiva compilado!");
            botao.innerHTML = textoOriginal;
            botao.disabled = false;
        }, 1200);
    },

    atualizarLogs: (tipo, mensagem) => {
        const logDinamico = document.getElementById('log-dinamico');
        if (!logDinamico) return;

        const agora = new Date().toLocaleTimeString();
        let classeTexto = 'text-info';

        if (tipo === 'ERRO') classeTexto = 'text-danger';
        if (tipo === 'AVISO') classeTexto = 'text-warning';

        logDinamico.insertAdjacentHTML('afterbegin', 
            `<div class="${classeTexto} mb-1">[${tipo}] ${agora} - ${mensagem}</div>`
        );
    },

    
    init: () => {
        
        app.inicializarGrafico();

        
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', app.validarLogin);
        }

       
        const cadastroForm = document.getElementById('cadastroForm') || document.querySelector('.form-container form');
        if (cadastroForm) {
            cadastroForm.addEventListener('submit', app.validarCadastro);
        }

    
        const btnAddTrem = document.getElementById('btn-add-trem');
        if (btnAddTrem) {
            btnAddTrem.addEventListener('click', app.despacharTrem);
        }

        const btnRelatorio = document.getElementById('btn-relatorio');
        if (btnRelatorio) {
            btnRelatorio.addEventListener('click', (e) => app.gerarRelatorio(e.currentTarget));
        }

        const idSensorInput = document.getElementById('idSensor');
        if (idSensorInput) {
            idSensorInput.addEventListener('input', () => {
                idSensorInput.value = idSensorInput.value.toUpperCase();
            });
        }
    }
};

document.addEventListener('DOMContentLoaded', app.init);