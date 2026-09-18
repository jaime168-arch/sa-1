<?php
// Configurações e definições da página
$pageTitle = "Gestão de Sensores - Já Ismaga";

// Mock temporário de dados para renderização do layout
// Futuramente, estes dados serão recuperados do banco de dados MySQL via PHP
$sensores = [
    [
        'id' => 1,
        'codigo' => 'SNS-RFID-01',
        'nome' => 'Sensor Presença Curva A',
        'tipo' => 'RFID / Passagem',
        'localizacao' => 'Setor Norte - Curva 1',
        'status' => 'ativo'
    ],
    [
        'id' => 2,
        'codigo' => 'SNS-VEL-02',
        'nome' => 'Velocímetro Locomotiva D51',
        'tipo' => 'Telemetria',
        'localizacao' => 'Ativo Embarcado',
        'status' => 'ativo'
    ],
    [
        'id' => 3,
        'codigo' => 'SNS-FIM-01',
        'nome' => 'Fim de Curso Desvio Sul',
        'tipo' => 'Chave de Desvio',
        'localizacao' => 'Setor Sul - Agulha 3',
        'status' => 'calibracao'
    ]
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle); ?></title>
    
    <!-- Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class="bg-light">

    <!-- Primary Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="../index.php">+ Já.Ismaga</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primaryNavbar" aria-controls="primaryNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="primaryNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="usuarios.php">Usuários</a></li>
                    <li class="nav-item"><a class="nav-link" href="trens.php">Trens</a></li>
                    <li class="nav-item"><a class="nav-link" href="rotas.php">Rotas</a></li>
                    <li class="nav-item"><a class="nav-link active" href="sensores.php">Sensores</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="container my-4">
        
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark m-0">Gestão de Sensores IoT</h3>
                <p class="text-muted small m-0">Listagem de módulos de telemetria e presença em operação</p>
            </div>
            <a href="sensor-form.php" class="btn btn-warning text-white fw-bold">Novo Sensor</a>
        </div>

        <!-- Data Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="ps-3">#</th>
                                <th scope="col">Código</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Localização</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-end pe-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($sensores)): ?>
                                <?php foreach ($sensores as $sensor): ?>
                                    <tr>
                                        <td class="ps-3"><?= htmlspecialchars($sensor['id']); ?></td>
                                        <td><span class="badge bg-secondary"><?= htmlspecialchars($sensor['codigo']); ?></span></td>
                                        <td class="fw-semibold"><?= htmlspecialchars($sensor['nome']); ?></td>
                                        <td><?= htmlspecialchars($sensor['tipo']); ?></td>
                                        <td><?= htmlspecialchars($sensor['localizacao']); ?></td>
                                        <td>
                                            <?php if ($sensor['status'] === 'ativo'): ?>
                                                <span class="badge bg-success">Ativo</span>
                                            <?php elseif ($sensor['status'] === 'calibracao'): ?>
                                                <span class="badge bg-warning text-dark">Calibração</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Inativo</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end pe-3">
                                            <a href="sensor-form.php?id=<?= $sensor['id']; ?>" class="btn btn-sm btn-outline-primary me-1">Editar</a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmarExclusao(<?= $sensor['id']; ?>)">Excluir</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Nenhum sensor cadastrado no sistema.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>

    <!-- Scripts Section -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmarExclusao(id) {
            if (confirm("Deseja realmente remover o sensor #" + id + "?")) {
                window.location.href = "sensor-deletar.php?id=" + id;
            }
        }
    </script>
</body>
</html>