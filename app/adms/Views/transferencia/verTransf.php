<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_transf'][0])) {
    extract($this->Dados['dados_transf'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Transferência - Origem: <?php echo $loja_ori; ?> - Destino: <?php echo $loja_des; ?></h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_transf']) {
                            echo "<a href='" . URLADM . "transferencia/listar-transf' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->Dados['botao']['edit_transf']) {
                            echo "<a href='" . URLADM . "editar-transf/edit-transf/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->Dados['botao']['del_transf']) {
                            echo "<a href='" . URLADM . "apagar-transf/apagar-transf/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
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
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-transf/edit-transf/$id'>Editar</a>";
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
