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
                <h2 class="display-4 titulo">Solicitar Faturamento</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_ecommerce_order']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'ecommerce/list'; ?>" class="btn btn-outline-info btn-sm"><i class="fa-solid fa-list"></i></a>
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
                    <label><span class="text-danger">*</span> Loja</label>
                    <select name="loja_id" id="loja_id" class="form-control is-invalid" required autofocus>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['store'] as $lj) {
                            extract($lj);
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
                    <label><span class="text-danger">*</span> Consultora</label>
                    <select name="func_id" id="func_id" class="form-control is-invalid" required>
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
                    ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="number_order"><span class="text-danger">*</span> Número do Pedido</label>
                    <input name="number_order" type="text" id="number_order" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['number_order'])) {
                        echo $valorForm['number_order'];
                    }
                    ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="number_nf"><span class="text-danger">*</span> Nota de Transferência</label>
                    <input name="number_nf" type="text" id="number_nf" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['number_nf'])) {
                        echo $valorForm['number_nf'];
                    }
                    ?>" required>
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
            </div>
            
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="AddOrder" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>

