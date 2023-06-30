<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_rota'][0])) {
    extract($this->Dados['dados_rota'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Detalhes da Rota</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_rota']) {
                            echo "<a href='" . URLADM . "rota/listar' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->Dados['botao']['edit_rota']) {
                            echo "<a href='" . URLADM . "editar-rota/edit-rota/$r_id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->Dados['botao']['del_rota']) {
                            echo "<a href='" . URLADM . "apagar-rota/apagar-rota/$r_id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_rota']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "rota/listar'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_rota']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-rota/edit-rota/$r_id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_rota']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-rota/apagar-rota/$r_id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
                <dd class="col-sm-9"><?php echo $r_id; ?></dd>

                <dt class="col-sm-3">Nome</dt>
                <dd class="col-sm-9"><?php echo $rota; ?></dd>                

                <dt class="col-sm-3">Cor</dt>
                <dd class="col-sm-9">
                    <span class="badge badge-<?php echo $cor; ?>"><?php echo $n_cor; ?></span>
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
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Rota não encontrada!</div>";
    $UrlDestino = URLADM . 'rota/listar';
    header("Location: $UrlDestino");
}
