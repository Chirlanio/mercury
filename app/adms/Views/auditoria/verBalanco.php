<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_balanco'][0])) {
    extract($this->Dados['dados_balanco'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Detalhes do Balanço</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_balanco']) {
                            echo "<a href='" . URLADM . "balanco/listar' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i> Listar</a> ";
                        }
                        if ($this->Dados['botao']['edit_balanco']) {
                            echo "<a href='" . URLADM . "editar-balanco/edit-balanco/$id' class='btn btn-outline-warning btn-sm'><i class='fas fa-pen-fancy'></i> Editar</a> ";
                        }
                        if ($this->Dados['botao']['del_balanco']) {
                            echo "<a href='" . URLADM . "apagar-balanco/apagar-balanco/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i> Apagar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_balanco']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "balanco/listar'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_balanco']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-balanco/edit-balanco/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_balanco']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-balanco/apagar-balanco/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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

                <dt class="col-sm-2">ID</dt>
                <dd class="col-sm-10"><?php echo $id; ?></dd>

                <dt class="col-sm-2">Loja</dt>
                <dd class="col-sm-10"><?php echo $nome_loja; ?></dd>

                <dt class="col-sm-2">Responsável</dt>
                <dd class="col-sm-10"><?php echo $resp_loja; ?></dd>

                <dt class="col-sm-2">Auditor</dt>
                <dd class="col-sm-10"><?php echo $resp_aud; ?></dd>
                
                <dt class="col-sm-2">Observação</dt>
                <dd class="col-sm-10"><?php echo $obs; ?></dd>

                <dt class="col-sm-2">Status</dt>
                <dd class="col-sm-10"><?php echo $status; ?></dd>

                <dt class="col-sm-2">Cadastrado</dt>
                <dd class="col-sm-10"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></dd>

                <dt class="col-sm-2">Atualizado</dt>
                <dd class="col-sm-10"><?php
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
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Cadastro não encontrado!</div>";
    $UrlDestino = URLADM . 'balanco/listar';
    header("Location: $UrlDestino");
}
