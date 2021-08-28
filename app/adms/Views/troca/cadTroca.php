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
                <h2 class="display-4 titulo">Cadastrar Produto - Troca</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_troca']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'listar-troca/listar-troca'; ?>" class="btn btn-outline-info btn-sm">Listar</a>
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
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Solicitante</label>
                    <select name = "func_id" id="func_id" class="form-control is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['func_id'] as $consul) {
                            extract($consul);
                            if ($valorForm['func_id'] == $id_consul) {
                                echo "<option value='$id_consul' selected>$consul</option>";
                            } else {
                                echo "<option value='$id_consul'>$consul</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class = "form-group col-md-6">
                    <label><span class = "text-danger">*</span> Loja</label>
                    <select name="loja_id" id="loja_id" class="form-control is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['loja_id'] as $loja) {
                            extract($loja);
                            if ($valorForm['loja_id'] == $id_loja) {
                                echo "<option value='$id_loja' selected>$loja</option>";
                            } else {
                                echo "<option value='$id_loja'>$loja</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Referência</label>
                    <input name="referencia" type="text" class="form-control is-invalid" placeholder="Referência" value="<?php
                    if (isset($valorForm['referencia'])) {
                        echo $valorForm['referencia'];
                    }
                    ?>" required>
                </div>
                <div class = "form-group col-md-6">
                    <label><span class = "text-danger">*</span> Motivo</label>
                    <select name="motivo_id" id="motivo_id" class="form-control is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['motivo_id'] as $mot) {
                            extract($mot);
                            if ($valorForm['motivo_id'] == $motivo_id) {
                                echo "<option value='$motivo_id' selected>$motivo</option>";
                            } else {
                                echo "<option value='$motivo_id'>$motivo</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <input name="status_id" type="hidden" value="<?php echo 3; ?>">
            <input name="created" type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>">
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadTroca" type="submit" class="btn btn-success" value="Cadastrar">
        </form>
    </div>
</div>
