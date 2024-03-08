<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_bandeira'][0])) {
    extract($this->Dados['dados_bandeira'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Bandeira - <?php echo $bandeira; ?></h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_bandeira']) {
                            echo "<a href='" . URLADM . "bandeira/listar' class='btn btn-outline-info btn-sm'><i class='fa-solid fa-list'></i></a> ";
                        }
                        if ($this->Dados['botao']['edit_bandeira']) {
                            echo "<a href='" . URLADM . "editar-bandeira/edit-bandeira/$id_ban' class='btn btn-outline-warning btn-sm'><i class='fa-solid fa-pen-to-square'></i></a> ";
                        }
                        if ($this->Dados['botao']['del_bandeira']) {
                            echo "<a href='" . URLADM . "apagar-bandeira/apagar-bandeira/$id_ban' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fa-solid fa-eraser'></i></a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_bandeira']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "bandeira/listar'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_bandeira']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-bandeira/edit-bandeira/$id_ban'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_bandeira']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-bandeira/apagar-bandeira/$id_ban' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
                <dd class="col-sm-9"><?php echo $id_ban; ?></dd>

                <dt class="col-sm-3">Nome</dt>
                <dd class="col-sm-9"><?php echo $bandeira; ?></dd>

                <dt class="col-sm-3">Ícone</dt>
                <dd class="col-sm-9"><?php echo $icone; ?></dd>

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
    $_SESSION['msg'] = "<div class='alert alert-danger'>Bandeira não encontrada!</div>";
    $UrlDestino = URLADM . 'bandeira/listar';
    header("Location: $UrlDestino");
}
