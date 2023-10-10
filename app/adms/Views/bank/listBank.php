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
                <h2 class="display-4 titulo">Bancos</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->Dados['botao']['add_bank']) {
                    echo "<a href='" . URLADM . "add-banks/add-bank' class='btn btn-outline-success btn-sm'>Cadastrar</a> ";
                }
                ?>                
            </div>
        </div>
        <?php
        if (empty($this->Dados['listBank'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum banco encontrado!
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
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Código</th>
                        <th class="text-center">Nome</th>
                        <th class="text-center">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listBank'] as $c) {
                        extract($c);
                        ?>
                        <tr>
                            <th class="text-center align-middle"><?php echo $id; ?></th>
                            <td class="align-middle"><?php echo $cod_bank; ?></td>
                            <td class="align-middle"><?php echo $bank_name; ?></td>
                            <td class="text-center align-middle"><?php echo $status; ?></td>
                            <td class="text-center align-middle">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['view_bank']) {
                                        echo "<a href='" . URLADM . "view-banks/view-bank/$id' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['edit_bank']) {
                                        echo "<a href='" . URLADM . "edit-banks/edit-bank/$id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['del_bank']) {
                                        echo "<a href='" . URLADM . "delete-banks/delete-bank/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['view_bank']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "view-banks/view-bank/$id'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_bank']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "edit-banks/edit-bank/$id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_bank']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "delete-banks/delete-bank/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
