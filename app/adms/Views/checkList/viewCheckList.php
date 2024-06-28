<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
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
                            echo "<a href='" . URLADM . "check-list/list' class='btn btn-outline-info btn-sm d-print-none'><i class='fas fa-list'></i></a> ";
                        }
                        if ($this->Dados['botao']['edit_check_list']) {
                            echo "<a href='" . URLADM . "edit-check-list/check-list/$hash_id' class='btn btn-outline-warning btn-sm d-print-none'><i class='fa-solid fa-pen-to-square'></i></a> ";
                        }
                        if ($this->Dados['botao']['del_check_list']) {
                            echo "<a href='" . URLADM . "delete-check-list/check-list/$hash_id' class='btn btn-outline-danger btn-sm d-print-none' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a> ";
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
                                echo "<a class='dropdown-item' href='" . URLADM . "check-list/list'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_check_list']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-check-list/check-list/$hash_id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_check_list']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "delete-check-list/check-list/$hash_id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
            <div class="form">
                <div class="col">
                    <div>
                        <h6>Perguntas respondidas: <span class="text-success"><?php echo $this->Dados['select']['countHashResp'][0]['resp_result']; ?></span>.</h6>
                    </div>
                    <div>
                        <h6>Faltam: <span class="text-danger"><?php echo $this->Dados['select']['countHashNoResp'][0]['no_resp_result']; ?></span>.</h6>
                    </div>
                    <?php
                    foreach ($this->Dados['select']['areas'] as $area) {
                        extract($area);
                        echo "<div class='border rounded p-3 my-1'>";
                        echo "<h5 class='mb-3'>$id_cla - $name_area</h5>";
                        foreach ($this->Dados['dados_check_list'] as $question) {
                            extract($question);
                            if ($adms_sits_question_id === 2) {
                                $point = 1;
                            } elseif ($adms_sits_question_id === 3) {
                                $point = '0,5';
                            } else {
                                $point = 0;
                            }
                            if ($id_cla == $cla_id) {
                                echo "<h6 class='mb-3'><span class='mr-1'>$id_cla.$order_question  -  $question_description</span> <span class='badge badge-dark'> $point/$points</span></h6>";
                                echo "<p><strong>Resposta:</strong> <span class='badge badge-$cor'>$name_sit</span></p>";
                                echo "<p><strong>Justificativa:</strong> $justified</p>";
                                echo "<p><strong>Plano de Ação:</strong> $action_plans</p>";
                                echo "<p><strong>Inicío:</strong> $action_plans</p>";
                                echo "<p><strong>Fim:</strong> $action_plans</p>";
                                echo "<p><strong>Responsável:</strong> $action_plans</p>";
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
    //$UrlDestino = URLADM . 'ordem-conserto/listar';
    //header("Location: $UrlDestino");
}    