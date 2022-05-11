<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['botao']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Remanejo</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_remanejo']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'remanejo/listar'; ?>" class="btn btn-outline-info btn-sm"><i class='fas fa-list d-block d-md-none fa-2x'></i> <span class='d-none d-md-block'>Listar</span></a>
                </div>
                <?php
            }
            ?>
        </div>
        <hr>
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
                    <select name="adms_marca_id" id="adms_marca_id" class="custom-select is-invalid" required autofocus>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['mar_id'] as $mar) {
                            extract($mar);
                            if (isset($valorForm['mar_id']) == $mar_id) {
                                echo "<option value='$mar_id' selected>$marca</option>";
                            } else {
                                echo "<option value='$mar_id'>$marca</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Loja - Origem</label>
                    <select name="loja_origem_id" id="loja_origem_id" class="custom-select is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['loja_ori'] as $lo_ori) {
                            extract($lo_ori);
                            if (isset($valorForm['loja_ori']) == $lj_ori_id) {
                                echo "<option value='$lj_ori_id' selected>$loja_origem</option>";
                            } else {
                                echo "<option value='$lj_ori_id'>$loja_origem</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Loja - Destino</label>
                    <select name="loja_destino_id" id="loja_destino_id" class="custom-select is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['loja_des'] as $lo_des) {
                            extract($lo_des);
                            if (isset($valorForm['loja_des']) == $lj_des_id) {
                                echo "<option value='$lj_des_id' selected>$loja_destino</option>";
                            } else {
                                echo "<option value='$lj_des_id'>$loja_destino</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Tipo</label>
                    <select name="adms_tipo_rem_id" id="adms_tipo_rem_id" class="custom-select is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['tip_id'] as $tip) {
                            extract($tip);
                            if (isset($valorForm['tip_id']) == $id_tip) {
                                echo "<option value='$id_tip' selected>$tipo</option>";
                            } else {
                                echo "<option value='$id_tip'>$tipo</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Prioridade</label>
                    <select name="adms_prdd_id" id="adms_prdd_id" class="custom-select is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['prdd_id'] as $prdd) {
                            extract($prdd);
                            if (isset($valorForm['prdd_id']) == $prdd_id) {
                                echo "<option value='$prdd_id' selected>$prioridade</option>";
                            } else {
                                echo "<option value='$prdd_id'>$prioridade</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Arquivo</label>
                    <input name="arquivo" type="file" class="form-control-file">
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadRemanejo" type="submit" class="btn btn-success" value="Cadastrar">
        </form>
    </div>
</div>