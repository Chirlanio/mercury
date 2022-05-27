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
                    <a href="<?php echo URLADM . 'balanco/listar'; ?>" class="btn btn-outline-info btn-sm"><i class='fas fa-list d-block d-md-none fa-2x'></i> <span class='d-none d-md-block'>Listar</span></a>
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
                <div class = "form-group col-md-6">
                    <label><span class = "text-danger">*</span> Loja</label>
                    <select name="loja_id" id="loja_id" class="custom-select is-invalid" required>
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
                <div class = "form-group col-md-6">
                    <label><span class = "text-danger">*</span> Ciclo</label>
                    <select name="ciclo_id" id="ciclo_id" class="custom-select is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['ciclo'] as $l) {
                            extract($l);
                            if ($valorForm['ciclo_id'] == $c_id) {
                                echo "<option value='$c_id' selected>$ciclo - $ano</option>";
                            } else {
                                echo "<option value='$c_id'>$ciclo - $ano</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Responsável</label>
                    <select name="responsavel_loja_id" id="responsavel_loja_id" class="custom-select is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['func_id'] as $c) {
                            extract($c);
                            if ($valorForm['responsavel_loja_id'] == $resp_loja_id) {
                                echo "<option value='$resp_loja_id' selected>$loja_resp</option>";
                            } else {
                                echo "<option value='$resp_loja_id'>$loja_resp</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Auditor</label>
                    <select name="responsavel_auditoria_id" id="responsavel_auditoria_id" class="custom-select is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['resp'] as $c) {
                            extract($c);
                            if ($valorForm['responsavel_auditoria_id'] == $resp_auditor_id) {
                                echo "<option value='$resp_auditor_id' selected>$resp</option>";
                            } else {
                                echo "<option value='$resp_auditor_id'>$resp</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="status_id" id="status_id" class="custom-select is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sit'] as $c) {
                            extract($c);
                            if ($valorForm['status_id'] == $sit_id) {
                                echo "<option value='$sit_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$sit_id'>$sit</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Observação</label>
                    <textarea name="obs" id="editor" class="form-control is-invalid editorCK" rows="3" required><?php
                        if (isset($valorForm['obs'])) {
                            echo $valorForm['obs'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadBalanco" type="submit" class="btn btn-success" value="Cadastrar">
        </form>
    </div>
</div>
