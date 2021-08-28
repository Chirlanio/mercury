<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['form']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Balanço</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_balanco']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'balanco/listar-balanco'; ?>" class="btn btn-outline-info btn-sm"><i class='fas fa-list d-block d-md-none fa-2x'></i> <span class='d-none d-md-block'>Listar</span></a>
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
                    <label><span class="text-danger">*</span> Nome</label>
                    <select name="resp_loja_id" id="resp_loja_id" class="form-control is-invalid" autofocus required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['func_id'] as $c) {
                            extract($c);
                            if ($valorForm['resp_loja_id'] == $resp_loja_id) {
                                echo "<option value='$resp_loja_id' selected>$loja_resp</option>";
                            } else {
                                echo "<option value='$resp_loja_id'>$loja_resp</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class = "form-group col-md-4">
                    <label><span class = "text-danger">*</span> Loja</label>
                    <select name="loja_id" id="loja_id" class="form-control is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['loja_id'] as $l) {
                            extract($l);
                            if ($valorForm['loja_id'] == $lj_id) {
                                echo "<option value='$lj_id' selected>$loja</option>";
                            } else {
                                echo "<option value='$lj_id'>$loja</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Auditor</label>
                    <select name="resp_auditor_id" id="resp_auditor_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['resp'] as $c) {
                            extract($c);
                            if ($valorForm['resp_auditor_id'] == $resp_auditor_id) {
                                echo "<option value='$resp_auditor_id' selected>$resp</option>";
                            } else {
                                echo "<option value='$resp_auditor_id'>$resp</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Observação</label>
                    <textarea name="obs" id="editor" class="form-control is-invalid" rows="3" required><?php
                        if (isset($valorForm['obs'])) {
                            echo $valorForm['obs'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>
            <input name="status_id" type="hidden" value="<?php echo 1; ?>">
            <input name="created" type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>">
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadBalanco" type="submit" class="btn btn-success" value="Cadastrar">
        </form>
    </div>
</div>
