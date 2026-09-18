<?php

$pageTitle = "Gestão de Rotas - Já Ismaga";


$rotas = [
    [
        'id' => 1,
        'codigo' => 'ROT-01',
        'nome' => 'Linha 1 - Norte / Sul',
        'origem' => 'Estação Central',
        'destino' => 'Terminal Industrial',
        'distancia' => 12.50,
        'status' => 'ativa'
    ],
    [
        'id' => 2,
        'codigo' => 'ROT-02',
        'nome' => 'Linha 2 - Leste / Oeste',
        'origem' => 'Estação das Flores',
        'destino' => 'Pátio Logístico',
        'distancia' => 8.75,
        'status' => 'manutencao'
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
                    <li class="nav-item"><a class="nav-link active" href="rotas.php">Rotas</a></li>
                    <li class="nav-item"><a class="nav-link" href="sensores.php">Sensores</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="container my-4">
        
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark m-0">Gestão de Rotas</h3>
                <p class="text-muted small m-0">Listagem de trechos e malha ferroviária cadastrada</p>
            </div>
            <a href="rota-form.php" class="btn btn-warning text-white fw-bold">Nova Rota</a>
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
                                <th scope="col">Nome da Rota</th>
                                <th scope="col">Origem</th>
                                <th scope="col">Destino</th>
                                <th scope="col">Distância (km)</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-end pe-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($rotas)): ?>
                                <?php foreach ($rotas as $rota): ?>
                                    <tr>
                                        <td class="ps-3"><?= htmlspecialchars($rota['id']); ?></td>
                                        <td><span class="badge bg-secondary"><?= htmlspecialchars($rota['codigo']); ?></span></td>
                                        <td class="fw-semibold"><?= htmlspecialchars($rota['nome']); ?></td>
                                        <td><?= htmlspecialchars($rota['origem']); ?></td>
                                        <td><?= htmlspecialchars($rota['destino']); ?></td>
                                        <td><?= number_format($rota['distancia'], 2, ',', '.'); ?></td>
                                        <td>
                                            <?php if ($rota['status'] === 'ativa'): ?>
                                                <span class="badge bg-success">Ativa</span>
                                            <?php elseif ($rota['status'] === 'manutencao'): ?>
                                                <span class="badge bg-warning text-dark">Manutenção</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Bloqueada</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end pe-3">
                                            <a href="rota-form.php?id=<?= $rota['id']; ?>" class="btn btn-sm btn-outline-primary me-1">Editar</a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmarExclusao(<?= $rota['id']; ?>)">Excluir</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">Nenhuma rota cadastrada no sistema.</td>
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
            if (confirm("Deseja realmente remover a rota #" + id + "?")) {
               
                window.location.href = "rota-deletar.php?id=" + id;
            }
        }
    </script>
</body>
</html>