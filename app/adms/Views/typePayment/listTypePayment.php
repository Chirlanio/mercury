<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Tipos de Pagamentos</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->Dados['botao']['add_pay']) {
                    echo "<a href='" . URLADM . "add-type-payments/type-payment' class='btn btn-outline-success btn-sm'><i class='fa-solid fa-square-plus'></i> Novo</a> ";
                }
                ?>                
            </div>
        </div>
        <hr>
        <?php
        if (empty($this->Dados['listType'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum Tipo de Pagamento encontrado!
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
                        <th class="text-center">Tipo de Pagamento</th>
                        <th class="text-center">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listType'] as $c) {
                        extract($c);
                        ?>
                        <tr>
                            <th class="text-center align-middle"><?php echo $id; ?></th>
                            <td class="text-center align-middle"><?php echo $name; ?></td>
                            <td class="text-center align-middle"><?php echo $status; ?></td>
                            <td class="text-center">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['view_pay']) {
                                        echo "<a href='" . URLADM . "view-type-payments/type-payment/$id' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['edit_pay']) {
                                        echo "<a href='" . URLADM . "edit-type-payments/type-payment/$id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['del_pay']) {
                                        echo "<a href='" . URLADM . "delete-type-payments/type-payment/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['view_pay']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "view-type-payments/type-payment/$id'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_pay']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "edit-type-payments/type-payment/$id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_pay']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "delete-type-payments/type-payment/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
