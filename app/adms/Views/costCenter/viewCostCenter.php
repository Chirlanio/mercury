<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_cost'][0])) {
    extract($this->Dados['dados_cost'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Centro de Custos</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_cost']) {
                            echo "<a href='" . URLADM . "cost-centers/list' class='btn btn-outline-info btn-sm'><i class='fa-solid fa-list'></i></a> ";
                        }
                        if ($this->Dados['botao']['edit_cost']) {
                            echo "<a href='" . URLADM . "edit-cost-center/cost-center/$cc_id' class='btn btn-outline-warning btn-sm'><i class='fa-solid fa-pen-to-square'></i></a> ";
                        }
                        if ($this->Dados['botao']['del_cost']) {
                            echo "<a href='" . URLADM . "delete-cost-center/cost-center/$cc_id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_cost']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "cost-centers/list'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_cost']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-cost-center/cost-center/$id_bai'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_cost']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "delete-cost-center/cost-center/$id_bai' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div><hr>
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
            <dl class="row">

                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?php echo $cc_id; ?></dd>

                <dt class="col-sm-3">Id Centro de Custo</dt>
                <dd class="col-sm-9" id="cost_center_id"><?php echo $cost_center_id; ?></dd>

                <dt class="col-sm-3">Centro de Custo</dt>
                <dd class="col-sm-9"><?php echo $costCenter; ?></dd>

                <dt class="col-sm-3">Gerencia</dt>
                <dd class="col-sm-9"><?php echo $gerencia; ?></dd>

                <dt class="col-sm-3">Situação</dt>
                <dd class="col-sm-9"><?php echo $status; ?></dd>

                <dt class="col-sm-3">Cadastrado</dt>
                <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></dd>

                <dt class="col-sm-3">Atualizado</dt>
                <dd class="col-sm-9"><?php
                    if (!empty($modified)) {
                        echo date('d/m/Y H:i:s', strtotime($modified));
                    }
                    ?>
                </dd>
            </dl>
        </div>
    </div>
    <?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Centro de custo não foi encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    $UrlDestino = URLADM . 'cost-centers/list';
    header("Location: $UrlDestino");
}
