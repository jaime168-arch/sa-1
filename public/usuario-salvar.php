<body>
    <div class="">

    <main>
        <h1>Gerenciador de Sensores</h1>

                <nav class="menu-lateral">
            <div class="botoes">
                <div class="text-icon"> 
                    <a href="home.php">
                        <button class="botao">
                            <span class="icon"><i class="bi bi-house-fill"></i></span>
                            <span class="text">Home</span>
                        </button>
                    </a>
                </div>

                <div class="text-icon">
                    <a href="sensores.php">
                        <button class="botao">
                            <span class="icon"><i class="bi bi-broadcast-pin"></i></span>
                            <span class="text">Sensores</span>
                        </button>
                    </a>
                </div>
            </div>

            <div class="text-icon">
                <a href="trem.php">
                    <button class="botao">
                        <span class="icon"><i class="bi bi-train-front"></i></span>
                        <span class="text">Trens</span>
                    </button>
                </a>

            </div>

            <div class="text-icon">
                <a href="relatorios.php">
                    <button class="botao">
                        <span class="icon"><i class="bi bi-envelope-paper-fill"></i></span>
                        <span class="text">Relatórios</span>
                    </button>
                </a>
            </div>

            <div class="text-icon">
                <a href=""></a>
                    <button class="botao">
                        <span class="icon"><i class="bi bi-box-arrow-left"></i></span>
                        <span class="text">Sair</span>
                    </button>

            </div>

        <button><a href="public/cadastrar_sensor.php"> Novo Sensor</a></button>
        <br>
        <br>
        <form method="POST">
                
            </select>
           
        </form>
        <div class="table_sensores">
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>rota</th>
                    <th>unidade</th>
                    <th>Valor</th>
                    <th>Status</th>
                    <th>ID do Sensor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    </div>
                    <?php

                    while ($sensor = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>";
                        echo "<td>{$sensor['nome']}</td>";
                        echo "<td>{$sensor['rota']}</td>";
                        echo "<td>{$sensor['unidade']}</td>";
                        echo "<td>{$sensor['valor']}</td>";
                        echo "<td>{$sensor['status']}</td>";
                        echo "<td>{$sensor['id_sensor']}</td>";
                        echo "<td>
                                <a href='public/editar_sensor.php?id={$sensor['id']}'>Editar</a> |
                                <a href='public/excluir_sensor.php?id={$sensor['id']}'>Excluir</a>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                </tr>
            </tbody>
        </table>
    </main>

</div>
</body>

</html>