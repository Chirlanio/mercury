<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_transf'][0])) {
    extract($this->Dados['dados_transf'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Transferência - Origem: <?php echo $loja_ori; ?> - Destino: <?php echo $loja_des; ?></h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_transf']) {
                            echo "<a href='" . URLADM . "transferencia/listar-transf/' class='btn btn-outline-info btn-sm d-print-none' title='Listar'><i class='fas fa-list'></i></a> ";
                        }
                        if ($this->Dados['botao']['edit_transf']) {
                            if (!empty($_SESSION['pesqOrigem'])) {
                                echo "<a href='" . URLADM . "editar-transf/edit-transf/$id?origem={$_SESSION['pesqOrigem']}&pg={$this->Dados['pg']}' class='btn btn-outline-warning btn-sm d-print-none' title='Editar'><i class='fa-solid fa-pen-to-square'></i></a> ";
                            } elseif (!empty($_SESSION['pesqDestino'])) {
                                echo "<a href='" . URLADM . "editar-transf/edit-transf/$id?destino={$_SESSION['pesqDestino']}&pg={$this->Dados['pg']}' class='btn btn-outline-warning btn-sm d-print-none' title='Editar'><i class='fa-solid fa-pen-to-square'></i></a> ";
                            } elseif (!empty($_SESSION['pesqStatus'])) {
                                echo "<a href='" . URLADM . "editar-transf/edit-transf/$id?status={$_SESSION['pesqStatus']}&pg={$this->Dados['pg']}' class='btn btn-outline-warning btn-sm d-print-none' title='Editar'><i class='fa-solid fa-pen-to-square'></i></a> ";
                            } else {
                                echo "<a href='" . URLADM . "editar-transf/edit-transf/$id?pg={$this->Dados['pg']}' class='btn btn-outline-warning btn-sm d-print-none' title='Editar'><i class='fa-solid fa-pen-to-square'></i></a> ";
                            }
                        }
                        if ($this->Dados['botao']['del_transf']) {
                            echo "<a href='" . URLADM . "apagar-transf/apagar-transf/$id' class='btn btn-outline-danger btn-sm' title='Apagar' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_transf']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "transferencia/listar'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_transf']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-transf/edit-transf/$id?origem=" . (isset($_SESSION['pesqOrigem']) and !empty($_SESSION['pesqOrigem'])) ? $_SESSION['pesqOrigem'] : '' . "&pg={$this->Dados['pg']}'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_transf']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-transf/apagar-transf/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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

                <dt class="col-sm-2">Loja de Origem</dt>
                <dd class="col-sm-10"><?php echo $loja_ori; ?></dd>

                <dt class="col-sm-2">Loja de Destino</dt>
                <dd class="col-sm-10"><?php echo $loja_des; ?></dd>

                <dt class="col-sm-2">Nota Fiscal</dt>
                <dd class="col-sm-10"><?php echo $nf; ?></dd>

                <dt class="col-sm-2">Volumes</dt>
                <dd class="col-sm-10"><?php echo $qtd_vol; ?></dd>

                <dt class="col-sm-2">Itens - Produtos</dt>
                <dd class="col-sm-10"><?php echo $qtd_prod; ?></dd>

                <dt class="col-sm-2">Tipo</dt>
                <dd class="col-sm-10"><?php echo $tipo; ?></dd>

                <dt class="col-sm-2">Situação</dt>
                <dd class="col-sm-10"><?php echo $sit; ?></dd>

                <dt class="col-sm-2">Entrega Confirmada?</dt>
                <dd class="col-sm-10"><?php echo $confirma_receb == 1 ? "Sim" : "Não"; ?></dd>

                <dt class="col-sm-2">Recebido Por:</dt>
                <dd class="col-sm-10"><?php echo $recebido; ?></dd>

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
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Solicitação não encontrada!</div>";
    $UrlDestino = URLADM . 'transferencia/listarTransf';
    header("Location: $UrlDestino");
}
    