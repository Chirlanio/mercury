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
                <h2 class="display-4 titulo">Cadastrar Dashboards</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_dash']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'dashboard/listar'; ?>" class="btn btn-outline-info btn-sm">Listar</a>
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
                    <label><span class="text-danger">*</span> Nome</label>
                    <input name="nome" type="text" class="form-control is-invalid" placeholder="Nome do dashboard" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-5">
                    <label>Descrição</label>
                    <input name="descricao" type="text" class="form-control is-invalid" placeholder="Descrição do dashboard" value="<?php
                    if (isset($valorForm['descricao'])) {
                        echo $valorForm['descricao'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Área</label>
                    <select name="area_id" id="area_id" class="form-control is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['area'] as $area) {
                            extract($area);
                            if ($valorForm['niv_ac'] == $area_id) {
                                echo "<option value='$area_id' selected>$area</option>";
                            } else {
                                echo "<option value='$area_id'>$area</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label><span class = "text-danger">*</span>Loja</label>
                    <select name="loja_id" id="loja_id" class="form-control is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['loja_id'] as $loja) {
                            extract($loja);
                            if ($valorForm['loja_id'] == $loja_id) {
                                echo "<option value='$loja_id' selected>$loja_nome</option>";
                            } else {
                                echo "<option value='$loja_id'>$loja_nome</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Nível de Acesso</label>
                    <select name="niv_acesso_id" id="niv_acesso_id" class="form-control is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['niv_ac'] as $nivac) {
                            extract($nivac);
                            if ($valorForm['niv_ac'] == $id_niv) {
                                echo "<option value='$id_niv' selected>$nivac</option>";
                            } else {
                                echo "<option value='$id_niv'>$nivac</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Link</label>
                    <input name="link" type="text" class="form-control is-invalid" placeholder="Cole o link do dashboard" value="<?php
                    if (isset($valorForm['link'])) {
                        echo $valorForm['link'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Status</label>
                    <select name="status_id" id="loja_id" class="form-control is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sit'] as $sit) {
                            extract($sit);
                            if ($valorForm['sit'] == $sit_id) {
                                echo "<option value='$sit_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$sit_id'>$sit</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <input name="created" type="hidden" value="<?php echo date("Y-m-d H:i:s"); ?>">
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadDash" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
