<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_order'][0])) {
    extract($this->Dados['dados_order'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Ordem de Pagamento - <strong>ID:</strong> <?php echo $id; ?></h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_order']) {
                            echo "<a href='" . URLADM . "order-payments/list' class='btn btn-outline-info btn-sm m-1' title='Listar'><i class='fas fa-list'></i></a>";
                        }
                        if ($this->Dados['botao']['edit_order']) {
                            echo "<a href='" . URLADM . "edit-order-payments/order-payment/$id' class='btn btn-outline-warning btn-sm m-1' title='Editar'><i class='fa-solid fa-pen-to-square'></i></a>";
                        }
                        if ($this->Dados['botao']['del_order']) {
                            echo "<a href='" . URLADM . "delete-order-payments/order-payment/$id' class='btn btn-outline-danger btn-sm m-1' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_order']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "order-payments/list'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_order']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-order-payments/order-payment/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_order']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "delete-order-payments/order-payment/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
            <div class="content p1">
                <div class="row">
                    <div class="col-md-4 order-md-2 mb-4">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Dados do Pagamento</span>
                        </h4>
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-condensed</table>">
                                <div class="my-2">
                                    <h6 class="my-2">Pagamento Preparado?</h6>
                                    <small class="lead"><?php echo $payment_prepared == 1 ? "Sim" : "Não"; ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-2">Data de Pagamento:</h6>
                                    <small class="text-muted lead"><?php echo date("d/m/Y", strtotime($date_payment)); ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condenced">
                                <div class="my-2">
                                    <h6 class="my-2">Adiantamento:</h6>
                                    <small class="lead"><?php echo $advance == 1 ? "Sim" : "Não"; ?></small>
                                </div>
                                <div class="my-2">
                                    <h6 class="my-2">Adiantamento Pago?</h6>
                                    <small class="lead"><?php echo $advance_amount_sit == 1 ? "Sim" : "Não"; ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div class="my-2">
                                    <h6 class="my-2">Valor - Adiantamento:</h6>
                                    <small class="text-muted lead"><?php echo!empty($advance_amount) ? "R$ " . number_format($advance_amount, 2, ',', '.') : "R$ 0,00"; ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div class="my-2">
                                    <h6 class="my-2">Valor Total:</h6>
                                    <small class="text-muted lead" ><?php echo "R$ " . number_format($total_value, 2, ',', '.'); ?></small>
                                </div>
                                <div class="my-2">
                                    <h6 class="my-2">Ordem de Pagamento - Pago?</h6>
                                    <small class="lead"><?php echo ($diff_payment_advance_sit == 1 && $advance_amount_sit == 1) || ($adms_sits_order_pay_id == 4 || $diff_payment_advance_sit == 1) ? "Sim" : "Não"; ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div class="my-2">
                                    <h6 class="my-2">Diferença:</h6>
                                    <small class="text-muted lead"><?php echo (!empty($diff_payment_advance) ? "R$ " . number_format($diff_payment_advance, 2, ',', '.') : "R$ 0,00"); ?></small>
                                </div>
                                <div class="my-2">
                                    <h6 class="my-2">Diferença - Pago?</h6>
                                    <small class="lead"><?php echo $diff_payment_advance_sit == 1 ? "Sim" : "Não"; ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-2">Nota Fiscal:</h6>
                                    <small class="text-muted lead" ><?php echo $number_nf; ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-2">Lançamento Fiscal:</h6>
                                    <small class="text-muted lead" ><?php echo!empty($launch_number) ? $launch_number : ""; ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-2">Cadastrado Por:</h6>
                                    <small class="text-muted lead" ><?php echo!empty($user_name_cad) ? $user_name_cad : ""; ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-2">Atualizado Por:</h6>
                                    <small class="text-muted lead" ><?php echo (!empty($user_name_up) ? $user_name_up : ""); ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-2">Situação:</h6>
                                    <small class="badge badge-info badge-pill lead"><?php echo $exibition_name; ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-2">Cadastrado</h6>
                                    <small class="lead"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></small>
                                    <small class="lead"><?php
                                        if (!empty($modified)) {
                                            echo '<h6 class="my-2">Atualizado</h6>';
                                            echo date('d/m/Y H:i:s', strtotime($modified));
                                        }
                                        ?>
                                    </small>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-8 order-md-1">
                        <h4 class="mb-3">Dados da Ordem de Pagamento</h4>
                        <form class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="adms_area_id">Área</label>
                                    <input type="text" class="form-control bg-white" id="adms_area_id" readonly value="<?php echo $area; ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="adms_cost_center_id">Centro de Custo</label>
                                    <input type="text" class="form-control bg-white" id="adms_cost_center_id" value="<?php echo $costCenter; ?>" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="manager_id">Gerência</label>
                                    <input type="text" class="form-control bg-white" id="manager_id" value="<?php echo $manager; ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="adms_brand_id">Marca</label>
                                    <input type="text" class="form-control bg-white" id="adms_brand_id" value="<?php echo $brand; ?>" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="adms_supplier_id">Fornecedor</label>
                                    <input type="text" class="form-control bg-white" id="adms_supplier_id" value="<?php echo $fantasy_name; ?>" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="description">Serviço/Produto</label>
                                    <input type="text" class="form-control bg-white" id="description" value="<?php echo $description; ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="adms_type_payment_id">Tipo de Pagamento</label>
                                    <input type="text" class="form-control bg-white" id="adms_type_payment_id" value="<?php echo $typePayment; ?>" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="bank_name">Banco</label>
                                    <input type="text" class="form-control bg-white" id="bank_name" value="<?php echo $bank; ?>" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="agency">Agência</label>
                                    <input type="text" class="form-control bg-white" id="agency" value="<?php echo $agency; ?>" readonly>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="checking_account">Conta</label>
                                    <input type="text" class="form-control bg-white" id="checking_account" value="<?php echo $checking_account; ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="agency">Tipo de Conta</label>
                                    <input type="text" class="form-control bg-white" id="agency" value="<?php echo (!empty($type_account) ? ($type_account == 1 ? "Conta Corrente" : "Poupança") : ""); ?>" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="document_number_supplier">CPF</label>
                                    <input type="text" class="form-control bg-white" id="document_number_supplier" value="<?php echo $document_number_supplier; ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name_supplier">Títular</label>
                                    <input type="text" class="form-control bg-white" id="name_supplier" value="<?php echo $name_supplier; ?>" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-control text-center"><strong>Pagamento via PIX</strong></div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="adms_type_key_pix_id">Tipo de Chave:</label>
                                    <input type="text" class="form-control bg-white" id="adms_type_key_pix_id" value="<?php echo $type_key; ?>" readonly>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label for="key_pix">Chave:</label>
                                    <input type="text" class="form-control bg-white" id="key_pix" value="<?php echo $key_pix; ?>" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0"><p>Observações:</p></h6>
                                            <small class="text-muted lead"><?php echo $obs; ?></small>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <?php
                            if (!empty($this->Dados['installments'])) {
                                ?>
                                <div class="mb-3">
                                    <ul class="list-group">
                                        <li class="list-group-item justify-content-between lh-condensed">
                                            <h6 class="my-0"><p>Boletos:</p></h6>
                                            <div class="row">
                                                <?php
                                                $install = $this->Dados['installments'];
                                                foreach ($install as $key => $inst) {
                                                    extract($inst);
                                                    ?>
                                                    <div class="col border rounded shadow col-auto col-md-3 m-1">
                                                        <h6 class="my-0 border-bottom"><p class="bold mt-1 mb-0"><?php echo $key + 1; ?>ª - Parcela</p></h6>
                                                        <p class="text-muted mt-1"><?php echo "<strong>Data</strong>: " . date('d/m/Y', strtotime($date_payment)); ?></p>
                                                        <p class="text-muted mt-0"><?php echo "<strong>R$</strong> " . number_format($installment_value, 2, ',', '.'); ?></p>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            <?php } ?>
                            <div class="mb-3">
                                <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0"><p>Arquivos:</p></h6>
                                            <small class="text-muted">
                                                <?php
                                                $types = array('png', 'jpg', 'jpeg', 'doc', 'pdf', 'docx', 'xlsx', 'rar', 'xls');
                                                $path = 'assets/files/orderPayments/' . $id . '/';
                                                $dir = new DirectoryIterator($path);
                                                foreach ($dir as $fileInfo) {
                                                    $ext = strtolower($fileInfo->getExtension());
                                                    if (in_array($ext, $types)) {
                                                        $arquivo = $fileInfo->getFilename();
                                                        echo "<span class='m-auto lead'>";
                                                        echo $arquivo . " - <a href='" . URLADM . "assets/files/orderPayments/$id/$arquivo' class='btn btn-dark btn-sm' download><i class='fas fa-download'></i> Baixar</a><br>";
                                                        echo "</span>";
                                                    }
                                                }
                                                ?>
                                            </small>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Nenhuma solicitação encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    $UrlDestino = URLADM . 'order-payments/list';
    header("Location: $UrlDestino");
}    