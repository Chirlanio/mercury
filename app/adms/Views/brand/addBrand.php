<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['select']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Marcas - Fornecedor</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_brand']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'brands/list'; ?>" class="btn btn-outline-info btn-sm"><i class="fa-solid fa-list"></i> Listar</a>
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
        <form method="POST" action="" class="was-validated" enctype="multipart/form-data"> 
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Marca</label>
                    <input name="brand" type="text" class="form-control is-invalid" placeholder="Nome da marca" value="<?php
                    if (isset($valorForm['brand'])) {
                        echo $valorForm['brand'];
                    }
                    ?>" required autofocus>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Fornecedor</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
                        echo '<select name="adms_supplier_id" id="adms_supplier_id" class="form-control is-invalid" aria-label="Disabled input" disabled required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['supp'] as $sup) {
                            extract($sup);
                            if ($valorForm['adms_supplier_id'] == $sup_id) {
                                echo "<option value='$sup_id' selected>$supplier</option>";
                            } else {
                                echo "<option value='$sup_id'>$supplier</option>";
                            }
                        }
                    } else {
                        echo '<select name="adms_supplier_id" id="adms_supplier_id" class="form-control is-invalid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['supp'] as $sup) {
                            extract($sup);
                            if ($valorForm['adms_supplier_id'] == $sup_id) {
                                echo "<option value='$sup_id' selected>$supplier</option>";
                            } else {
                                echo "<option value='$sup_id'>$supplier</option>";
                            }
                        }
                    }
                    echo "</select>";
                    ?>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Situação</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
                        echo '<select name="status_id" id="status_id" class="form-control is-invalid" aria-label="Disabled input" disabled required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sit'] as $sit) {
                            extract($sit);
                            if ($valorForm['status_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$status</option>";
                            } else {
                                echo "<option value='$s_id'>$status</option>";
                            }
                        }
                    } else {
                        echo '<select name="status_id" id="status_id" class="form-control is-invalid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sit'] as $sit) {
                            extract($sit);
                            if ($valorForm['status_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$status</option>";
                            } else {
                                echo "<option value='$s_id'>$status</option>";
                            }
                        }
                    }
                    echo "</select>";
                    ?>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="AddBrand" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
