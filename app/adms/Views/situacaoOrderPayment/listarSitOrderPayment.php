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
                <h2 class="display-4 titulo">Situação - Ordem de Pagamento</h2>
            </div>
            <?php
            if ($this->Dados['botao']['cad_sit']) {
                echo "<a href='" . URLADM . "cadastrar-sit-order-payment/cad-sit' class='btn btn-outline-success btn-sm'><i class='fa-solid fa-square-plus'></i> Novo</a> ";
            }
            ?>
        </div>
        <hr>
        <?php
        if (empty($this->Dados['listSit'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhuma situação encontrada!
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
                        <th class="d-none d-sm-table-cell text-center">Ordem</th>
                        <th class="d-none d-sm-table-cell text-center">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listSit'] as $sit) {
                        extract($sit);
                        ?>
                        <tr>
                            <th class="text-center align-middle"><?php echo $id; ?></th>
                            <td class="align-middle"><?php echo $exibition_name; ?></td>
                            <td class="align-middle text-center"><?php echo $order_sit; ?></td>
                            <td class="d-none d-lg-table-cell align-middle text-center"><?php echo $status; ?></td>
                            <td class="text-center">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['edit_sit']) {
                                        echo "<a href='" . URLADM . "editar-sit-order-payment/edit-sit/$id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['del_sit']) {
                                        echo "<a href='" . URLADM . "apagar-sit-order-payment/apagar-sit/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['edit_sit']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "editar-sit-order-payment/edit-sit/$id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_sit']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "apagar-sit-order-payment/apagar-sit/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
