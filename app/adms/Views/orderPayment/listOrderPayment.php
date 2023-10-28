<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
//var_dump($this->Dados['select']['backlog'][0]);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Ordens de Pagamentos</h2>
            </div>
            <?php
            if ($this->Dados['botao']['listOrder']) {
                ?>
                <a href="<?php echo URLADM . 'create-spreadsheet-order-payments/create'; ?>">
                    <div class="p-2">
                        <button class="btn btn-success btn-sm">
                            <span>
                                <i class="fas fa-table d-block d-md-none fa-2x"></i>
                                <span class='d-none d-md-block'>Planilha</span>
                            </span>
                        </button>
                    </div>
                </a>
                <?php
            }
            if ($this->Dados['botao']['add_payment']) {
                ?>
                <a href="<?php echo URLADM . 'add-order-payments/order-payment'; ?>">
                    <div class="p-2">
                        <button class="btn btn-outline-success btn-sm">
                            <span>
                                <i class="fas fa-plus d-block d-md-none fa-2x"></i>
                                <span class='d-none d-md-block'>Cadastrar</span>
                            </span>
                        </button>
                    </div>
                </a>
                <?php
            }
            ?>
        </div>
        <form class="form" method="POST" action="<?php echo URLADM . 'search-order-payments/list'; ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 col-lg-12 mb-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
                        </div>
                        <input name="search" type="text" id="search" class="form-control" aria-describedby="search" placeholder="Pesquise por fornecedor, área, centro de custo ou ID" value="<?php
                        if (isset($_SESSION['search'])) {
                            echo $_SESSION['search'];
                        }
                        ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group ml-sm-2 ml-md-2 ml-lg-2 ml-3">
                    <input name="SearchOrder" type="submit" class="btn btn-outline-primary mx-sm-2" value="Pesquisar">
                </div>
            </div>
        </form>
        <?php
        if (empty($this->Dados['list_backlog'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhuma ordem de pagamento encontrada!
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
            <table class="table">
                <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell text-center">Solicitações</th>
                        <th class="d-none d-sm-table-cell text-center">Registrado no Fiscal</th>
                        <th class="d-none d-sm-table-cell text-center">Lançado no Banco</th>
                        <th class="d-none d-sm-table-cell text-center">Pago</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">
                            <?php
                            foreach ($this->Dados['select']['backlog'] as $b) {
                                extract($b);
                                echo "<strong class='card border p-2 text-white bg-dark'>Total: R$ " . ($total_backlog > 0 ? number_format($total_backlog, 2, ',', '.') : 0) . "</strong>";
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                            foreach ($this->Dados['select']['doing'] as $d) {
                                extract($d);
                                echo "<strong class='card border p-2 text-white bg-dark'>Total: R$ " . ($total_doing > 0 ? number_format($total_doing, 2, ',', '.') : 0) . "</strong>";
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                            foreach ($this->Dados['select']['waiting'] as $w) {
                                extract($w);
                                echo "<strong class='card border p-2 text-white bg-dark'>Total: R$ " . ($total_waiting > 0 ? number_format($total_waiting, 2, ',', '.') : 0) . "</strong>";
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                            foreach ($this->Dados['select']['done'] as $do) {
                                extract($do);
                                echo "<strong class='card border p-2 text-white bg-dark'>Total: R$ " . ($total_done > 0 ? number_format($total_done, 2, ',', '.') : 0) . "</strong>";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div name="backlog" class="list-group border p-2">
                                <?php
                                foreach ($this->Dados['list_backlog'] as $backlog) {
                                    extract($backlog);
                                    ?>
                                    <div class="card bg-light m-1 w-auto">
                                        <h5 class="card-header">
                                            <div class="d-flex align-content-between justify-content-between">
                                                <span>ID: <?php echo $id; ?></span>
                                                <?php echo ($advance == 1 ? "<i class='fa-solid fa-bookmark text-warning'></i>" : ''); ?>
                                                <?php echo ((!empty($installments) and $installments > 1) ? "<i class='fa-solid fa-calendar-days text-info'></i>" : ''); ?>
                                                <?php echo ($proof == 1 ? "<i class='fa-solid fa-file-invoice text-white'></i>" : ''); ?>
                                            </div>
                                        </h5>
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo "Área: " . $area_backlog; ?></h5>
                                            <ul class="list-unstyled">
                                                <li class="card-text"><?php echo "<strong>Cadastro:</strong> " . date('d/m/Y', strtotime($created_date)); ?></li>
                                                <li><?php echo "<strong>Pagar:</strong> " . date('d/m/Y', strtotime($date_payment)); ?></li>
                                                <li class="card-text"><?php echo "<strong>Fornecedor:</strong> " . $fornecedor_backlog; ?></li>
                                            </ul>
                                            <div class="text-right">
                                                <span class="d-none d-md-block">
                                                    <?php
                                                    if ($this->Dados['botao']['view_payment']) {
                                                        echo "<a href='" . URLADM . "view-order-payments/order-payment/$id' class='btn btn-dark btn-sm'><i class='fas fa-eye'></i></a> ";
                                                    }
                                                    if ($this->Dados['botao']['edit_payment']) {
                                                        echo "<a href='" . URLADM . "edit-order-payments/order-payment/$id' class='btn btn-dark btn-sm'><i class='fas fa-pen-fancy'></i></a> ";
                                                    }
                                                    if ($this->Dados['botao']['del_payment']) {
                                                        echo "<a href='" . URLADM . "delete-order-payments/order-payment/$id' class='btn btn-dark btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a> ";
                                                    }
                                                    ?>
                                                </span>
                                                <div class="dropdown d-block d-md-none">
                                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Ações
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                                        <?php
                                                        if ($this->Dados['botao']['view_payment']) {
                                                            echo "<a class='dropdown-item' href='" . URLADM . "view-order-payments/order-payment/$id'>Visualizar</a>";
                                                        }
                                                        if ($this->Dados['botao']['edit_payment']) {
                                                            echo "<a class='dropdown-item' href='" . URLADM . "edit-order-payments/order-payment/$id'>Editar</a>";
                                                        }
                                                        if ($this->Dados['botao']['del_payment']) {
                                                            echo "<a class='dropdown-item' href='" . URLADM . "delete-order-payments/order-orderpayment/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>

                            </div>
                        </td>

                        <td class="d-none d-sm-table-cell">
                            <div name="doing" class="list-group border p-2">
                                <?php
                                foreach ($this->Dados['list_doing'] as $doing) {
                                    extract($doing);
                                    ?>
                                    <div class="card text-white bg-secondary m-1 w-auto">
                                        <h5 class="card-header">
                                            <div class="d-flex align-content-between justify-content-between">
                                                <span>ID: <?php echo $id; ?></span>
                                                <?php echo ($advance == 1 ? "<i class='fa-solid fa-bookmark text-warning'></i>" : ''); ?>
                                                <?php echo ((!empty($installments) and $installments > 1) ? "<i class='fa-solid fa-calendar-days text-info'></i>" : ''); ?>
                                                <?php echo ($proof == 1 ? "<i class='fa-solid fa-file-invoice text-white'></i>" : ''); ?>
                                            </div>
                                        </h5>
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo "Área: " . $area_doing; ?></h5>
                                            <ul class="list-unstyled">
                                                <li class="card-text"><?php echo "<strong>Cadastro:</strong> " . date('d/m/Y', strtotime($created_date)); ?></li>
                                                <li><?php echo "<strong>Pagar:</strong> " . date('d/m/Y', strtotime($date_payment)); ?></li>
                                                <li class="card-text"><?php echo "<strong>Fornecedor:</strong> " . $fornecedor_doing; ?></li>
                                            </ul>
                                            <div class="text-right">
                                                <span class="d-none d-md-block">

                                                    <?php
                                                    if ($this->Dados['botao']['view_payment']) {
                                                        echo "<a href='" . URLADM . "view-order-payments/order-payment/$id' class='btn btn-dark btn-sm'><i class='fas fa-eye'></i></a> ";
                                                    }
                                                    if ($this->Dados['botao']['edit_payment']) {
                                                        echo "<a href='" . URLADM . "edit-order-payments/order-payment/$id' class='btn btn-dark btn-sm'><i class='fas fa-pen-fancy'></i></a> ";
                                                    }
                                                    if ($this->Dados['botao']['del_payment']) {
                                                        echo "<a href='" . URLADM . "delete-order-payments/order-payment/$id' class='btn btn-dark btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a> ";
                                                    }
                                                    ?>
                                                </span>
                                                <div class="dropdown d-block d-md-none">
                                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Ações
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                                        <?php
                                                        if ($this->Dados['botao']['view_payment']) {
                                                            echo "<a class='dropdown-item' href='" . URLADM . "view-order-payments/order-payment/$id'>Visualizar</a>";
                                                        }
                                                        if ($this->Dados['botao']['edit_payment']) {
                                                            echo "<a class='dropdown-item' href='" . URLADM . "edit-order-payments/order-payment/$id'>Editar</a>";
                                                        }
                                                        if ($this->Dados['botao']['del_payment']) {
                                                            echo "<a class='dropdown-item' href='" . URLADM . "delete-order-payment/order-payment/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>

                            </div>
                        </td>

                        <td class="d-none d-sm-table-cell">
                            <div name="waiting" class="list-group border p-2">
                                <?php
                                foreach ($this->Dados['list_waiting'] as $waiting) {
                                    extract($waiting);
                                    ?>
                                    <div class="card text-white bg-info border-info m-1 w-auto">
                                        <h5 class="card-header">
                                            <div class="d-flex align-content-between justify-content-between">
                                                <span>ID: <?php echo $id; ?></span>
                                                <?php echo ($advance == 1 ? "<i class='fa-solid fa-bookmark text-warning'></i>" : ''); ?>
                                                <?php echo ((!empty($installments) and $installments > 1) ? "<i class='fa-solid fa-calendar-days text-danger'></i>" : ''); ?>
                                                <?php echo ($proof == 1 ? "<i class='fa-solid fa-file-invoice text-white'></i>" : ''); ?>
                                            </div>
                                        </h5>
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo "Área: " . $area_waiting; ?></h5>
                                            <ul class="list-unstyled">
                                                <li class="card-text"><?php echo "<strong>Cadastro:</strong> " . date('d/m/Y', strtotime($created_date)); ?></li>
                                                <li><?php echo "<strong>Pagar:</strong> " . date('d/m/Y', strtotime($date_payment)); ?></li>
                                                <li class="card-text"><?php echo "<strong>Fornecedor:</strong> " . $fornecedor_waiting; ?></li>
                                            </ul>
                                            <div class="text-right">
                                                <span class="d-none d-md-block">

                                                    <?php
                                                    if ($this->Dados['botao']['view_payment']) {
                                                        echo "<a href='" . URLADM . "view-order-payments/order-payment/$id' class='btn btn-dark btn-sm'><i class='fas fa-eye'></i></a> ";
                                                    }
                                                    if ($this->Dados['botao']['edit_payment']) {
                                                        echo "<a href='" . URLADM . "edit-order-payments/order-payment/$id' class='btn btn-dark btn-sm'><i class='fas fa-pen-fancy'></i></a> ";
                                                    }
                                                    if ($this->Dados['botao']['del_payment']) {
                                                        echo "<a href='" . URLADM . "delete-order-payments/order-payment/$id' class='btn btn-dark btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a> ";
                                                    }
                                                    ?>
                                                </span>
                                                <div class="dropdown d-block d-md-none">
                                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Ações
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                                        <?php
                                                        if ($this->Dados['botao']['view_payment']) {
                                                            echo "<a class='dropdown-item' href='" . URLADM . "view-order-payments/order-payment/$id'>Visualizar</a>";
                                                        }
                                                        if ($this->Dados['botao']['edit_payment']) {
                                                            echo "<a class='dropdown-item' href='" . URLADM . "edit-order-payments/order-payment/$id'>Editar</a>";
                                                        }
                                                        if ($this->Dados['botao']['del_payment']) {
                                                            echo "<a class='dropdown-item' href='" . URLADM . "delete-order-payments/order-payment/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>

                            </div>
                        </td>

                        <td class="d-none d-sm-table-cell">
                            <div name="done" class="list-group border p-2">
                                <?php
                                foreach ($this->Dados['list_done'] as $done) {
                                    extract($done);
                                    ?>
                                    <div class="card text-white bg-success m-1 w-auto">
                                        <h5 class="card-header">
                                            <div class="d-flex align-content-between justify-content-between">
                                                <span>ID: <?php echo $id; ?></span>
                                                <?php echo ($advance == 1 ? "<i class='fa-solid fa-bookmark text-warning'></i>" : ''); ?>
                                                <?php echo ((!empty($installments) and $installments > 1) ? "<i class='fa-solid fa-calendar-days text-danger'></i>" : ''); ?>
                                                <?php echo ($proof == 1 ? "<i class='fa-solid fa-file-invoice text-white'></i>" : ''); ?>
                                            </div>
                                        </h5>
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo "Área: " . $area_done; ?></h5>
                                            <ul class="list-unstyled">
                                                <li class="card-text"><?php echo "<strong>Cadastro:</strong> " . date('d/m/Y', strtotime($created_date)); ?></li>
                                                <li><?php echo "<strong>Pagar:</strong> " . date('d/m/Y', strtotime($date_payment)); ?></li>
                                                <li class="card-text"><?php echo "<strong>Fornecedor:</strong> " . $fornecedor_done; ?></li>
                                            </ul>
                                            <div class="text-right">
                                                <span class="d-none d-md-block">

                                                    <?php
                                                    if ($this->Dados['botao']['view_payment']) {
                                                        echo "<a href='" . URLADM . "view-order-payments/order-payment/$id' class='btn btn-dark btn-sm'><i class='fas fa-eye'></i></a> ";
                                                    }
                                                    if ($this->Dados['botao']['edit_payment']) {
                                                        echo "<a href='" . URLADM . "edit-order-payments/order-payment/$id' class='btn btn-dark btn-sm'><i class='fas fa-pen-fancy'></i></a> ";
                                                    }
                                                    if ($this->Dados['botao']['del_payment']) {
                                                        echo "<a href='" . URLADM . "delete-order-payments/order-payment/$id' class='btn btn-dark btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a> ";
                                                    }
                                                    ?>
                                                </span>
                                                <div class="dropdown d-block d-md-none">
                                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Ações
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                                        <?php
                                                        if ($this->Dados['botao']['view_payment']) {
                                                            echo "<a class='dropdown-item' href='" . URLADM . "view-order-payments/order-payment/$id'>Visualizar</a>";
                                                        }
                                                        if ($this->Dados['botao']['edit_payment']) {
                                                            echo "<a class='dropdown-item' href='" . URLADM . "edit-order-payments/order-payment/$id'>Editar</a>";
                                                        }
                                                        if ($this->Dados['botao']['del_payment']) {
                                                            echo "<a class='dropdown-item' href='" . URLADM . "delete-order-payments/order-payment/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>

                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php
            echo $this->Dados['paginacao'];
            ?>
        </div>
    </div>
</div>