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
            <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
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
                    ?>
                    <div class="form">
                        <h5 class="mb-3"><?php echo $cla_id . " - " . $name_area; ?></h5>
                        <?php
                        foreach ($this->Dados['select']['questions'] as $question) {
                            extract($question);
                            if ($cla_id == $clqa_id) {
                                ?>
                                <h6 class="mb-3"><?php echo $cla_id . "." . $clq_id . " - " . $question_description; ?></h6>
                                <p>
                                    Pendente
                                </p>
                                <?php
                                echo "<img src='" . URLADM . "assets/imagens/'>";
                            }
                            ?>
                            <?php
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Solicitação não encontrada!</div>";
        //$UrlDestino = URLADM . 'ordem-conserto/listar';
        //header("Location: $UrlDestino");
    }    