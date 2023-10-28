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
                <h2 class="display-4 titulo">Ordem de Pagamtento</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_order']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'order-payments/list'; ?>" class="btn btn-outline-info btn-sm"><i class="fa-solid fa-list"></i> Listar</a>
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
                    <label><span class="text-danger">*</span> Área</label>
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
                    <label><span class="text-danger">*</span> Centro de Custos</label>
                    <select name="adms_cost_center_id" id="adms_cost_center_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['cost'] as $cc) {
                            extract($cc);
                            if (isset($valorForm['adms_cost_center_id']) == $c_id) {
                                echo "<option value='$c_id' selected>$costCenter</option>";
                            } else {
                                echo "<option value='$c_id'>$costCenter</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Marca</label>
                    <select name="adms_brand_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['brand'] as $brand) {
                            extract($brand);
                            if (isset($valorForm['adms_brand_id']) == $b_id) {
                                echo "<option value='$b_id' selected>$brand</option>";
                            } else {
                                echo "<option value='$b_id'>$brand</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Data de Pagamento</label>
                    <input name="date_payment" type="date" id="date_payment" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['date_payment'])) {
                        echo $valorForm['date_payment'];
                    }
                    ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Aprovador</label>
                    <select name="manager_id" id="manager_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['manager'] as $m) {
                            extract($m);
                            if (isset($valorForm['manager_id']) == $m_id) {
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
                    <label> Nota fiscal</label>
                    <input name="number_nf" id="number_nf" type="number" class="form-control" value="<?php
                    if (isset($valorForm['number_nf'])) {
                        echo $valorForm['number_nf'];
                    }
                    ?>">
                </div>

                <div class="form-group col-md-7">
                    <label><span class="text-danger">*</span> Fornecedor</label>
                    <select name="adms_supplier_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['supplier'] as $supplier) {
                            extract($supplier);
                            if (isset($valorForm['adms_supplier_id']) == $sup_id) {
                                echo "<option value='$sup_id' selected>$fantasy_name - $cnpj_cpf</option>";
                            } else {
                                echo "<option value='$sup_id'>$fantasy_name - $cnpj_cpf</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Valor Total</label>
                    <input name="total_value" type="text" id="valor_correto" class="form-control is-invalid" required value="<?php
                    if (isset($valorForm['total_value'])) {
                        echo $valorForm['total_value'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Descrição</label>
                    <input name="description" type="text" class="form-control is-invalid" required value="<?php
                    if (isset($valorForm['description'])) {
                        echo $valorForm['description'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Forma de Pagamento</label>
                    <select name="adms_type_payment_id" id="adms_type_payment_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['type_payment'] as $type) {
                            extract($type);
                            if (isset($valorForm['adms_type_payment_id']) == $t_id) {
                                echo "<option value='$t_id' selected>$type_payment</option>";
                            } else {
                                echo "<option value='$t_id'>$type_payment</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Adiantamento</label>
                    <select name="advance" id="advance" class="form-control is-invalid" required>
                        <?php
                        if (isset($valorForm['advance']) == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        } elseif (isset($valorForm['advance']) == 2) {
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

                <div class="form-group col-md-3">
                    <label> Valor - Adiantamento</label>
                    <input name="advance_amount" id="money" type="text" class="form-control" value="<?php
                    if (isset($valorForm['advance_amount'])) {
                        echo $valorForm['advance_amount'];
                    }
                    ?>">
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Comprovante?</label>
                    <select name="proof" id="proof" class="form-control is-invalid" required>
                        <?php
                        if (isset($valorForm['proof']) == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        } else {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2' selected>Não</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row d-none" id="parc">

                <div class="form-group col-md-3">
                    <label> Parcelas</label>
                    <input name="installments" id="installments" type="number" min="0" max="10" class="form-control" value="0">
                </div>

            </div>

            <div class="form-row">
                <!-- Dados para pagamento -->
                <div class="form-group col-md-3">
                    <label>Banco</label>
                    <select name="bank_id" id="bank_id" class="form-control is-valid">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['bank'] as $bank) {
                            extract($bank);
                            if (isset($valorForm['bank_id']) == $b_id) {
                                echo "<option value='$b_id' selected>$bank_name</option>";
                            } else {
                                echo "<option value='$b_id'>$bank_name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label>Agência</label>
                    <input name="agency" type="number" class="form-control" value="<?php
                    if (isset($valorForm['agency'])) {
                        echo $valorForm['agency'];
                    }
                    ?>">
                </div>

                <div class="form-group col-md-2">
                    <label>Conta</label>
                    <input name="checking_account" type="number" class="form-control" value="<?php
                    if (isset($valorForm['checking_account'])) {
                        echo $valorForm['checking_account'];
                    }
                    ?>">
                </div>

                <div class="form-group col-md-5">
                    <label><span class="text-danger">*</span> Títular</label>
                    <input name="name_supplier" type="text" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['name_supplier'])) {
                        echo $valorForm['name_supplier'];
                    }
                    ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-control text-center">
                    <strong>Pagamento via PIX</strong>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Tipo de Chave</label>
                    <select name="adms_type_key_pix_id" id="adms_type_key_pix_id" class="form-control is-valid">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['key_pix'] as $pix) {
                            extract($pix);
                            if (isset($valorForm['adms_type_key_pix_id']) == $p_id) {
                                echo "<option value='$p_id' selected>$key_name</option>";
                            } else {
                                echo "<option value='$p_id'>$key_name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-10">
                    <label>Chave PIX</label>
                    <input name="key_pix" type="text" class="form-control" value="<?php
                    if (isset($valorForm['key_pix'])) {
                        echo $valorForm['key_pix'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Observações</label>
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
                    <label><span class="text-danger">*</span> Arquivo</label>
                    <input class="form-control-file is-invalid" name="file_name" type="file" required />
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="AddOrder" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>

