<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
//var_dump($this->Dados['totalPoints']);
if (!empty($this->Dados['dados_check_list'][0])) {
    extract($this->Dados['dados_check_list'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-print-none d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Check List - Loja: <?php echo $stores; ?></h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_check_list']) {
                            echo "<a href='" . URLADM . "supply-check-list/list' class='btn btn-outline-info btn-sm d-print-none'><i class='fas fa-list'></i></a> ";
                        }
                        if ($this->Dados['botao']['edit_check_list']) {
                            echo "<a href='" . URLADM . "edit-supply-check-list/check-list/$hash_id' class='btn btn-outline-warning btn-sm d-print-none'><i class='fa-solid fa-pen-to-square'></i></a> ";
                        }
                        if ($this->Dados['botao']['del_check_list']) {
                            echo "<a href='" . URLADM . "delete-supply-check-list/check-list/$hash_id' class='btn btn-outline-danger btn-sm d-print-none' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_check_list']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "supply-check-list/list'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_check_list']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-supply-check-list/check-list/$hash_id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_check_list']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "delete-supply-check-list/check-list/$hash_id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="d-print-none">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
            <div class="form">
                <div class="col">

                    <div class="border border-radius rounded p-2 mb-3 d-block">

                        <div>
                            <h2 class="d-none d-print-block text-center">Loja <?php echo $stores; ?></h2>
                        </div>
                        <div class="col">
                            <div class="row d-print-none">
                                <div class="col d-flex">
                                    <h6 class="mr-2">Loja: </h6><?php echo $stores; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col d-flex">
                                    <h6 class="mr-2">ID: </h6><?php echo $hash_id; ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="mb-3">
                                        <h6>Pontuação Possível: <?php echo $this->Dados['totalPoints']['totalPoints'][0]['totalPoints']; ?></h6>
                                    </div>

                                    <div class="mb-3">
                                        <h6>Pontuação Total: <?php echo $this->Dados['totalPoints']['totalPontuation'][0]['totalPointsReceived']; ?></h6>
                                    </div>

                                    <div class="mb-3">
                                        <h6>Percentual atingido: <?php echo $this->Dados['totalPoints']['totalPercent'][0]['num_result']; ?>%</h6>
                                    </div>

                                    <div>
                                        <h6>Perguntas respondidas: <span class="text-success"><?php echo $this->Dados['select']['countHashResp'][0]['resp_result']; ?></span>.</h6>
                                    </div>
                                    <div>
                                        <h6>Faltam: <span class="text-danger"><?php echo $this->Dados['select']['countHashNoResp'][0]['no_resp_result']; ?></span>.</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 border-top">
                            <div class="col d-flex justify-content-between">
                                <div class="mt-3">
                                    <script type="text/javascript">
                                        google.charts.load("current", {packages: ['corechart']});
                                        google.charts.setOnLoadCallback(drawChart);

                                        function drawChart() {
                                            var data = google.visualization.arrayToDataTable([
                                                ["Áreas", "Percentual", {role: "style"}],
    <?php foreach ($this->Dados['totalPoints']['totalArea'] as $valueChart): ?>
                                                    ["<?php echo $valueChart['area_name']; ?>", <?php echo $valueChart['num_result']; ?>, "#009999"],
    <?php endforeach; ?>
                                            ]);

                                            var view = new google.visualization.DataView(data);
                                            view.setColumns([0, 1, {
                                                    calc: "stringify",
                                                    sourceColumn: 1,
                                                    type: "string",
                                                    role: "annotation"
                                                }, 2]);

                                            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                                            var options = getChartOptions();

                                            chart.draw(view, options);

                                            window.addEventListener('resize', function () {
                                                var options = getChartOptions();
                                                chart.draw(view, options);
                                            });
                                        }

                                        function getChartOptions() {
                                            var widthScreen = window.innerWidth;
                                            var options = {
                                                title: "Atingimento por Áreas",
                                                width: widthScreen * 0.70,
                                                height: (widthScreen < 400) ? 250 : 200,
                                                bar: {groupWidth: "80%"},
                                                legend: {position: "none"}
                                            };
                                            return options;
                                        }
                                    </script>

                                </div>
                                <div class="" id="columnchart_values" style="width: auto; height: 100%;"></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    foreach ($this->Dados['select']['areas'] as $area) {
                        extract($area);
                        echo "<div class='border rounded p-3 my-1 mb-3'>";
                        echo "<h5 class='mb-3'>$id_cla - $name_area</h5>";
                        foreach ($this->Dados['dados_check_list'] as $question) {
                            extract($question);
                            if ($adms_supply_sits_question_id === 2) {
                                $point = 1;
                            } elseif ($adms_supply_sits_question_id === 3) {
                                $point = 0;
                            } else {
                                $point = 0;
                            }
                            if ($id_cla == $cla_id) {
                                echo "<h6 class='mb-3'><span class='mr-1'>$id_cla.$order_question  -  $question_description</span></h6>";
                                echo "<p><strong>Resposta:</strong> <span class='badge badge-$cor'>$name_sit</span></p>";
                                echo "<p><strong>Justificativa:</strong> $justified</p>";
                                echo "<p><strong>Plano de Ação:</strong> $action_plans</p>";
                                echo "<p><strong>Inicío:</strong> " . (!empty($initial_date) ? date("d/m/Y", strtotime($initial_date)) : "") . "</p>";
                                echo "<p><strong>Fim:</strong> " . (!empty($initial_date) ? date("d/m/Y", strtotime($final_date)) : "") . "</p>";
                                echo "<p><strong>Responsável:</strong> $responsible</p>";
                                echo "<div class = 'col-12 mb-1' style = 'height: 250px; width: 100%;'>";
                                echo "<h6 class = 'my-0'><p>Fotos:</p></h6>";
                                echo "<small class = 'text-muted'>";
                                $types = array('png', 'jpg', 'jpeg');
                                $path = 'assets/imagens/commercial/checkList/' . $hash_id . '/' . $cls_id . '/';
                                if (file_exists($path) && is_dir($path)) {
                                    $dir = new DirectoryIterator($path);
                                    foreach ($dir as $fileInfo) {
                                        $ext = strtolower($fileInfo->getExtension());
                                        if (in_array($ext, $types)) {
                                            $arquivo = $fileInfo->getFilename();
                                            echo "<img src='" . URLADM . "assets/imagens/commercial/checkList/$hash_id/$cls_id/$arquivo' class='img-thumbnail m-1' width='250' height='250'>";
                                        }
                                    }
                                }
                                echo "</small>";
                                echo "</div>";
                            }
                        }

                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Solicitação não encontrada!</div>";
    $UrlDestino = URLADM . 'supply-check-list/list';
    header("Location: $UrlDestino");
}    