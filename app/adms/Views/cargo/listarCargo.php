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
                <h2 class="display-4 titulo">Listar Cargos</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->Dados['botao']['cad_cargo']) {
                    echo "<a href='" . URLADM . "cadastrar-cargo/cad-cargo' class='btn btn-outline-success btn-sm'>Cadastrar</a> ";
                }
                ?>                
            </div>

        </div>
        <?php
        if (empty($this->Dados['listCargo'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum Cargo encontrado!
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
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listCargo'] as $c) {
                        extract($c);
                        ?>
                        <tr>
                            <th class="text-center align-middle"><?php echo $id; ?></th>
                            <td class="align-middle"><?php echo $nome; ?></td>
                            <td class="text-center align-middle">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['vis_cargo']) {
                                        echo "<a href='" . URLADM . "ver-cargo/ver-cargo/$id' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['edit_cargo']) {
                                        echo "<a href='" . URLADM . "editar-cargo/edit-cargo/$id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['del_cargo']) {
                                        echo "<a href='" . URLADM . "apagar-cargo/apagar-cargo/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['vis_cargo']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "ver-cargo/ver-cargo/$id'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_cargo']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "editar-cargo/edit-cargo/$id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_cargo']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "apagar-cargo/apagar-cargo/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
