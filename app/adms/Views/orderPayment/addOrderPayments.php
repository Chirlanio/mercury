<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($_FILES);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Ordem de Pagamtento</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_order']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'order-payments/list'; ?>" class="btn btn-outline-info btn-sm"><i class="fa-solid fa-list"></i></a>
                </div>
                <?php
            }
            ?>
        </div><hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" enctype="multipart/form-data" class="was-validated">

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="adms_area_id"><span class="text-danger">*</span> Área</label>
                    <select name="adms_area_id" id="adms_area_id" class="form-control is-invalid" required autofocus>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['area'] as $ar) {
                            extract($ar);
                            if ((isset($valorForm['adms_area_id'])) and ($valorForm['adms_area_id'] == $a_id)) {
                                echo "<option value='$a_id' selected>$area</option>";
                            } else {
                                echo "<option value='$a_id'>$area</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="adms_cost_center_id"><span class="text-danger">*</span> Centro de Custos</label>
                    <select name="adms_cost_center_id" id="adms_cost_center_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        if ($_SESSION['ordem_nivac'] <= ADMPERMITION) {
                            foreach ($this->Dados['select']['cost'] as $cc) {
                                extract($cc);
                                if (isset($valorForm['adms_cost_center_id']) and ($valorForm['adms_cost_center_id'] == $c_id)) {
                                    echo "<option value='$c_id' selected>$costCenter - $cost_center_id</option>";
                                } else {
                                    echo "<option value='$c_id'>$costCenter - $cost_center_id</option>";
                                }
                            }
                        } else {
                            foreach ($this->Dados['select']['cost'] as $cc) {
                                extract($cc);
                                if (isset($valorForm['adms_cost_center_id']) and ($valorForm['adms_cost_center_id'] == $c_id)) {
                                    echo "<option value='$c_id' selected>$costCenter</option>";
                                } else {
                                    echo "<option value='$c_id'>$costCenter</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="adms_brand_id"><span class="text-danger">*</span> Marca</label>
                    <select name="adms_brand_id" id="adms_brand_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['brand'] as $brand) {
                            extract($brand);
                            if (isset($valorForm['adms_brand_id']) and ($valorForm['adms_brand_id'] == $b_id)) {
                                echo "<option value='$b_id' selected>$brand</option>";
                            } else {
                                echo "<option value='$b_id'>$brand</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="date_payment"><span class="text-danger">*</span> Data de Pagamento</label>
                    <input name="date_payment" type="date" id="date_payment" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['date_payment'])) {
                        echo $valorForm['date_payment'];
                    }
                    ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="manager_id"><span class="text-danger">*</span> Aprovador</label>
                    <select name="manager_id" id="manager_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['manager'] as $m) {
                            extract($m);
                            if (isset($valorForm['manager_id']) and ($valorForm['manager_id'] == $m_id)) {
                                echo "<option value='$m_id' selected>$manager</option>";
                            } else {
                                echo "<option value='$m_id'>$manager</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-md-3">
                    <label for="number_nf"> Nota fiscal</label>
                    <input name="number_nf" id="number_nf" type="number" class="form-control" value="<?php
                    if (isset($valorForm['number_nf'])) {
                        echo $valorForm['number_nf'];
                    }
                    ?>">
                </div>

                <div class="form-group col-md-7">
                    <label for="adms_supplier_id"><span class="text-danger">*</span> Fornecedor</label>
                    <select name="adms_supplier_id" id="adms_supplier_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['supplier'] as $supplier) {
                            extract($supplier);
                            if (isset($valorForm['adms_supplier_id']) and ($valorForm['adms_supplier_id'] == $sup_id)) {
                                echo "<option value='$sup_id' selected>$fantasy_name - $cnpj_cpf</option>";
                            } else {
                                echo "<option value='$sup_id'>$fantasy_name - $cnpj_cpf</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="valor_correto"><span class="text-danger">*</span> Valor Total</label>
                    <input name="total_value" type="text" id="valor_correto" class="form-control is-invalid" required value="<?php
                    if (isset($valorForm['total_value'])) {
                        echo $valorForm['total_value'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="description"><span class="text-danger">*</span> Descrição</label>
                    <input name="description" id="description" type="text" class="form-control is-invalid" required value="<?php
                    if (isset($valorForm['description'])) {
                        echo $valorForm['description'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-md-2">
                    <label for="adms_type_payment_id"><span class="text-danger">*</span> Forma de Pagamento</label>
                    <select name="adms_type_payment_id" id="adms_type_payment_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['type_payment'] as $type) {
                            extract($type);
                            if (isset($valorForm['adms_type_payment_id']) and $valorForm['adms_type_payment_id'] == $t_id) {
                                echo "<option value='$t_id' selected>$type_payment</option>";
                            } else {
                                echo "<option value='$t_id'>$type_payment</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="advance"><span class="text-danger">*</span> Adiantamento</label>
                    <select name="advance" id="advance" class="form-control is-invalid" required>
                        <?php
                        if (isset($valorForm['advance']) and $valorForm['advance'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        } elseif (isset($valorForm['advance']) and $valorForm['advance'] == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2' selected>Não</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="money"> Valor - Adiantamento</label>
                    <input name="advance_amount" id="money" type="text" class="form-control" value="<?php
                    if (isset($valorForm['advance_amount'])) {
                        echo $valorForm['advance_amount'];
                    }
                    ?>">
                </div>

                <div class="form-group col-md-2">
                    <label for="advance_amount_sit"><span class="text-danger">*</span> Adiantamento Pago?</label>
                    <select name="advance_amount_sit" id="advance_amount_sit" class="form-control is-invalid" required>
                        <?php
                        if (isset($valorForm['advance_amount_sit']) and $valorForm['advance_amount_sit'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        } elseif (isset($valorForm['advance_amount_sit']) and $valorForm['advance_amount_sit'] == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2' selected>Não</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="proof"><span class="text-danger">*</span> Comprovante?</label>
                    <select name="proof" id="proof" class="form-control is-invalid" required>
                        <?php
                        if (isset($valorForm['proof']) and $valorForm['proof'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        } elseif (isset($valorForm['proof']) and $valorForm['proof'] == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2' selected>Não</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="launch_number"> Lançamento Fiscal</label>
                    <input name="launch_number" id="launch_number" type="number" class="form-control" value="<?php
                    if (isset($valorForm['launch_number'])) {
                        echo $valorForm['launch_number'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-row d-none" id="parc">

                <div class="form-group col-md-3">
                    <label for="installments"> Parcelas</label>
                    <input name="installments" id="installments" type="number" min="0" max="10" class="form-control" value="0">
                </div>

            </div>

            <div class="form-row">
                <!-- Dados para pagamento -->
                <div class="form-group col-md-2">
                    <label for="bank_id">Banco</label>
                    <select name="bank_id" id="bank_id" class="form-control is-valid">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['bank'] as $bank) {
                            extract($bank);
                            if (isset($valorForm['bank_id']) and ($valorForm['bank_id'] == $b_id)) {
                                echo "<option value='$b_id' selected>$bank_name</option>";
                            } else {
                                echo "<option value='$b_id'>$bank_name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-1">
                    <label for="agency">Agência</label>
                    <input name="agency" id="agency" type="number" class="form-control" value="<?php
                    if (isset($valorForm['agency'])) {
                        echo $valorForm['agency'];
                    }
                    ?>">
                </div>

                <div class="form-group col-md-2">
                    <label for="type_account">Tipo de Conta</label>
                    <select name="type_account" id="type_account" class="form-control is-valid">
                        <?php
                        if (isset($valorForm['type_account']) and $valorForm['type_account'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Conta Corrente</option>";
                            echo "<option value='2'>Poupança</option>";
                        } elseif (isset($valorForm['type_account']) and $valorForm['type_account'] == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Conta Corrente</option>";
                            echo "<option value='2' selected>Poupança</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Conta Corrente</option>";
                            echo "<option value='2'>Poupança</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="checking_account">Conta</label>
                    <input name="checking_account" id="checking_account" type="number" class="form-control" value="<?php
                    if (isset($valorForm['checking_account'])) {
                        echo $valorForm['checking_account'];
                    }
                    ?>">
                </div>

                <div class="form-group col-md-2">
                    <label for="document_number_supplier">CPF</label>
                    <input name="document_number_supplier" id="document_number_supplier" type="text" class="form-control" value="<?php
                    if (isset($valorForm['document_number_supplier'])) {
                        echo $valorForm['document_number_supplier'];
                    }
                    ?>">
                </div>

                <div class="form-group col-md-3">
                    <label for="name_supplier">Títular</label>
                    <input name="name_supplier" id="name_supplier" type="text" class="form-control is-valid" value="<?php
                    if (isset($valorForm['name_supplier'])) {
                        echo $valorForm['name_supplier'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-control text-center mb-2">
                    <strong>Pagamento via PIX</strong>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="adms_type_key_pix_id">Tipo de Chave</label>
                    <select name="adms_type_key_pix_id" id="adms_type_key_pix_id" class="form-control is-valid">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['key_pix'] as $pix) {
                            extract($pix);
                            if (isset($valorForm['adms_type_key_pix_id']) and ($valorForm['adms_type_key_pix_id'] == $p_id)) {
                                echo "<option value='$p_id' selected>$key_name</option>";
                            } else {
                                echo "<option value='$p_id'>$key_name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-10">
                    <label for="key_pix">Chave PIX</label>
                    <input name="key_pix" id="key_pix" type="text" class="form-control" value="<?php
                    if (isset($valorForm['key_pix'])) {
                        echo $valorForm['key_pix'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="obs">Observações</label>
                    <textarea name="obs" id="obs" class="form-control editorCK is-invalid" rows="4">
                        <?php
                        if (isset($valorForm['obs'])) {
                            echo $valorForm['obs'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="file_name"><span class="text-danger">*</span> Arquivo</label>
                    <input class="form-control-file is-invalid" name="file_name[]" id="file_name" type="file" required multiple/>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="AddOrder" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>

