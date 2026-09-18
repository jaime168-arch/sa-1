<?php

$pageTitle = "Gestão de Trens - Já Ismaga";

$trens = [
    [
        'id' => 1,
        'codigo' => 'TRN-101',
        'modelo' => 'Locomotiva Elétrica Class A',
        'capacidade' => 120,
        'status' => 'operacional',
        'velocidade_max' => 80.0
    ],
    [
        'id' => 2,
        'codigo' => 'TRN-202',
        'modelo' => 'Metrô Urbano Série B',
        'capacidade' => 200,
        'status' => 'manutencao',
        'velocidade_max' => 60.0
    ],
    [
        'id' => 3,
        'codigo' => 'TRN-303',
        'modelo' => 'Trem de Carga Compacto',
        'capacidade' => 50,
        'status' => 'inativo',
        'velocidade_max' => 45.0
    ]
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="../index.php">+ Já.Ismaga</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primaryNavbar" aria-controls="primaryNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="primaryNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="usuarios.php">Usuários</a></li>
                    <li class="nav-item"><a class="nav-link active" href="trens.php">Trens</a></li>
                    <li class="nav-item"><a class="nav-link" href="rotas.php">Rotas</a></li>
                    <li class="nav-item"><a class="nav-link" href="sensores.php">Sensores</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark m-0">Gestão de Trens</h3>
                <p class="text-muted small m-0">Listagem e controlo da frota de locomotivas e composições</p>
            </div>
            <a href="trem-form.php" class="btn btn-warning text-white fw-bold">Novo Trem</a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="ps-3">#</th>
                                <th scope="col">Código</th>
                                <th scope="col">Modelo / Descrição</th>
                                <th scope="col">Capacidade (Pass/Carga)</th>
                                <th scope="col">Velocidade Máx. (km/h)</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-end pe-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($trens)): ?>
                                <?php foreach ($trens as $trem): ?>
                                    <tr>
                                        <td class="ps-3"><?= htmlspecialchars($trem['id']); ?></td>
                                        <td><span class="badge bg-secondary"><?= htmlspecialchars($trem['codigo']); ?></span></td>
                                        <td class="fw-semibold"><?= htmlspecialchars($trem['modelo']); ?></td>
                                        <td><?= htmlspecialchars($trem['capacidade']); ?></td>
                                        <td><?= number_format($trem['velocidade_max'], 1, ',', '.'); ?> km/h</td>
                                        <td>
                                            <?php if ($trem['status'] === 'operacional'): ?>
                                                <span class="badge bg-success">Operacional</span>
                                            <?php elseif ($trem['status'] === 'manutencao'): ?>
                                                <span class="badge bg-warning text-dark">Em Manutenção</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Inativo</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end pe-3">
                                            <a href="trem-form.php?id=<?= $trem['id']; ?>" class="btn btn-sm btn-outline-primary me-1">Editar</a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmarExclusao(<?= $trem['id']; ?>)">Excluir</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Nenhum trem cadastrado no sistema.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmarExclusao(id) {
            if (confirm("Deseja realmente remover o trem #" + id + "?")) {
                window.location.href = "trem-deletar.php?id=" + id;
            }
        }
    </script>
</body>
</html>