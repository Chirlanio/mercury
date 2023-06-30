<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_cfop'][0])) {
    extract($this->Dados['dados_cfop'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Detalhes do Cfop</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_cfop']) {
                            echo "<a href='" . URLADM . "cfop/listar' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->Dados['botao']['edit_cfop']) {
                            echo "<a href='" . URLADM . "editar-cfop/edit-cfop/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->Dados['botao']['del_cfop']) {
                            echo "<a href='" . URLADM . "apagar-cfop/apagar-cfop/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_cfop']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "cfop/listar'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_cfop']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-cfop/edit-cfop/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_cfop']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-cfop/apagar-cfop/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
                <dd class="col-sm-9"><?php echo $id; ?></dd>

                <dt class="col-sm-3">Operação</dt>
                <dd class="col-sm-9"><?php echo $operation; ?></dd>

                <dt class="col-sm-3">CFOP</dt>
                <dd class="col-sm-9"><?php echo $cfop; ?></dd>

                <dt class="col-sm-3">Estado</dt>
                <dd class="col-sm-9"><?php echo ($estado == 1) ? "Ceará" : "Outros Estados"; ?></dd>

                <dt class="col-sm-3">CST ICMS</dt>
                <dd class="col-sm-9"><?php echo $cst_icms; ?></dd>

                <dt class="col-sm-3">Alicota ICMS</dt>
                <dd class="col-sm-9"><?php echo $aliq_icms . '%'; ?></dd>

                <dt class="col-sm-3">CST IPI</dt>
                <dd class="col-sm-9"><?php echo $cst_ipi; ?></dd>

                <dt class="col-sm-3">CST PIS/COFINS</dt>
                <dd class="col-sm-9"><?php echo $cst_pis_cofins; ?></dd>

                <dt class="col-sm-3">PIS</dt>
                <dd class="col-sm-9"><?php echo $pis . '%'; ?></dd>

                <dt class="col-sm-3">COFINS</dt>
                <dd class="col-sm-9"><?php echo $cofins . '%'; ?></dd>

                <dt class="col-sm-3">Tipo de Produto</dt>
                <dd class="col-sm-9"><?php echo ($tipo_produto == 1) ? "Acessório" : (($tipo_produto == 2) ? "Couro" : "Todos Produtos"); ?></dd>

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
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: CFOP não encontrado!</div>";
    $UrlDestino = URLADM . 'cfop/listar';
    header("Location: $UrlDestino");
}
