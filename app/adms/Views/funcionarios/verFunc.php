<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_func'][0])) {
    extract($this->Dados['dados_func'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Funcionário - <?php echo $nome; ?></h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_func']) {
                            echo "<a href='" . URLADM . "funcionarios/listar-func' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->Dados['botao']['edit_func']) {
                            echo "<a href='" . URLADM . "editar-func/edit-func/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->Dados['botao']['del_func']) {
                            echo "<a href='" . URLADM . "apagar-func/apagar-func/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_func']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "funcionarios/listar-func'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_func']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-func/edit-func/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_func']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-func/apagar-func/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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

                <dt class="col-sm-2">Nome Completo</dt>
                <dd class="col-sm-10"><?php echo $nome; ?></dd>

                <dt class="col-sm-2">Usuário</dt>
                <dd class="col-sm-10"><?php echo $usuario; ?></dd>

                <dt class="col-sm-2">CPF</dt>
                <dd class="col-sm-10"><?php echo $cpf; ?></dd>

                <dt class="col-sm-2">Função</dt>
                <dd class="col-sm-10"><?php echo $cargo; ?></dd>

                <dt class="col-sm-2">Loja</dt>
                <dd class="col-sm-10"><?php echo $loja; ?></dd>

                <dt class="col-sm-2">Situação</dt>
                <dd class="col-sm-10"><?php echo $sit; ?></dd>

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
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Funcionário não encontrado!</div>";
    $UrlDestino = URLADM . 'funcionarios/listar-func';
    header("Location: $UrlDestino");
}
