<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
//var_dump($_SESSION['terms']);
//var_dump($this->Dados['select']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 mb-4 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Pesquisar Ordens de Pagamentos</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['create_sheet']) {
                        echo "<a href='" . URLADM . "create-spreadsheet-order-payments/create" . $_SESSION['terms'] . "' class='btn btn-success btn-sm'><i class='fas fa-table'></i> Gerar Excel</a> ";
                    }
                    if ($this->Dados['botao']['list_payment']) {
                        echo "<a href='" . URLADM . "order-payments/list' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i></a> ";
                    }
                    if ($this->Dados['botao']['add_payment']) {
                        echo "<a href='" . URLADM . "add-order-payments/order-payment' class='btn btn-outline-success btn-sm'><i class='fa-solid fa-square-plus'></i> Novo</a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                        <?php
                        if ($this->Dados['botao']['list_payment']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "order-payments/list'>Listar</a>";
                        }
                        if ($this->Dados['botao']['add_payment']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "add-order-payments/order-payment'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <form class="form" method="POST" action="<?php echo URLADM . 'search-order-payments/list'; ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 col-lg-12 mb-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
                        </div>
                        <input name="search" type="text" id="search" class="form-control" aria-describedby="search" placeholder="Pesquise por cliente, loja, situação ou ID" value="<?php
                        if ((isset($_SESSION['search'])) AND (!empty($_SESSION['search']))) {
                            echo $_SESSION['search'];
                        }
                        ?>">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col col-sm-6 col-md-6 col-lg-3 mb-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="searchDateInitial">Inicio</label>
                        </div>
                        <input name="searchDateInitial" type="date" id="searchDateInitial" class="form-control" aria-describedby="searchDateInitial" value="<?php
                        if (isset($_SESSION['searchDateInitial'])) {
                            echo $_SESSION['searchDateInitial'];
                        }
                        ?>">
                    </div>
                </div>
                <div class="col col-sm-6 col-md-6 col-lg-3 mb-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="searchDateFinal">Fim</label>
                        </div>
                        <input name="searchDateFinal" type="date" id="searchDateFinal" class="form-control" aria-describedby="searchDateFinal" value="<?php
                        if (isset($_SESSION['searchDateFinal'])) {
                            echo $_SESSION['searchDateFinal'];
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
        if ((empty($this->Dados['list_backlog'])) AND (empty($this->Dados['list_doing'])) AND (empty($this->Dados['list_waiting'])) AND (empty($this->Dados['list_done']))) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhuma ordem de pagamento encontrada!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
            $redirectUrl = URLADM . 'order-payments/list';
            if ((empty($this->Dados['list_backlog'])) AND (empty($this->Dados['list_doing'])) AND (empty($this->Dados['list_waiting'])) AND (empty($this->Dados['list_done']))) {
                header("Location: $redirectUrl");
                exit();
            }
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
                        <th class="d-none d-sm-table-cell text-center">Pagos</th>
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
                                            <div class="d-flex align-content-between justify-content-between" style='font-size: 16px;'>
                                                <span>ID: <?php echo $bk_id; ?> <?php echo $payment_prepared_bk == 1 ? '<i class="fa-regular fa-square-check"></i>' : ''; ?></span>
                                                <span>
                                                    <?php echo ($adv_bk == 1 ? "<i class='fa-solid fa-bookmark text-warning' title='Adiantamento'></i>" : ''); ?>
                                                    <?php echo ((!empty($installments_bk) and $installments_bk > 1) ? "<i class='fa-solid fa-calendar-days text-info' title='Boleto Parcelado'></i>" : ''); ?>
                                                    <?php echo ($proof_bk == 1 ? "<i class='fa-solid fa-file-invoice text-dark' title='Comprovante'></i>" : ''); ?>
                                                </span>
                                            </div>
                                        </h5>
                                        <div class="card-body">
                                            <h5 class="card-title" style='font-size: 15px;'><?php echo "Área: " . $area_bk; ?></h5>
                                            <ul class="list-unstyled" style='font-size: 12px;'>
                                                <li class="card-text"><?php echo "<strong>Cadastro:</strong> " . date('d/m/Y', strtotime($created_date_bk)); ?></li>
                                                <li><?php echo "<strong>Pagar:</strong> " . date('d/m/Y', strtotime($date_payment_bk)); ?></li>
                                                <li class="card-text"><?php echo "<strong>Fornecedor:</strong> " . $fornecedor_bk; ?></li>
                                                <li class="card-text"><?php echo ($advance_amount_bk > 0 && date("Y-m-d", strtotime($date_payment_bk)) >= date('Y-m-d') ? "<strong>Adiantamento: </strong> R$ " : "<strong>Valor: </strong> R$ ") . ($advance_amount_bk > 0 && date("Y-m-d", strtotime($date_payment_bk)) >= date('Y-m-d') ? number_format($advance_amount_bk, 2, ',', '.') : number_format($diff_payment_advance_bk, 2, ',', '.')); ?></li>
                                            </ul>
                                            <div class="text-right">
                                                <span class="d-none d-md-block">
                                                    <?php
                                                    if ($this->Dados['botao']['view_payment']) {
                                                        echo "<a href='" . URLADM . "view-order-payments/order-payment/$bk_id' class='btn btn-dark btn-sm'><i class='fas fa-eye'></i></a> ";
                                                    }
                                                    if ($this->Dados['botao']['edit_payment']) {
                                                        echo "<a href='" . URLADM . "edit-order-payments/order-payment/$bk_id' class='btn btn-dark btn-sm'><i class='fas fa-pen-fancy'></i></a> ";
                                                    }
                                                    if ($this->Dados['botao']['del_payment']) {
                                                        echo "<a href='" . URLADM . "delete-order-payments/order-payment/$bk_id' class='btn btn-dark btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a> ";
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
                                                            echo "<a class='dropdown-item' href='" . URLADM . "view-order-payments/order-payment/$bk_id'>Visualizar</a>";
                                                        }
                                                        if ($this->Dados['botao']['edit_payment']) {
                                                            echo "<a class='dropdown-item' href='" . URLADM . "edit-order-payments/order-payment/$bk_id'>Editar</a>";
                                                        }
                                                        if ($this->Dados['botao']['del_payment']) {
                                                            echo "<a class='dropdown-item' href='" . URLADM . "delete-order-payments/order-orderpayment/$bk_id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
                                            <div class="d-flex align-content-between justify-content-between" style='font-size: 16px;'>
                                                <span>ID: <?php echo $do_id; ?> <?php echo $payment_prepared_do == 1 ? '<i class="fa-regular fa-square-check"></i>' : ''; ?></span>
                                                <span>
                                                    <?php echo ($adv_do == 1 ? "<i class='fa-solid fa-bookmark text-warning' title='Adiantamento'></i>" : ''); ?>
                                                    <?php echo ((!empty($installments_do) and $installments_do > 1) ? "<i class='fa-solid fa-calendar-days text-info' title='Boleto Parcelado'></i>" : ''); ?>
                                                    <?php echo ($proof_do == 1 ? "<i class='fa-solid fa-file-invoice text-white' title='Comprovante'></i>" : ''); ?>
                                                </span>
                                            </div>
                                        </h5>
                                        <div class="card-body">
                                            <h5 class="card-title" style='font-size: 15px;'><?php echo "Área: " . $area_do; ?></h5>
                                            <ul class="list-unstyled" style='font-size: 12px;'>
                                                <li class="card-text"><?php echo "<strong>Cadastro:</strong> " . date('d/m/Y', strtotime($created_date_do)); ?></li>
                                                <li><?php echo "<strong>Pagar:</strong> " . date('d/m/Y', strtotime($date_payment_do)); ?></li>
                                                <li class="card-text"><?php echo "<strong>Fornecedor:</strong> " . $fornecedor_do; ?></li>
                                                <li class="card-text"><?php echo ($advance_amount_do > 0 && date("Y-m-d", strtotime($date_payment_do)) >= date('Y-m-d') ? "<strong>Adiantamento: </strong> R$ " : "<strong>Valor: </strong> R$ ") . ($advance_amount_do > 0 && date("Y-m-d", strtotime($date_payment_do)) >= date('Y-m-d') ? number_format($advance_amount_do, 2, ',', '.') : number_format($diff_payment_advance_do, 2, ',', '.')); ?></li>
                                            </ul>
                                            <div class="text-right">
                                                <span class="d-none d-md-block">

                                                    <?php
                                                    if ($this->Dados['botao']['view_payment']) {
                                                        echo "<a href='" . URLADM . "view-order-payments/order-payment/$do_id' class='btn btn-dark btn-sm'><i class='fas fa-eye'></i></a> ";
                                                    }
                                                    if ($this->Dados['botao']['edit_payment']) {
                                                        echo "<a href='" . URLADM . "edit-order-payments/order-payment/$do_id' class='btn btn-dark btn-sm'><i class='fas fa-pen-fancy'></i></a> ";
                                                    }
                                                    if ($this->Dados['botao']['del_payment']) {
                                                        echo "<a href='" . URLADM . "delete-order-payments/order-payment/$do_id' class='btn btn-dark btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a> ";
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
                                                            echo "<a class='dropdown-item' href='" . URLADM . "view-order-payments/order-payment/$do_id'>Visualizar</a>";
                                                        }
                                                        if ($this->Dados['botao']['edit_payment']) {
                                                            echo "<a class='dropdown-item' href='" . URLADM . "edit-order-payments/order-payment/$do_id'>Editar</a>";
                                                        }
                                                        if ($this->Dados['botao']['del_payment']) {
                                                            echo "<a class='dropdown-item' href='" . URLADM . "delete-order-payment/order-payment/$do_id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
                                            <div class="d-flex align-content-between justify-content-between" style='font-size: 16px;'>
                                                <span>ID: <?php echo $wa_id; ?> <?php echo $payment_prepared_wa == 1 ? '<i class="fa-regular fa-square-check"></i>' : ''; ?></span>
                                                <span>
                                                    <?php echo ($adv_wa == 1 ? "<i class='fa-solid fa-bookmark text-warning' title='Adiantamento'></i>" : ''); ?>
                                                    <?php echo ((!empty($installments_wa) and $installments_wa > 1) ? "<i class='fa-solid fa-calendar-days text-danger' title='Boleto Parcelado'></i>" : ''); ?>
                                                    <?php echo ($proof_wa == 1 ? "<i class='fa-solid fa-file-invoice text-white' title='Comprovante'></i>" : ''); ?>
                                                </span>
                                            </div>
                                        </h5>
                                        <div class="card-body">
                                            <h5 class="card-title" style='font-size: 15px;'><?php echo "Área: " . $area_wa; ?></h5>
                                            <ul class="list-unstyled" style='font-size: 12px;'>
                                                <li class="card-text"><?php echo "<strong>Cadastro:</strong> " . date('d/m/Y', strtotime($created_date_wa)); ?></li>
                                                <li><?php echo "<strong>Pagar:</strong> " . date('d/m/Y', strtotime($date_payment_wa)); ?></li>
                                                <li class="card-text"><?php echo "<strong>Fornecedor:</strong> " . $fornecedor_wa; ?></li>
                                                <li class="card-text"><?php echo ($advance_amount_wa > 0 && date("Y-m-d", strtotime($date_payment_wa)) >= date('Y-m-d') ? "<strong>Adiantamento: </strong> R$ " : "<strong>Valor: </strong> R$ ") . ($advance_amount_wa > 0 && date("Y-m-d", strtotime($date_payment_wa)) >= date('Y-m-d') ? number_format($advance_amount_wa, 2, ',', '.') : number_format($diff_payment_advance_wa, 2, ',', '.')); ?></li>
                                            </ul>
                                            <div class="text-right">
                                                <span class="d-none d-md-block">

                                                    <?php
                                                    if ($this->Dados['botao']['view_payment']) {
                                                        echo "<a href='" . URLADM . "view-order-payments/order-payment/$wa_id' class='btn btn-dark btn-sm'><i class='fas fa-eye'></i></a> ";
                                                    }
                                                    if ($this->Dados['botao']['edit_payment']) {
                                                        echo "<a href='" . URLADM . "edit-order-payments/order-payment/$wa_id' class='btn btn-dark btn-sm'><i class='fas fa-pen-fancy'></i></a> ";
                                                    }
                                                    if ($this->Dados['botao']['del_payment']) {
                                                        echo "<a href='" . URLADM . "delete-order-payments/order-payment/$wa_id' class='btn btn-dark btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a> ";
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
                                                            echo "<a class='dropdown-item' href='" . URLADM . "view-order-payments/order-payment/$wa_id'>Visualizar</a>";
                                                        }
                                                        if ($this->Dados['botao']['edit_payment']) {
                                                            echo "<a class='dropdown-item' href='" . URLADM . "edit-order-payments/order-payment/$wa_id'>Editar</a>";
                                                        }
                                                        if ($this->Dados['botao']['del_payment']) {
                                                            echo "<a class='dropdown-item' href='" . URLADM . "delete-order-payments/order-payment/$wa_id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
                                            <div class="d-flex align-content-between justify-content-between" style='font-size: 16px;'>
                                                <span>ID: <?php echo $don_id; ?> <?php echo $payment_prepared_don == 1 ? '<i class="fa-regular fa-square-check"></i>' : ''; ?></span>
                                                <span>
                                                    <?php echo ($adv_don == 1 ? "<i class='fa-solid fa-bookmark text-warning' title='Adiantamento'></i>" : ''); ?>
                                                    <?php echo ((!empty($installments_don) and $installments_don > 1) ? "<i class='fa-solid fa-calendar-days text-danger' title='Boleto Parcelado'></i>" : ''); ?>
                                                    <?php echo ($proof_don == 1 ? "<i class='fa-solid fa-file-invoice text-white' title='Comprovante'></i>" : ''); ?>
                                                </span>
                                            </div>
                                        </h5>
                                        <div class="card-body">
                                            <h5 class="card-title" style='font-size: 15px;'><?php echo "Área: " . $area_don; ?></h5>
                                            <ul class="list-unstyled" style='font-size: 12px;'>
                                                <li class="card-text"><?php echo "<strong>Cadastro:</strong> " . date('d/m/Y', strtotime($created_date_don)); ?></li>
                                                <li><?php echo "<strong>Pagar:</strong> " . date('d/m/Y', strtotime($date_payment_don)); ?></li>
                                                <li class="card-text"><?php echo "<strong>Fornecedor:</strong> " . $fornecedor_don; ?></li>
                                                <li class="card-text"><?php echo ($advance_amount_don > 0 && date("Y-m-d", strtotime($date_payment_don)) >= date('Y-m-d') ? "<strong>Adiantamento: </strong> R$ " : "<strong>Valor: </strong> R$ ") . ($advance_amount_don > 0 && date("Y-m-d", strtotime($date_payment_don)) >= date('Y-m-d') ? number_format($advance_amount_don, 2, ',', '.') : number_format($diff_payment_advance_don, 2, ',', '.')); ?></li>
                                            </ul>
                                            <div class="text-right">
                                                <span class="d-none d-md-block">

                                                    <?php
                                                    if ($this->Dados['botao']['view_payment']) {
                                                        echo "<a href='" . URLADM . "view-order-payments/order-payment/$don_id' class='btn btn-dark btn-sm'><i class='fas fa-eye'></i></a> ";
                                                    }
                                                    if ($this->Dados['botao']['edit_payment']) {
                                                        echo "<a href='" . URLADM . "edit-order-payments/order-payment/$don_id' class='btn btn-dark btn-sm'><i class='fas fa-pen-fancy'></i></a> ";
                                                    }
                                                    if ($this->Dados['botao']['del_payment']) {
                                                        echo "<a href='" . URLADM . "delete-order-payments/order-payment/$don_id' class='btn btn-dark btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a> ";
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
                                                            echo "<a class='dropdown-item' href='" . URLADM . "view-order-payments/order-payment/$don_id'>Visualizar</a>";
                                                        }
                                                        if ($this->Dados['botao']['edit_payment']) {
                                                            echo "<a class='dropdown-item' href='" . URLADM . "edit-order-payments/order-payment/$don_id'>Editar</a>";
                                                        }
                                                        if ($this->Dados['botao']['del_payment']) {
                                                            echo "<a class='dropdown-item' href='" . URLADM . "delete-order-payments/order-payment/$don_id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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