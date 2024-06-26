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
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Coleta de Transferências e Remanejo</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_transf']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'transferencia/listar-transf'; ?>" class="btn btn-outline-info btn-sm"><i class='fa-solid fa-list'></i></a>
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
                    <select name="loja_origem_id" id="loja_origem_id" class="form-control is-invalid" required autofocus>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['loja_origem'] as $lo) {
                            extract($lo);
                            if (isset($valorForm['loja_origem_id']) and $valorForm['loja_origem_id'] == $lo_id) {
                                echo "<option value='$lo_id' selected>$loja_orig</option>";
                            } else {
                                echo "<option value='$lo_id'>$loja_orig</option>";
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
                        foreach ($this->Dados['select']['loja_destino'] as $ld) {
                            extract($ld);
                            if (isset($valorForm['loja_destino_id']) and $valorForm['loja_destino_id'] == $ld_id) {
                                echo "<option value='$ld_id' selected>$loja_dest</option>";
                            } else {
                                echo "<option value='$ld_id'>$loja_dest</option>";
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
                        foreach ($this->Dados['select']['tipo_transf'] as $typeTransf) {
                            extract($typeTransf);
                            if (isset($valorForm['tipo_transf_id']) and $valorForm['tipo_transf_id'] == $t_id) {
                                echo "<option value='$t_id' selected>$tipo</option>";
                            } else {
                                echo "<option value='$t_id'>$tipo</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <input name="status_id" type="hidden" value="<?php echo 1; ?>">
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadTransf" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
