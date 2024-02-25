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
                <h2 class="display-4 titulo">Editar Pedido de Faturamento <strong>ID: <?php echo $valorForm['id']; ?></strong></h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_ecommerce_order']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'ecommerce/list'; ?>" class="btn btn-outline-info btn-sm"><i class='fas fa-list'></i></a>
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
            <input name="id" type="hidden" value="<?php
            if (!empty($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>" >
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Loja</label>
                    <select name="loja_id" id="loja_id" class="form-control is-invalid" autofocus <?php echo $_SESSION['adms_niveis_acesso_id'] == STOREPERMITION ? "disabled" : "required"; ?> >
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['store'] as $stp) {
                            extract($stp);
                            if (isset($valorForm['loja_id']) and $valorForm['loja_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$store</option>";
                            } else {
                                echo "<option value='$s_id'>$store</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-5">
                    <label><span class="text-danger">*</span> Colaborador</label>
                    <select name="func_id" id="func_id" class="form-control is-invalid" <?php echo $_SESSION['adms_niveis_acesso_id'] == STOREPERMITION ? "disabled" : "required"; ?>>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['employee'] as $fc) {
                            extract($fc);
                            if (isset($valorForm['func_id']) and $valorForm['func_id'] == $f_id) {
                                echo "<option value='$f_id' selected>$colaborador</option>";
                            } else {
                                echo "<option value='$f_id'>$colaborador</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="date_order"><span class="text-danger">*</span> Data do Pedido</label>
                    <input name="date_order" type="date" id="date_order" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['date_order'])) {
                        echo $valorForm['date_order'];
                    }
                    ?>" <?php echo $_SESSION['adms_niveis_acesso_id'] == STOREPERMITION ? "disabled" : "required"; ?>>
                </div>

                <div class="form-group col-md-2">
                    <label for="number_order"><span class="text-danger">*</span> Número do Pedido</label>
                    <input name="number_order" type="number" id="number_order" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['number_order'])) {
                        echo $valorForm['number_order'];
                    }
                    ?>" <?php echo $_SESSION['adms_niveis_acesso_id'] == STOREPERMITION ? "disabled" : "required"; ?>>
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-md-2">
                    <label for="number_nf"><span class="text-danger">*</span> Nota de Transferêcia</label>
                    <input name="number_nf" type="number" id="number_nf" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['number_nf'])) {
                        echo $valorForm['number_nf'];
                    }
                    ?>" <?php echo $_SESSION['adms_niveis_acesso_id'] == STOREPERMITION ? "disabled" : "required"; ?>>
                </div>

                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Só Faturar?</label>
                    <select name="just_invoice" id="just_invoice" class="form-control is-invalid" required>
                        <?php
                        if (isset($valorForm['just_invoice']) == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Não</option>";
                            echo "<option value='2'>Sim</option>";
                        } elseif (isset($valorForm['just_invoice']) == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Não</option>";
                            echo "<option value='2' selected>Sim</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Não</option>";
                            echo "<option value='2'>Sim</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Cadastrado Por</label>
                    <select name="created_by" id="created_by" class="form-control is-invalid" <?php echo $_SESSION['adms_niveis_acesso_id'] == STOREPERMITION ? "disabled" : "required"; ?>>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['users'] as $fc) {
                            extract($fc);
                            if (isset($valorForm['created_by']) and $valorForm['created_by'] == $u_id) {
                                echo "<option value='$u_id' selected>$creator</option>";
                            } else {
                                echo "<option value='$u_id'>$creator</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="number_invoice_nf">Nota de Venda</label>
                    <input name="number_invoice_nf" type="number" id="number_invoice_nf" class="form-control is-valid" value="<?php
                    if (isset($valorForm['number_invoice_nf'])) {
                        echo $valorForm['number_invoice_nf'];
                    }
                    ?>" <?php echo $_SESSION['adms_niveis_acesso_id'] == STOREPERMITION ? "disabled" : ""; ?>>
                </div>

                <?php if ($_SESSION['adms_niveis_acesso_id'] != STOREPERMITION) { ?>
                    <div class="form-group col-md-2">
                        <label><span class="text-danger">*</span> Situação</label>
                        <select name="adms_sit_ecommerce_id" id="adms_sit_ecommerce_id" class="form-control is-invalid" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->Dados['select']['status'] as $sit) {
                                extract($sit);
                                if (isset($valorForm['adms_sit_ecommerce_id']) and $valorForm['adms_sit_ecommerce_id'] == $s_id) {
                                    echo "<option value='$s_id' selected>$status</option>";
                                } else {
                                    echo "<option value='$s_id'>$status</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                <?php } ?>

            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditOrder" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>

