<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Pedido</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_ped']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'prateleira-infinita/listar'; ?>" class="btn btn-outline-info btn-sm">Listar</a>
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
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Referência</label>
                    <input name="referencia" type="text" class="form-control is-invalid" placeholder="Digite a referência completa" value="<?php
                    if (isset($valorForm['referencia'])) {
                        echo $valorForm['referencia'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Tamanho</label>
                    <select name="tam_id" id="tam_id" class="form-control is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['tam'] as $t) {
                            extract($t);
                            if ($valorForm['tam'] == $tam_id) {
                                echo "<option value='$tam_id' selected>$tam</option>";
                            } else {
                                echo "<option value='$tam_id'>$tam</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label><span class = "text-danger">*</span>Loja</label>
                    <select name="loja_id" id="loja_id" class="form-control is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['loja_id'] as $loja) {
                            extract($loja);
                            if ($valorForm['loja_id'] == $loja_id) {
                                echo "<option value='$loja_id' selected>$loja</option>";
                            } else {
                                echo "<option value='$loja_id'>$loja</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Solicitante</label>
                    <select name="func_id" id="func_id" class="form-control is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['func'] as $f) {
                            extract($f);
                            if ($valorForm['func'] == $id_func) {
                                echo "<option value='$id_func' selected>$func</option>";
                            } else {
                                echo "<option value='$id_func'>$func</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <input name="status_id" type="hidden" value="<?php echo '1'; ?>">
            <input name="created" type="hidden" value="<?php echo date("Y-m-d H:i:s"); ?>">
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadPed" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
