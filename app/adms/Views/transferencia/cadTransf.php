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
                <h2 class="display-4 titulo">Cadastrar Coleta de Transferências e Remanejo</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_transf']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'transferencia/listarTransf'; ?>" class="btn btn-outline-info btn-sm">Listar</a>
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
        <form method="POST" action="" cla
             class="was-validated" enctype="multipart/form-data"> 
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label><span class="text-danger">*</span> Loja - Origem</label>
                    <select name="loja_origem_id" id="loja_origem_id" class="form-control is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['loja_origem_id'] as $lo) {
                            extract($lo);
                            if ($valorForm['loja_origem_id'] == $loja_id) {
                                echo "<option value='$loja_id' selected>$loja_orig</option>";
                            } else {
                                echo "<option value='$loja_id'>$loja_orig</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-5">
                    <label><span class = "text-danger">*</span> Loja - Destino</label>
                    <select name="loja_destino_id" id="loja_destino_id" class="form-control is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['loja_destino_id'] as $ld) {
                            extract($ld);
                            if ($valorForm['loja_destino_id'] == $loja_id) {
                                echo "<option value='$loja_id' selected>$loja_dest</option>";
                            } else {
                                echo "<option value='$loja_id'>$loja_dest</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Nº Nota Fiscal</label>
                    <input name="nf" type="number" class="form-control is-invalid" placeholder="Número da Nota" value="<?php
                    if (isset($valorForm['nf'])) {
                        echo $valorForm['nf'];
                    }
                    ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Volumes</label>
                    <input name="qtd_vol" type="number" class="form-control is-invalid" placeholder="Qtd volumes" value="<?php
                    if (isset($valorForm['qtd_vol'])) {
                        echo $valorForm['qtd_vol'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Qtd Produtos</label>
                    <input name="qtd_prod" type="number" class="form-control is-invalid" placeholder="Qtd itens ou produtos" value="<?php
                    if (isset($valorForm['qtd_prod'])) {
                        echo $valorForm['qtd_prod'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Tipo</label>
                    <select name="tipo_transf_id" id="tipo_transf_id" class="form-control is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['tipo_transf_id'] as $t) {
                            extract($t);
                            if ($valorForm['tipo_transf_id'] == $id_tipo) {
                                echo "<option value='$id_tipo' selected>$tipo</option>";
                            } else {
                                echo "<option value='$id_tipo'>$tipo</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <input name="status_id" type="hidden" value="<?php echo 1; ?>">
            <input name="created" type="hidden" value="<?php echo date("Y-m-d H:i:s"); ?>">
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadTransf" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
