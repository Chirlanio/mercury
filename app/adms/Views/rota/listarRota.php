<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Listar Rotas</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->Dados['botao']['cad_rota']) {
                    echo "<a href='" . URLADM . "cadastrar-rota/cad-rota' class='btn btn-outline-success btn-sm'>Cadastrar</a> ";
                }
                ?>                
            </div>
        </div>
        <?php
        if (empty($this->Dados['listRota'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhuma rota encontrada!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
        }
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>Nome</th>
                        <th class="d-none d-sm-table-cell">Cor</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listRota'] as $r) {
                        extract($r);
                        ?>
                        <tr>
                            <th class="text-center align-middle"><?php echo $id; ?></th>
                            <td class="align-middle"><?php echo $nome; ?></td>
                            <td class="d-none d-sm-table-cell align-middle">
                                <span class="badge badge-<?php echo $cor; ?>"><?php echo $n_cor; ?></span>
                            </td>
                            <td class="text-center">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['vis_rota']) {
                                        echo "<a href='" . URLADM . "ver-rota/ver-rota/$id' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['edit_rota']) {
                                        echo "<a href='" . URLADM . "editar-rota/edit-rota/$id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['del_rota']) {
                                        echo "<a href='" . URLADM . "apagar-rota/apagar-rota/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['vis_rota']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "ver-rota/ver-rota/$id'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_rota']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "editar-rota/edit-rota/$id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_rota']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "apagar-rota/apagar-rota/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php
            echo $this->Dados['paginacao'];
            ?>
        </div>
    </div>
</div>
