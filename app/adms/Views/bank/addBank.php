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
                <h2 class="display-4 titulo">Cadastrar Banco</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_bank']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'banks/list'; ?>" class="btn btn-outline-info btn-sm"><i class="fa-solid fa-list"></i></a>
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
                    <label><span class="text-danger">*</span> Banco</label>
                    <input name="bank_name" type="text" class="form-control is-invalid" placeholder="Nome do banco" value="<?php
                    if (isset($valorForm['bank_name'])) {
                        echo $valorForm['bank_name'];
                    }
                    ?>" required autofocus>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Código do Banco</label>
                    <input name="cod_bank" type="text" class="form-control is-invalid" placeholder="Código do banco" value="<?php
                    if (isset($valorForm['cod_bank'])) {
                        echo $valorForm['cod_bank'];
                    }
                    ?>" required>
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
            <input name="AddBank" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
