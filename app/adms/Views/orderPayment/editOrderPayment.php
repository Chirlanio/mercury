<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($_FILES());
//var_dump($this->Dados['form'][0]);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Ordem de Pagamento</h2>
            </div>

            <div class="p-2 d-print-none">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['list_order']) {
                        echo "<a href='" . URLADM . "order-payments/list' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i> Listar</a> ";
                    }
                    if ($this->Dados['botao']['view_order']) {
                        echo "<a href='" . URLADM . "view-order-payments/order-payment/" . $valorForm['id'] . "' class='btn btn-outline-primary btn-sm'><i class='fas fa-eye'></i> Visualizar</a> ";
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
                        if ($this->Dados['botao']['vis_estorno']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "order-payments/order-payment/" . $valorForm['id'] . "'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>
        <hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" enctype="multipart/form-data" class="was-validated"> 
            <input name="id" type="hidden" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Área</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="adms_area_id" id="adms_area_id" class="form-control is-invalid">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['area'] as $a) {
                            extract($a);
                            if ($valorForm['adms_area_id'] == $a_id) {
                                echo "<option value='$a_id' selected>$area</option>";
                            } else {
                                echo "<option value='$a_id'>$area</option>";
                            }
                        }
                        echo "</select>";
                    } else {
                        echo '<select name="adms_area_id" id="adms_area_id" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['area'] as $a) {
                            extract($a);
                            if ($valorForm['adms_area_id'] == $a_id) {
                                echo "<option value='$a_id' selected>$area</option>";
                            } else {
                                echo "<option value='$a_id'>$area</option>";
                            }
                        }
                        echo "</select>";
                    }
                    ?>

                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Centro de Custo</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="adms_cost_center_id" id="adms_cost_center_id" class="form-control is-invalid">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['costCenter'] as $cc) {
                            extract($cc);
                            if ($valorForm['adms_cost_center_id'] == $cc_id) {
                                echo "<option value='$cc_id' selected>$costCenter</option>";
                            } else {
                                echo "<option value='$cc_id'>$costCenter</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        echo '<select name="adms_cost_center_id" id="adms_cost_center_id" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['costCenter'] as $cc) {
                            extract($cc);
                            if ($valorForm['adms_cost_center_id'] == $cc_id) {
                                echo "<option value='$cc_id' selected>$costCenter</option>";
                            } else {
                                echo "<option value='$cc_id'>$costCenter</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Marca</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="adms_brand_id" id="adms_brand_id" class="form-control is-invalid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['brand'] as $bn) {
                            extract($bn);
                            if ($valorForm['adms_brand_id'] == $b_id) {
                                echo "<option value='$b_id' selected>$brand</option>";
                            } else {
                                echo "<option value='$b_id'>$brand</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        echo '<select name="adms_brand_id" id="adms_brand_id" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['brand'] as $bn) {
                            extract($bn);
                            if ($valorForm['adms_brand_id'] == $b_id) {
                                echo "<option value='$b_id' selected>$brand</option>";
                            } else {
                                echo "<option value='$b_id'>$brand</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Data Pagamento</label>
                    <?php
                    if (isset($valorForm['date_payment'])) {
                        $data = substr($valorForm['date_payment'], 0, 10);
                    }
                    ?>
                    <input name='date_payment' type='date' id='date_payment' class='form-control is-invalid' value='<?= $data; ?>' required>
                </div>

            </div>

            <div class="form-row">
                <label><span class="text-danger">*</span> Gerência</label>
                <?php
                if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                    echo '<select name="manager_id" id="manager_id" class="form-control is-invalid" required>';
                    echo '<option value="">Selecione</option>';
                    foreach ($this->Dados['select']['manager'] as $man) {
                        extract($man);
                        if ($valorForm['manager_id'] == $ma_id) {
                            echo "<option value='$ma_id' selected>$manager</option>";
                        } else {
                            echo "<option value='$ma_id'>$manager</option>";
                        }
                    }
                    echo '</select>';
                } else {
                    echo '<select name="manager_id" id="manager_id" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                    echo '<option value="">Selecione</option>';
                    foreach ($this->Dados['select']['brand'] as $man) {
                        extract($bn);
                        if ($valorForm['manager_id'] == $ma_id) {
                            echo "<option value='$ma_id' selected>$manager</option>";
                        } else {
                            echo "<option value='$ma_id'>$manager</option>";
                        }
                    }
                    echo '</select>';
                }
                ?>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Fornecedor</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="adms_supplier_id" id="adms_supplier_id" class="form-control is-invalid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['supp'] as $sp) {
                            extract($sp);
                            if ($valorForm['adms_supplier_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$supplier</option>";
                            } else {
                                echo "<option value='$s_id'>$supplier</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        echo '<select name="adms_supplier_id" id="adms_supplier_id" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['supp'] as $sp) {
                            extract($sp);
                            if ($valorForm['adms_supplier_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$supplier</option>";
                            } else {
                                echo "<option value='$s_id'>$supplier</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
                </div>

                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Descrição</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<input name="description" id="description" type="text" class="form-control is-invalid" value="';
                        if (isset($valorForm['description'])) {
                            echo $valorForm['description'];
                        }
                    } else {
                        echo '<input name="description" id="description" type="text" class="form-control is-valid" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['description'])) {
                            echo $valorForm['description'];
                        }
                    }
                    echo '" required>';
                    ?>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Valor Total</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<input name="total_value" id="money" type="text" class="form-control is-invalid" value="';
                        if (isset($valorForm['total_value'])) {
                            echo $valorForm['total_value'];
                        }
                    } else {
                        echo '<input name="total_value" id="total_value" type="text" class="form-control is-valid" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['total_value'])) {
                            echo $valorForm['total_value'];
                        }
                    }
                    echo '" required>';
                    ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Forma de Pagamento</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5 || $_SESSION['adms_niveis_acesso_id'] == 1) {
                        echo '<select name="adms_type_payment_id" id="adms_type_payment_id" class="form-control is-valid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['typePayment'] as $type) {
                            extract($type);
                            if ($valorForm['adms_type_payment_id'] == $t_id) {
                                echo "<option value='$t_id' selected>$typePayment</option>";
                            } else {
                                echo "<option value='$t_id'>$typePayment</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        echo '<select name="adms_type_payment_id" id="adms_type_payment_id" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['typePayment'] as $type) {
                            extract($type);
                            if ($valorForm['tb_forma_pag_id'] == $t_id) {
                                echo "<option value='$t_id' selected>$typePayment</option>";
                            } else {
                                echo "<option value='$t_id'>$typePayment</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Adiantamento</label>                    
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="advance" id="advance" class="form-control is-valid" required>';
                        if ($valorForm['advance'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        } elseif ($valorForm['advance'] == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2' selected>Não</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        }
                    } else {
                        echo '<select name="advance" id="advance" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                        if ($valorForm['advance'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        } elseif ($valorForm['advance'] == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2' selected>Não</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        }
                    }
                    echo '</select>';
                    ?>
                </div>

                <div class="form-group col-md-3">
                    <label> Valor - Adiantamento</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<input name="advance_amount" id="advance_amount" type="number" class="form-control is-valid" value="';
                        if (isset($valorForm['advance_amount']) && !empty($valorForm['advance_amount'])) {
                            echo $valorForm['advance_amount'];
                        }
                        echo '">';
                    } else {
                        echo '<input name="advance_amount" id="advance_amount" type="number" class="form-control is-valid" aria-label="Disabled input" value ="';
                        if (isset($valorForm['advance_amount']) && !empty($valorForm['advance_amount'])) {
                            echo $valorForm['advance_amount'];
                        }
                        echo '" disabled>';
                    }
                    ?>
                </div>

                <div class="form-group col-md-3">
                    <label> Nota fiscal</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<input name="number_nf" id="number_nf" type="number" class="form-control is-valid" value="';
                        if (isset($valorForm['number_nf']) && !empty($valorForm['number_nf'])) {
                            echo $valorForm['number_nf'];
                        }
                        echo '">';
                    } else {
                        echo '<input name="number_nf" id="number_nf" type="number" class="form-control is-valid" aria-label="Disabled input" value ="';
                        if (isset($valorForm['number_nf']) && !empty($valorForm['number_nf'])) {
                            echo $valorForm['number_nf'];
                        }
                        echo '" disabled>';
                    }
                    ?>
                </div>

            </div>

            <div class="form-row">

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Banco</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="bank_id" id="bank_id" class="form-control is-valid">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['bank'] as $bank) {
                            extract($bank);
                            if (isset($valorForm['bank_id']) == $ba_id) {
                                echo "<option value='$ba_id' selected>$bank_name</option>";
                            } else {
                                echo "<option value='$ba_id'>$bank_name</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        echo '<select name="bank_id" id="bank_id" class="form-control is-valid" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['bank'] as $bank) {
                            extract($bank);
                            if (isset($valorForm['bank_id']) == $ba_id) {
                                echo "<option value='$ba_id' selected>$bank_name</option>";
                            } else {
                                echo "<option value='$ba_id'>$bank_name</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
                </div>

                <div class="form-group col-md-2">
                    <label>Agência</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<input name="agency" id="agency" type="number" class="form-control" value="';
                        if (isset($valorForm['agency'])) {
                            echo $valorForm['agency'];
                        }
                    } else {
                        echo '<input name="agency" id="agency" type="number" class="form-control" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['agency'])) {
                            echo $valorForm['agency'];
                        }
                    }
                    ?>">
                </div>

                <div class="form-group col-md-2">
                    <label>Conta</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<input name="checking_account" id="checking_account" type="number" class="form-control" value="';
                        if (isset($valorForm['checking_account'])) {
                            echo $valorForm['checking_account'];
                        }
                    } else {
                        echo '<input name="checking_account" id="checking_account" type="number" class="form-control" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['checking_account'])) {
                            echo $valorForm['checking_account'];
                        }
                    }
                    ?>">
                </div>

                <div class="form-group col-md-5">
                    <label>Títular</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<input name="name_supplier" id="name_supplier" type="text" class="form-control is-invalid" value="';
                        if (isset($valorForm['name_supplier'])) {
                            echo $valorForm['name_supplier'];
                        }
                    } else {
                        echo '<input name="name_supplier" id="name_supplier" type="text" class="form-control" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['name_supplier'])) {
                            echo $valorForm['name_supplier'];
                        }
                    }
                    echo '" required>';
                    ?>
                </div>

            </div>

            <div class="form-row">
                <div class="form-control col-12 text-center">
                    <strong>Pagamento via PIX</strong>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Tipo de Chave</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="adms_type_key_pix_id" id="adms_type_key_pix_id" class="form-control is-valid">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['typeKey'] as $key) {
                            extract($key);
                            if ($valorForm['adms_type_key_pix_id'] == $tp_id) {
                                echo "<option value='$tp_id' selected>$typePix</option>";
                            } else {
                                echo "<option value='$tp_id'>$typePix</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        echo '<select name="adms_mot_est_id" id="adms_mot_est_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['typeKey'] as $key) {
                            extract($key);
                            if ($valorForm['adms_type_key_pix_id'] == $tp_id) {
                                echo "<option value='$tp_id' selected>$typePix</option>";
                            } else {
                                echo "<option value='$tp_id'>$typePix</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
                </div>
                
                <div class="form-group col-md-6">
                    <label>Títular</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<input name="key_pix" id="key_pix" type="text" class="form-control is-valid" value="';
                        if (isset($valorForm['key_pix'])) {
                            echo $valorForm['key_pix'];
                        }
                    } else {
                        echo '<input name="key_pix" id="key_pix" type="text" class="form-control" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['key_pix'])) {
                            echo $valorForm['key_pix'];
                        }
                    }
                    echo '">';
                    ?>
                </div>
                
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Situação</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="adms_sits_order_pay_id" id="adms_sits_order_pay_id" class="form-control is-valid">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sits'] as $st) {
                            extract($st);
                            if ($valorForm['adms_sits_order_pay_id'] == $st_id) {
                                echo "<option value='$st_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$st_id'>$sit</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        echo '<select name="adms_sits_order_pay_id" id="adms_sits_order_pay_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sits'] as $key) {
                            extract($key);
                            if ($valorForm['adms_sits_order_pay_id'] == $st_id) {
                                echo "<option value='$st_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$st_id'>$sit</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="mb-3">
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">Arquivos</h6>
                                    <small class="text-muted">
                                        <span class="m-auto lead">
                                            <?php
                                            if (isset($valorForm['file_name'])) {
                                                echo $valorForm['file_name'] . " - ";
                                            }
                                            ?>
                                        </span>
                                        <a href="<?php echo URLADM . 'assets/files/orderPayments/' . $valorForm['id'] . '/' . $valorForm['file_name']; ?>" class="lead m-auto" download>Baixar</a>
                                    </small>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <input name="file_name" type="hidden" value="<?php
                    if (isset($valorForm['file_name'])) {
                        echo $valorForm['file_name'];
                    } elseif (isset($valorForm['new_file'])) {
                        echo $valorForm['new_file'];
                    }
                    ?>">

                    <label><span class="text-danger">*</span> Novo Arquivo</label>
                    <input name="new_file" type="file" class="custom-file">
                </div>
            </div>
            
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditOrder" type="submit" class="btn btn-warning" value="Salvar">

        </form>
    </div>
</div>