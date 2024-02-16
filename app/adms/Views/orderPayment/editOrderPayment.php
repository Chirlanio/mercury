<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($valorForm);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Ordem de Pagamento - <strong>ID: </strong><?php echo $valorForm['id']; ?></h2>
            </div>

            <div class="p-2 d-print-none">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['list_order']) {
                        echo "<a href='" . URLADM . "order-payments/list' class='btn btn-outline-info btn-sm ml-2'><i class='fas fa-list'></i></a> ";
                    }
                    if ($this->Dados['botao']['view_order']) {
                        echo "<a href='" . URLADM . "view-order-payments/order-payment/" . $valorForm['id'] . "' class='btn btn-outline-primary btn-sm'><i class='fas fa-eye'></i></a> ";
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
                    <label for="adms_area_id"><span class="text-danger">*</span> Área</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="adms_area_id" id="adms_area_id" class="form-control is-invalid">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['area'] as $a) {
                            extract($a);
                            if (isset($valorForm['adms_area_id']) and $valorForm['adms_area_id'] == $a_id) {
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
                            if (isset($valorForm['adms_area_id']) and $valorForm['adms_area_id'] == $a_id) {
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
                    <label for="adms_cost_center_id"><span class="text-danger">*</span> Centro de Custo</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="adms_cost_center_id" id="adms_cost_center_id" class="form-control is-invalid">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['costCenter'] as $cc) {
                            extract($cc);
                            if (isset($valorForm['adms_cost_center_id']) and $valorForm['adms_cost_center_id'] == $cc_id) {
                                echo "<option value='$cc_id' selected>$costCenter - $cost_center_id</option>";
                            } else {
                                echo "<option value='$cc_id'>$costCenter - $cost_center_id</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        echo '<select name="adms_cost_center_id" id="adms_cost_center_id" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['costCenter'] as $cc) {
                            extract($cc);
                            if (isset($valorForm['adms_cost_center_id']) and $valorForm['adms_cost_center_id'] == $cc_id) {
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
                    <label for="adms_brand_id"><span class="text-danger">*</span> Marca</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="adms_brand_id" id="adms_brand_id" class="form-control is-invalid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['brand'] as $bn) {
                            extract($bn);
                            if (isset($valorForm['adms_brand_id'] ) and $valorForm['adms_brand_id'] == $b_id) {
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
                            if (isset($valorForm['adms_brand_id'] ) and $valorForm['adms_brand_id'] == $b_id) {
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
                    <label for="date_payment"><span class="text-danger">*</span> Data Pagamento</label>
                    <?php
                    if (isset($valorForm['date_payment'])) {
                        $data = substr($valorForm['date_payment'], 0, 10);
                    }
                    ?>
                    <input name='date_payment' type='date' id='date_payment' class='form-control is-invalid' value='<?= $data; ?>' required>
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="manager_id"><span class="text-danger">*</span> Aprovador</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="manager_id" id="manager_id" class="form-control is-invalid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['manager'] as $man) {
                            extract($man);
                            if (isset($valorForm['manager_id']) and $valorForm['manager_id'] == $ma_id) {
                                echo "<option value='$ma_id' selected>$manager</option>";
                            } else {
                                echo "<option value='$ma_id'>$manager</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        echo '<select name="manager_id" id="manager_id" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['manager'] as $man) {
                            extract($man);
                            if (isset($valorForm['manager_id']) and $valorForm['manager_id'] == $ma_id) {
                                echo "<option value='$ma_id' selected>$manager</option>";
                            } else {
                                echo "<option value='$ma_id'>$manager</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-md-3">
                    <label for="number_nf"> Nota fiscal</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<input name="number_nf" id="number_nf" type="number" class="form-control is-valid" value="';
                        if (isset($valorForm['number_nf']) and !empty($valorForm['number_nf'])) {
                            echo $valorForm['number_nf'];
                        }
                        echo '">';
                    } else {
                        echo '<input name="number_nf" id="number_nf" type="number" class="form-control is-valid" aria-label="Disabled input" value ="';
                        if (isset($valorForm['number_nf']) and !empty($valorForm['number_nf'])) {
                            echo $valorForm['number_nf'];
                        }
                        echo '" disabled>';
                    }
                    ?>
                </div>

                <div class="form-group col-md-6">
                    <label for="adms_supplier_id"><span class="text-danger">*</span> Fornecedor</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="adms_supplier_id" id="adms_supplier_id" class="form-control is-invalid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['supp'] as $sp) {
                            extract($sp);
                            if ((isset($valorForm['adms_supplier_id'])) and ($valorForm['adms_supplier_id'] == $s_id)) {
                                echo "<option value='$s_id' selected>$supplier - $cnpj_cpf</option>";
                            } else {
                                echo "<option value='$s_id'>$supplier - $cnpj_cpf</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        echo '<select name="adms_supplier_id" id="adms_supplier_id" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['supp'] as $sp) {
                            extract($sp);
                            if ((isset($valorForm['adms_supplier_id'])) and ($valorForm['adms_supplier_id'] == $s_id)) {
                                echo "<option value='$s_id' selected>$supplier - $cnpj_cpf</option>";
                            } else {
                                echo "<option value='$s_id'>$supplier - $cnpj_cpf</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
                </div>

                <div class="form-group col-md-3">
                    <label for="money"><span class="text-danger">*</span> Valor Total</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<input name="total_value" id="money" type="text" class="form-control is-invalid" value="';
                        if (isset($valorForm['total_value']) and !empty($valorForm['total_value'])) {
                            echo $valorForm['total_value'];
                        }
                    } else {
                        echo '<input name="total_value" id="money" type="text" class="form-control is-valid" aria-label="Disabled input" value ="';
                        if (isset($valorForm['total_value']) and !empty($valorForm['total_value'])) {
                            echo $valorForm['total_value'];
                        }
                    }
                    echo '" required readonly>';
                    ?>
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-md-12">
                    <label for="description"><span class="text-danger">*</span> Descrição</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<input name="description" id="description" type="text" class="form-control is-invalid" value="';
                        if (isset($valorForm['description']) and (!empty($valorForm['description']))) {
                            echo $valorForm['description'];
                        }
                    } else {
                        echo '<input name="description" id="description" type="text" class="form-control is-valid" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['description']) and (!empty($valorForm['description']))) {
                            echo $valorForm['description'];
                        }
                    }
                    echo '" required>';
                    ?>
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="adms_type_payment_id"><span class="text-danger">*</span> Forma de Pagamento</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="adms_type_payment_id" id="adms_type_payment_id" class="form-control is-valid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['typePayment'] as $type) {
                            extract($type);
                            if (isset($valorForm['adms_type_payment_id']) and $valorForm['adms_type_payment_id'] == $t_id) {
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
                            if (isset($valorForm['adms_type_payment_id']) and $valorForm['adms_type_payment_id'] == $t_id) {
                                echo "<option value='$t_id' selected>$typePayment</option>";
                            } else {
                                echo "<option value='$t_id'>$typePayment</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
                </div>

                <div class="form-group col-md-2">
                    <label for="advance"><span class="text-danger">*</span> Adiantamento</label>                    
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
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

                <div class="form-group col-md-2">
                    <label for="valor_lancado"> Valor - Adiantamento</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<input name="advance_amount" id="valor_lancado" type="text" class="form-control is-valid" value="';
                        if (isset($valorForm['advance_amount']) and !empty($valorForm['advance_amount'])) {
                            echo $valorForm['advance_amount'];
                        }
                        echo '">';
                    } else {
                        echo '<input name="advance_amount" id="valor_lancado" type="text" class="form-control is-valid" aria-label="Disabled input" value ="';
                        if (isset($valorForm['advance_amount']) and !empty($valorForm['advance_amount'])) {
                            echo $valorForm['advance_amount'];
                        }
                        echo '" disabled>';
                    }
                    ?>
                </div>


                <div class="form-group col-md-2">

                    <?php
                    if ($valorForm['advance_amount_sit'] == 2 || $valorForm['advance_amount_sit'] == null) {
                        echo "<label for='advance_amount_sit'><span class='text-danger'>*</span> Adiantamento Pago?</label>";
                        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                            echo '<select name="advance_amount_sit" id="advance_amount_sit" class="form-control is-valid" required>';
                            if ($valorForm['advance_amount_sit'] == 1) {
                                echo "<option value=''>Selecione</option>";
                                echo "<option value='1' selected>Sim</option>";
                                echo "<option value='2'>Não</option>";
                            } elseif ($valorForm['advance_amount_sit'] == 2) {
                                echo "<option value=''>Selecione</option>";
                                echo "<option value='1'>Sim</option>";
                                echo "<option value='2' selected>Não</option>";
                            } else {
                                echo "<option value='' selected>Selecione</option>";
                                echo "<option value='1'>Sim</option>";
                                echo "<option value='2'>Não</option>";
                            }
                            echo '</select>';
                        } else {
                            echo '<select name="advance_amount_sit" id="advance_amount_sit" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                            if ($valorForm['advance_amount_sit'] == 1) {
                                echo "<option value=''>Selecione</option>";
                                echo "<option value='1' selected>Sim</option>";
                                echo "<option value='2'>Não</option>";
                            } elseif ($valorForm['advance_amount_sit'] == 2) {
                                echo "<option value=''>Selecione</option>";
                                echo "<option value='1'>Sim</option>";
                                echo "<option value='2' selected>Não</option>";
                            } else {
                                echo "<option value='' selected>Selecione</option>";
                                echo "<option value='1'>Sim</option>";
                                echo "<option value='2'>Não</option>";
                            }
                            echo '</select>';
                        }
                    } else {
                        echo "<label for='diff_payment_advance_sit'><span class='text-danger'>*</span> Diferença - Pago?</label>";
                        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                            echo '<select name="diff_payment_advance_sit" id="diff_payment_advance_sit" class="form-control is-invalid" required>';
                            if (isset($valorForm['diff_payment_advance_sit']) and $valorForm['diff_payment_advance_sit'] == 1) {
                                echo "<option value=''>Selecione</option>";
                                echo "<option value='1' selected>Sim</option>";
                                echo "<option value='2'>Não</option>";
                            } elseif (isset($valorForm['diff_payment_advance_sit']) and $valorForm['diff_payment_advance_sit'] == 2) {
                                echo "<option value=''>Selecione</option>";
                                echo "<option value='1'>Sim</option>";
                                echo "<option value='2' selected>Não</option>";
                            } else {
                                echo "<option value='' selected>Selecione</option>";
                                echo "<option value='1'>Sim</option>";
                                echo "<option value='2'>Não</option>";
                            }
                            echo '</select>';
                        } else {
                            echo '<select name="diff_payment_advance_sit" id="diff_payment_advance_sit" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                            if (isset($valorForm['diff_payment_advance_sit']) and $valorForm['diff_payment_advance_sit'] == 1) {
                                echo "<option value=''>Selecione</option>";
                                echo "<option value='1' selected>Sim</option>";
                                echo "<option value='2'>Não</option>";
                            } elseif (isset($valorForm['diff_payment_advance_sit']) and $valorForm['diff_payment_advance_sit'] == 2) {
                                echo "<option value=''>Selecione</option>";
                                echo "<option value='1'>Sim</option>";
                                echo "<option value='2' selected>Não</option>";
                            } else {
                                echo "<option value='' selected>Selecione</option>";
                                echo "<option value='1'>Sim</option>";
                                echo "<option value='2'>Não</option>";
                            }
                            echo '</select>';
                        }
                    }
                    ?>
                </div>

                <div class="form-group col-md-2">
                    <label for="proof"><span class="text-danger">*</span> Comprovante?</label>                    
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="proof" id="proof" class="form-control is-valid" required>';
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
                        echo '<select name="proof" id="proof" class="form-control is-valid" aria-label="Disabled input" required disabled>';
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

                <div class="form-group col-md-2">
                    <label for="launch_number"> Lançamento Fiscal</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<input name="launch_number" id="launch_number" type="number" class="form-control is-valid" value="';
                        if (isset($valorForm['launch_number']) and !empty($valorForm['launch_number'])) {
                            echo $valorForm['launch_number'];
                        }
                        echo '">';
                    } else {
                        echo '<input name="launch_number" id="launch_number" type="number" class="form-control is-valid" aria-label="Disabled input" value ="';
                        if (isset($valorForm['launch_number']) and !empty($valorForm['launch_number'])) {
                            echo $valorForm['launch_number'];
                        }
                        echo '" disabled>';
                    }
                    ?>
                </div>

            </div>

            <div class="form-row" id="parc">
                <?php
                if (!empty($this->Dados['select']['install'])) {
                    echo "<div class='form-group col-md-3'><label for='installments'> Parcelas</label><input name='installments' id='installments' type='number' min='0' max='10' class='form-control' value='" . $this->Dados['select']['install'][0]['qtdInstallments'] . "'></div>";
                    $keyNum = 1;
                    foreach ($this->Dados['select']['install'] as $key => $value) {
                        extract($value);
                        echo "<div class='form-group col-md-3 input-dinamico'><input name='i_id[]' id='$i_id' type='hidden' value='" . $i_id . "'><label for='text'>Valor - Parcela</label><input name='installment_values[]' type='text' id='text$keyNum' class='form-control' value='" . str_replace('.', ',', $installment_values) . "'><input name='date_payments[]' type='date' id='dateInput' class='form-control' value='$date_payments'></div>";
                        $keyNum++;
                    }
                }
                ?>

            </div>

            <div class="form-row">

                <div class="form-group col-md-2">
                    <label for="bank_id">Banco</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="bank_id" id="bank_id" class="form-control is-valid">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['bank'] as $bank) {
                            extract($bank);
                            if (isset($valorForm['bank_id']) and $valorForm['bank_id'] == $bank_id) {
                                echo "<option value='$bank_id' selected>$bank_name</option>";
                            } else {
                                echo "<option value='$bank_id'>$bank_name</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        echo '<select name="bank_id" id="bank_id" class="form-control is-valid" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['bank'] as $bank) {
                            extract($bank);
                            if (isset($valorForm['bank_id']) and $valorForm['bank_id'] == $bank_id) {
                                echo "<option value='$bank_id' selected>$bank_name</option>";
                            } else {
                                echo "<option value='$bank_id'>$bank_name</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
                </div>

                <div class="form-group col-md-1">
                    <label for="agency">Agência</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<input name="agency" id="agency" type="number" class="form-control" value="';
                        if (isset($valorForm['agency']) and !empty($valorForm['agency'])) {
                            echo $valorForm['agency'];
                        }
                    } else {
                        echo '<input name="agency" id="agency" type="number" class="form-control" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['agency']) and !empty($valorForm['agency'])) {
                            echo $valorForm['agency'];
                        }
                    }
                    ?>">
                </div>

                <div class="form-group col-md-2">
                    <label for="checking_account">Conta</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<input name="checking_account" id="checking_account" type="number" class="form-control" value="';
                        if (isset($valorForm['checking_account']) and !empty($valorForm['checking_account'])) {
                            echo $valorForm['checking_account'];
                        }
                    } else {
                        echo '<input name="checking_account" id="checking_account" type="number" class="form-control" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['checking_account']) and !empty($valorForm['checking_account'])) {
                            echo $valorForm['checking_account'];
                        }
                    }
                    ?>">
                </div>

                <div class="form-group col-md-2">
                    <label for="type_account">Tipo de Conta</label>                    
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="type_account" id="type_account" class="form-control is-valid">';
                        if ($valorForm['type_account'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Conta Corrente</option>";
                            echo "<option value='2'>Poupança</option>";
                        } elseif ($valorForm['type_account'] == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Conta Corrente</option>";
                            echo "<option value='2' selected>Poupança</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Conta Corrente</option>";
                            echo "<option value='2'>Poupança</option>";
                        }
                    } else {
                        echo '<select name="type_account" id="type_account" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                        if ($valorForm['type_account'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Conta Corrente</option>";
                            echo "<option value='2'>Poupança</option>";
                        } elseif ($valorForm['type_account'] == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Conta Corrente</option>";
                            echo "<option value='2' selected>Poupança</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Conta Corrente</option>";
                            echo "<option value='2'>Poupança</option>";
                        }
                    }
                    echo '</select>';
                    ?>
                </div>

                <div class="form-group col-md-2">
                    <label for="document_number_supplier">CPF</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<input name="document_number_supplier" id="document_number_supplier" type="text" class="form-control is-valid" value="';
                        if (isset($valorForm['document_number_supplier']) and !empty($valorForm['document_number_supplier'])) {
                            echo $valorForm['document_number_supplier'];
                        }
                    } else {
                        echo '<input name="document_number_supplier" id="document_number_supplier" type="text" class="form-control" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['document_number_supplier']) and !empty($valorForm['document_number_supplier'])) {
                            echo $valorForm['document_number_supplier'];
                        }
                    }
                    echo '">';
                    ?>
                </div>

                <div class="form-group col-md-3">
                    <label for="name_supplier">Títular</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<input name="name_supplier" id="name_supplier" type="text" class="form-control is-valid" value="';
                        if (isset($valorForm['name_supplier']) and !empty($valorForm['name_supplier'])) {
                            echo $valorForm['name_supplier'];
                        }
                    } else {
                        echo '<input name="name_supplier" id="name_supplier" type="text" class="form-control" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['name_supplier']) and !empty($valorForm['name_supplier'])) {
                            echo $valorForm['name_supplier'];
                        }
                    }
                    echo '">';
                    ?>
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-12 text-center">
                    <div class="form-control">
                        <strong>Pagamento via PIX</strong>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="adms_type_key_pix_id"><span class="text-danger">*</span> Tipo de Chave</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="adms_type_key_pix_id" id="adms_type_key_pix_id" class="form-control is-valid">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['typeKey'] as $key) {
                            extract($key);
                            if (isset($valorForm['adms_type_key_pix_id']) and $valorForm['adms_type_key_pix_id'] == $tp_id) {
                                echo "<option value='$tp_id' selected>$typePix</option>";
                            } else {
                                echo "<option value='$tp_id'>$typePix</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        echo '<select name="adms_type_key_pix_id" id="adms_type_key_pix_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['typeKey'] as $key) {
                            extract($key);
                            if (isset($valorForm['adms_type_key_pix_id']) and $valorForm['adms_type_key_pix_id'] == $tp_id) {
                                echo "<option value='$tp_id' selected>$typePix</option>";
                            } else {
                                echo "<option value='$tp_id'>$typePix</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
                </div>

                <div class="form-group col-md-5">
                    <label for="key_pix">Chave PIX</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<input name="key_pix" id="key_pix" type="text" class="form-control is-valid" value="';
                        if (isset($valorForm['key_pix']) and !empty($valorForm['key_pix'])) {
                            echo $valorForm['key_pix'];
                        }
                    } else {
                        echo '<input name="key_pix" id="key_pix" type="text" class="form-control" aria-label="Disabled input" disabled value ="';
                        if (isset($valorForm['key_pix']) and !empty($valorForm['key_pix'])) {
                            echo $valorForm['key_pix'];
                        }
                    }
                    echo '">';
                    ?>
                </div>

                <div class="form-group col-md-2">
                    <label for="payment_prepared"><span class="text-danger">*</span> Preparado?</label>                    
                    <?php
                    if (($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) and $valorForm['payment_prepared'] == 2) {
                        echo '<select name="payment_prepared" id="payment_prepared" class="form-control is-valid" required >';
                        if ($valorForm['payment_prepared'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        } elseif ($valorForm['payment_prepared'] == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2' selected>Não</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        }
                    } else {
                        echo '<select name="payment_prepared" id="payment_prepared" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                        if ($valorForm['payment_prepared'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        } elseif ($valorForm['payment_prepared'] == 2) {
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
                    <label for="adms_sits_order_pay_id"><span class="text-danger">*</span> Situação</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="adms_sits_order_pay_id" id="adms_sits_order_pay_id" class="form-control is-valid">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sits'] as $st) {
                            extract($st);
                            if (isset($valorForm['adms_sits_order_pay_id']) and $valorForm['adms_sits_order_pay_id'] == $st_id) {
                                echo "<option value='$st_id' selected>$st_id - $sit</option>";
                            } else {
                                echo "<option value='$st_id'>$st_id - $sit</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        echo '<select name="adms_sits_order_pay_id" id="adms_sits_order_pay_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sits'] as $key) {
                            extract($key);
                            if (isset($valorForm['adms_sits_order_pay_id']) and $valorForm['adms_sits_order_pay_id'] == $st_id) {
                                echo "<option value='$st_id' selected>$st_id - $sit</option>";
                            } else {
                                echo "<option value='$st_id'>$st_id - $sit</option>";
                            }
                        }
                        echo '</select>';
                    }
                    ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="obs">Observações</label>
                    <textarea name="obs" id="obs" class="form-control editorCK is-invalid" rows="4">
                        <?php
                        if (isset($valorForm['obs']) and !empty($valorForm['obs'])) {
                            echo $valorForm['obs'];
                        }
                        ?>
                    </textarea>
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
                                        <?php
                                        $types = array('png', 'jpg', 'jpeg', 'doc', 'pdf', 'docx', 'xlsx', 'xls');
                                        $path = 'assets/files/orderPayments/' . $valorForm['id'] . '/';
                                        $dir = new DirectoryIterator($path);
                                        foreach ($dir as $fileInfo) {
                                            $ext = strtolower($fileInfo->getExtension());
                                            if (in_array($ext, $types)) {
                                                $arquivo = $fileInfo->getFilename();
                                                echo "<span class='m-auto lead'>";
                                                echo $arquivo . " - <a href='" . URLADM . "assets/files/orderPayments/" . $valorForm['id'] . "/$arquivo' class='btn btn-dark btn-sm mr-1' download><i class='fas fa-download'></i> Baixar</a>";
                                                echo "<a href='" . URLADM . "edit-order-payments/order-payment/" . $valorForm['id'] . "?id=" . $valorForm['id'] . "&file=$arquivo' class='btn btn-dark btn-sm'><i class='fa-solid fa-trash'></i></a><br>";
                                                echo "</span>";
                                            }
                                        }
                                        ?>
                                    </small>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <input name="file_name[]" type="hidden" value="<?php
                    if (isset($valorForm['file_name'])) {
                        echo $valorForm['file_name'];
                    } elseif (isset($valorForm['new_files'])) {
                        echo $valorForm['new_files'];
                    }
                    ?>" multiple>

                    <label for="new_files"><span class="text-danger">*</span> Novo Arquivo</label>
                    <input name="new_files[]" id="new_files" type="file" class="custom-file" multiple>
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditOrder" type="submit" class="btn btn-warning" value="Salvar">

        </form>
    </div>
</div>
