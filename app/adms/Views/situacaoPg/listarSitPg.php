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
                <h2 class="display-4 titulo">Listar Situação Página</h2>
            </div>
            <?php
            if ($this->Dados['botao']['cad_sit']) {
                ?>
                <a href="<?php echo URLADM . 'cadastrar-sit-pg/cad-sit-pg'; ?>">
                    <div class="p-2">
                        <button class="btn btn-outline-success btn-sm">
                            Cadastrar
                        </button>
                    </div>
                </a>
                <?php
            }
            ?>
        </div>
        <?php
        if (empty($this->Dados['listSitPg'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhuma situação de página encontrada!
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
                        <th class="d-none d-sm-table-cell text-center">Cor</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listSitPg'] as $sitPg) {
                        extract($sitPg);
                        ?>
                        <tr>
                            <th class="text-center align-middle"><?php echo $id; ?></th>
                            <td class="align-middle"><?php echo $nome; ?></td>
                            <td class="d-none d-lg-table-cell align-middle text-center">
                                <span class="badge badge-<?php echo $cor; ?>"><?php echo $nome; ?></span>
                            </td>
                            <td class="text-center">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['vis_sit']) {
                                        echo "<a href='" . URLADM . "ver-sit-pg/ver-sit-pg/$id' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['edit_sit']) {
                                        echo "<a href='" . URLADM . "editar-sit-pg/edit-sit-pg/$id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['del_sit']) {
                                        echo "<a href='" . URLADM . "apagar-sit-pg/apagar-sit-pg/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['vis_sit']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "ver-sit-pg/ver-sit-pg/$id'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_sit']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "editar-sit-pg/edit-sit-pg/$id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_sit']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "apagar-sit-pg/apagar-sit-pg/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
