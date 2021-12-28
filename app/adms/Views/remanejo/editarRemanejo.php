<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['select']['sit']);
var_dump($valorForm);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Remanejo</h2>
            </div>

            <?php
            if ($this->Dados['botao']['list_remanejo']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'remanejo/listar'; ?>" class="btn btn-outline-info btn-sm">Listar</a>
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
        <form method="POST" action="" enctype="multipart/form-data"> 
            <input name="id" type="hidden" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Marca</label>
                    <select name="adms_marca_id" id="adms_marca_id" class="custom-select is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['mar_id'] as $mar) {
                            extract($mar);
                            if ($valorForm['adms_marca_id'] == $mar_id) {
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
                            if ($valorForm['loja_origem_id'] == $id_loja) {
                                echo "<option value='$id_loja' selected>$loja_origem</option>";
                            } else {
                                echo "<option value='$id_loja'>$loja_origem</option>";
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
                            if ($valorForm['loja_destino_id'] == $loja_des) {
                                echo "<option value='$loja_des' selected>$loja_destino</option>";
                            } else {
                                echo "<option value='$loja_des'>$loja_destino</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Tipo</label>
                    <select name="adms_tipo_rem_id" id="adms_tipo_rem_id" class="custom-select is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['tip_id'] as $tip) {
                            extract($tip);
                            if ($valorForm['adms_tipo_rem_id'] == $tip_id) {
                                echo "<option value='$tip_id' selected>$tipo</option>";
                            } else {
                                echo "<option value='$tip_id'>$tipo</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Prioridade</label>
                    <select name="adms_prdd_id" id="adms_prdd_id" class="custom-select is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['prdd'] as $prdd) {
                            extract($prdd);
                            if ($valorForm['adms_prdd_id'] == $prdd_id) {
                                echo "<option value='$prdd_id' selected>$prioridade</option>";
                            } else {
                                echo "<option value='$prdd_id'>$prioridade</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="adms_sit_rem_id" id="adms_sits_rem_id" class="custom-select is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sit_id'] as $sts) {
                            extract($sts);
                            if ($valorForm['adms_sit_rem_id'] == $sit_id) {
                                echo "<option value='$sit_id' selected>$situacao</option>";
                            } else {
                                echo "<option value='$sit_id'>$situacao</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Nota Fiscal</label>
                    <input name="nf" type="text" id="nf" class="form-control is-valid" placeholder="Digite o número da nota fiscal" value="<?php
                    if ($valorForm['nf']) {
                        echo $valorForm['nf'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <input name="file_antigo" type="hidden" value="<?php
                    if (isset($valorForm['file_antigo'])) {
                        echo $valorForm['file_antigo'];
                    } elseif (isset($valorForm['arquivo'])) {
                        echo $valorForm['arquivo'];
                    }
                    ?>">

                    <div class="form-group">
                        <label>
                            <span class="text-danger">*</span> Planilha
                        </label>
                        <input name="novo_file" type="file" class="form-control-file" id="nova_file">
                    </div>
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditRemanejo" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
