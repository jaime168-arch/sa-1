<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Já Ismaga - Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar collapse min-vh-100 p-0">
            <div class="position-sticky pt-3">
                <div class="text-center py-4">
                    <h3 class="fw-bold text-white">Já Ismaga</h3>
                    <small class="text-white-50">Painel IoT</small>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="home.html"><i class="fa-solid fa-house me-2"></i> Início</a></li>
                    <li class="nav-item"><a class="nav-link active" href="usuario.html"><i class="fa-solid fa-microchip me-2"></i> Usuários</a></li>
                    <li class="nav-item"><a class="nav-link" href="sensores.html"><i class="fa-solid fa-users me-2"></i> Sensores</a></li>
                    <li class="nav-item"><a class="nav-link" href="c-sensor.html"><i class="fa-solid fa-microchip me-2"></i> Cadastrar Sensores</a></li>
                    <li class="nav-item"><a class="nav-link text-danger mt-5" href="login.html"><i class="fa-solid fa-right-from-bracket me-2"></i> Sair da Conta</a></li>
                </ul>
            </div>
        </nav>


   <main class="main-content px-md-4 py-4">
    <header class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-3">
        <div>
            <h2 class="fw-bold" style="color: var(--azul-ismaga);">Olá, Passageiro!</h2>
            <p class="text-muted mb-0">Bem-vindo à sua central de controle ferroviário.</p>
        </div>
        <div class="d-flex align-items-center">
            <div class="text-end me-3 d-none d-md-block">
                <p class="mb-0 fw-bold">João Silva</p>
                <small class="text-muted">ID: #88291</small>
            </div>
            <img src="https://ui-avatars.com/api/?name=Joao+Silva&background=002B5B&color=fff" class="rounded-circle shadow-sm" width="50" alt="Avatar">
        </div>
    </header>

    <div class="row g-4 mb-4">
        <div class="col-12 col-md-4">
            <div class="card card-stats bg-white shadow-sm p-4 border-0 rounded-4">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="p-2 bg-primary-subtle text-primary rounded-3"><i class="fa-solid fa-star fs-4"></i></div>
                    <h6 class="text-muted mb-0">Nível de Conta</h6>
                </div>
                <h4 class="fw-bold mb-0" style="color: var(--azul-ismaga);">Premium</h4>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card card-stats bg-white shadow-sm p-4 border-0 rounded-4">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="p-2 bg-secondary-subtle text-secondary rounded-3"><i class="fa-solid fa-clock-history fs-4"></i></div>
                    <h6 class="text-muted mb-1">Último Acesso</h6>
                </div>
                <h4 class="fw-bold mb-0" style="color: var(--azul-ismaga);">Hoje, 09:45</h4>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card card-stats bg-white shadow-sm p-4 border-0 rounded-4">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="p-2 bg-warning-subtle text-warning rounded-3"><i class="fa-solid fa-bolt fs-4"></i></div>
                    <h6 class="text-muted mb-1">Pontos de Fidelidade</h6>
                </div>
                <h4 class="fw-bold mb-0" style="color: var(--azul-ismaga);" id="fidelidade-pontos">2.450 pts</h4>
            </div>
        </div>
    </div>

    <div class="p-4 bg-white rounded-4 shadow-sm mb-4 border-0">
        <h5 class="fw-bold mb-2" style="color: var(--azul-ismaga);"><i class="fa-solid fa-wallet me-2"></i> Carteira Digital</h5>
        <p class="text-muted small">Adicione créditos e converta viagens em recompensas operacionais na malha Já Ismaga.</p>
        <button class="btn btn-sm btn-ismaga-primary px-4 py-2 fw-semibold" id="btn-recarga-rapida">
            <i class="fa-solid fa-plus me-1"></i> Recarga Rápida (+500 pts)
        </button>
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="mb-0 fw-bold" style="color: var(--azul-ismaga);">Histórico de Atividades</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tabela-atividades">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 border-0 text-muted small fw-bold">ATIVIDADE</th>
                        <th class="border-0 text-muted small fw-bold">DATA</th>
                        <th class="border-0 text-muted small fw-bold">STATUS</th>
                        <th class="text-end pe-4 border-0 text-muted small fw-bold">AÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-4 fw-semibold atividade-nome">Recarga de Cartão Digital</td>
                        <td class="text-muted atividade-data">13/05/2026</td>
                        <td><span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill atividade-status">Concluído</span></td>
                        <td class="text-end pe-4"><button class="btn btn-sm btn-outline-secondary btn-detalhes px-3">Detalhes</button></td>
                    </tr>
                    <tr>
                        <td class="ps-4 fw-semibold atividade-nome">Acesso Estação Central</td>
                        <td class="text-muted atividade-data">12/05/2026</td>
                        <td><span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill atividade-status">Concluído</span></td>
                        <td class="text-end pe-4"><button class="btn btn-sm btn-outline-secondary btn-detalhes px-3">Detalhes</button></td>
                    </tr>
                    <tr>
                        <td class="ps-4 fw-semibold atividade-nome">Suporte via Chat</td>
                        <td class="text-muted atividade-data">10/05/2026</td>
                        <td><span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill atividade-status">Em Análise</span></td>
                        <td class="text-end pe-4"><button class="btn btn-sm btn-outline-secondary btn-detalhes px-3">Detalhes</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>

<div class="modal fade" id="modalDetalhesAtividade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" style="color: var(--azul-ismaga);"><i class="fa-solid fa-circle-info me-2"></i> Detalhes da Atividade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <div class="mb-3">
                    <label class="text-muted small d-block">Descrição do Serviço</label>
                    <span id="modal-nome" class="fw-bold fs-5 text-dark">-</span>
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <label class="text-muted small d-block">Data do Evento</label>
                        <span id="modal-data" class="fw-semibold text-secondary">-</span>
                    </div>
                    <div class="col-6">
                        <label class="text-muted small d-block">Status Atual</label>
                        <div id="modal-status-container">-</div>
                    </div>
                </div>
                <hr class="my-3 opacity-25">
                <p class="text-muted small mb-0 font-monospace text-center">Registro de Bilhetagem Integrada — Já Ismaga IoT</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary w-100 rounded-3" data-bs-dismiss="modal">Fechar Registro</button>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>