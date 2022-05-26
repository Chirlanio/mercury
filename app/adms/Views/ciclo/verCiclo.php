<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_ciclo'][0])) {
    extract($this->Dados['dados_ciclo'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Detalhar Ciclo</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_ciclo']) {
                            echo "<a href='" . URLADM . "ciclos/listar' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->Dados['botao']['edit_ciclo']) {
                            echo "<a href='" . URLADM . "editar-ciclo/edit-ciclo/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->Dados['botao']['del_ciclo']) {
                            echo "<a href='" . URLADM . "apagar-ciclo/apagar-ciclo/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_ciclo']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "ciclos/listar'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_ciclo']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-ciclo/edit-ciclo/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_ciclo']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-ciclo/apagar-ciclo/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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

                <dt class="col-sm-3">Nome</dt>
                <dd class="col-sm-9"><?php echo $nome; ?></dd>

                <dt class="col-sm-3">Ano</dt>
                <dd class="col-sm-9"><?php echo $ano; ?></dd>

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
    $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    $UrlDestino = URLADM . 'ciclos/listar';
    header("Location: $UrlDestino");
}
