<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_sit'][0])) {
    extract($this->Dados['dados_sit'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Situação</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_sit']) {
                            echo "<a href='" . URLADM . "situacao/listar' class='btn btn-outline-info btn-sm'><i class='fa-solid fa-list'></i></a> ";
                        }
                        if ($this->Dados['botao']['edit_sit']) {
                            echo "<a href='" . URLADM . "editar-sit/edit-sit/$id' class='btn btn-outline-warning btn-sm'><i class='fa-solid fa-pen-to-square'></i></a> ";
                        }
                        if ($this->Dados['botao']['del_sit']) {
                            echo "<a href='" . URLADM . "apagar-sit/apagar-sit/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fa-solid fa-eraser'></i></a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_sit']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "situacao/listar'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_sit']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-sit/edit-sit/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_sit']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-sit/apagar-sit/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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

                <dt class="col-sm-3">Situação</dt>
                <dd class="col-sm-9">
                    <span class="badge badge-<?php echo $cor_cr; ?>"><?php echo $nome; ?></span>
                </dd>

                <dt class="col-sm-3">Inserido</dt>
                <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></dd>

                <dt class="col-sm-3">Alterado</dt>
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
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Situação não encontrada!</div>";
    $UrlDestino = URLADM . 'situacao/listar';
    header("Location: $UrlDestino");
}
