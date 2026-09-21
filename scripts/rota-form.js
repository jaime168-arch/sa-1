/**
 * Validação e Manipulação do Formulário de Rotas (Projeto Ferrorama - Já.Ismaga)
 */

document.addEventListener('DOMContentLoaded', () => {
    const formRota = document.querySelector('#form-rota');

    if (!formRota) return;

    // Seleção dos campos do formulário
    const inputNome = document.querySelector('#nome_rota');
    const inputOrigem = document.querySelector('#origem');
    const inputDestino = document.querySelector('#destino');
    const inputDistancia = document.querySelector('#distancia_km');
    const selectStatus = document.querySelector('#status_rota');

    // Validação ao submeter o formulário
    formRota.addEventListener('submit', (event) => {
        let erros = [];

        // Validação da Nome da Rota
        if (!inputNome || inputNome.value.trim().length < 3) {
            erros.push('Informe um nome válido para a rota (mínimo 3 caracteres).');
            marcarCampoInvalido(inputNome);
        } else {
            limparStatusCampo(inputNome);
        }

        // Validação da Estação de Origem
        if (!inputOrigem || inputOrigem.value.trim() === '') {
            erros.push('Informe o ponto ou estação de origem.');
            marcarCampoInvalido(inputOrigem);
        } else {
            limparStatusCampo(inputOrigem);
        }

        // Validação da Estação de Destino
        if (!inputDestino || inputDestino.value.trim() === '') {
            erros.push('Informe o ponto ou estação de destino.');
            marcarCampoInvalido(inputDestino);
        } else {
            limparStatusCampo(inputDestino);
        }

        // Validação de Origem e Destino Iguais
        if (inputOrigem && inputDestino && inputOrigem.value.trim().toLowerCase() === inputDestino.value.trim().toLowerCase() && inputOrigem.value.trim() !== '') {
            erros.push('A estação de origem não pode ser igual à de destino.');
            marcarCampoInvalido(inputDestino);
        }

        // Validação da Distância
        if (inputDistancia && (parseFloat(inputDistancia.value) <= 0 || isNaN(parseFloat(inputDistancia.value)))) {
            erros.push('Informe uma distância válida em KM (maior que zero).');
            marcarCampoInvalido(inputDistancia);
        } else if (inputDistancia) {
            limparStatusCampo(inputDistancia);
        }

        // Se houver erros, cancela o envio e exibe alerta
        if (erros.length > 0) {
            event.preventDefault();
            exibirAlertaErro(erros.join('\n'));
        }
    });

    // Funções auxiliares para feedback visual
    function marcarCampoInvalido(campo) {
        if (campo) {
            campo.classList.add('is-invalid');
            campo.classList.remove('is-valid');
        }
    }

    function limparStatusCampo(campo) {
        if (campo) {
            campo.classList.remove('is-invalid');
            campo.classList.add('is-valid');
        }
    }

    function exibirAlertaErro(mensagem) {
        let containerAlerta = document.querySelector('#container-alerta-js');
        
        if (!containerAlerta) {
            containerAlerta = document.createElement('div');
            containerAlerta.id = 'container-alerta-js';
            containerAlerta.className = 'alert alert-danger alert-dismissible fade show my-3';
            formRota.prepend(containerAlerta);
        }

        containerAlerta.innerHTML = `
            <strong>Atenção:</strong> Por favor, corrija os erros abaixo antes de salvar:
            <ul class="mb-0 mt-2">
                ${mensagem.split('\n').map(err => `<li>${err}</li>`).join('')}
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
    }
});