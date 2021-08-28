<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_loja'][0])) {
    extract($this->Dados['dados_loja'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Detalhes da Loja</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_loja']) {
                            echo "<a href='" . URLADM . "lojas/listarLojas' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->Dados['botao']['edit_loja']) {
                            echo "<a href='" . URLADM . "editar-loja/edit-loja/$id_loja' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->Dados['botao']['del_loja']) {
                            echo "<a href='" . URLADM . "apagar-loja/apagar-loja/$id_loja' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_loja']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "lojas/listarLojas'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_loja']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-loja/edit-loja/$id_loja'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_loja']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-loja/apagar-loja/$id_loja' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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

                <dt class="col-sm-3">Código</dt>
                <dd class="col-sm-9"><?php echo $id; ?></dd>

                <dt class="col-sm-3">Nome</dt>
                <dd class="col-sm-9"><?php echo $nome; ?></dd>

                <dt class="col-sm-3">Endereço</dt>
                <dd class="col-sm-9"><?php echo $endereco; ?></dd>

                <dt class="col-sm-3">CNPJ</dt>
                <dd class="col-sm-9"><?php echo $cnpj; ?></dd>

                <dt class="col-sm-3">Razão Social</dt>
                <dd class="col-sm-9"><?php echo $razao_social; ?></dd>

                <dt class="col-sm-3">Inscrição Estadual</dt>
                <dd class="col-sm-9"><?php echo $ins_estadual; ?></dd>

                <dt class="col-sm-3">Rede</dt>
                <dd class="col-sm-9"><?php echo $rede; ?></dd>

                <dt class="col-sm-3">Situação</dt>
                <dd class="col-sm-9"><?php echo $sit_lj; ?></dd>

                <dt class="col-sm-3">Cadastrada</dt>
                <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></dd>

                <dt class="col-sm-3">Atualizada</dt>
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
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Loja não encontrada!</div>";
    $UrlDestino = URLADM . 'lojas/listarLojas';
    header("Location: $UrlDestino");
}
