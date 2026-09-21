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

    validarCadastro: (event) => {
        event.preventDefault();
        const nomeInput = document.getElementById('nome') || document.getElementById('nomeSensor');
        const emailInput = document.getElementById('email_cadastro') || document.getElementById('idSensor');

        if (!nomeInput || !emailInput) return;

        const nome = nomeInput.value.trim();
        const emailOrId = emailInput.value.trim();

        if (nome && emailOrId) {
            alert(`Ativo/Usuário "${nome}" preparado para integração com CRUD PHP!`);
            const tabela = document.getElementById('painel-logs');
            if (tabela) app.atualizarLogs('SISTEMA', `Novo dispositivo cadastrado: ${nome}`);
        } else {
            alert("Por favor, preencha todos os campos obrigatórios.");
        }
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

    definirSaudacaoDinamica: () => {
        const saudacaoElemento = document.querySelector('h2.fw-bold');
        if (saudacaoElemento) {
            const hora = new Date().getHours();
            let saudacaoText = "";

            if (hora >= 5 && hora < 12) saudacaoText = "Bom dia";
            else if (hora >= 12 && hora < 18) saudacaoText = "Boa tarde";
            else saudacaoText = "Boa noite";

            saudacaoElemento.innerText = `${saudacaoText}, Passageiro!`;
        }
    },

    initPassageiro: () => {
        const btnRecarga = document.getElementById('btn-recarga-rapida');
        const txtPontos = document.getElementById('fidelidade-pontos');

        if (btnRecarga && txtPontos) {
            btnRecarga.addEventListener('click', () => {
                let pontosAtuais = parseInt(txtPontos.textContent.replace(/[^\d]/g, '')) || 0;
                pontosAtuais += 500;
                txtPontos.textContent = pontosAtuais.toLocaleString('pt-BR') + ' pts';
                alert('Recarga realizada! +500 pontos adicionados à sua carteira Já Ismaga.');
            });
        }

        const tabela = document.getElementById('tabela-atividades');
        if (tabela) {
            tabela.addEventListener('click', (event) => {
                const botao = event.target.closest('.btn-detalhes') || event.target.closest('.btn-outline-primary');
                if (!botao) return;

                const linha = botao.closest('tr');
                const nomeElemento = linha.querySelector('.atividade-nome') || linha.cells[0];
                const dataElemento = linha.querySelector('.atividade-data') || linha.cells[1];
                const statusElemento = linha.querySelector('.atividade-status') || linha.cells[2];

                const nome = nomeElemento.innerText;
                const data = dataElemento ? dataElemento.innerText : new Date().toLocaleDateString();
                const badgeHTML = statusElemento ? statusElemento.outerHTML : '<span class="badge bg-secondary">Info</span>';

                const modalNome = document.getElementById('modal-nome');
                const modalData = document.getElementById('modal-data');
                const modalStatus = document.getElementById('modal-status-container');

                if (modalNome && modalData && modalStatus) {
                    modalNome.textContent = nome;
                    modalData.textContent = data;
                    modalStatus.innerHTML = badgeHTML;

                    const elementoModal = document.getElementById('modalDetalhesAtividade');
                    const bootstrapModal = new bootstrap.Modal(elementoModal);
                    bootstrapModal.show();
                } else {
                    alert(`Exibindo detalhes sobre: ${nome}`);
                }
            });
        }
    },

    carregarDadosIniciais: () => {
        console.log("Sincronizando dados do usuário...");
    },

    init: () => {
        app.definirSaudacaoDinamica();
        app.inicializarGrafico();
        app.initPassageiro();
        app.carregarDadosIniciais();

        const sidebar = document.querySelector('.sidebar');
        if (sidebar) {
            window.toggleSidebar = () => {
                sidebar.classList.toggle('active');
            };
        }

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

        const btnSair = document.querySelector('.text-danger'); 
        if (btnSair) {
            btnSair.addEventListener('click', (e) => {
                const confirmar = confirm("Deseja realmente sair da sua conta?");
                if (!confirmar) {
                    e.preventDefault(); 
                }
            });
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