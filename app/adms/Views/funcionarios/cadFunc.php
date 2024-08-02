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
            <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Funcionário</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_func']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'funcionarios/listar-func'; ?>" class="btn btn-outline-info btn-sm"><i class='fas fa-list'></i></a>
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
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Nome</label>
                    <input name="nome" type="text" class="form-control is-invalid" placeholder="Digite o nome completo" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>" required autofocus>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Usuário</label>
                    <input name="usuario" type="text" class="form-control is-invalid" placeholder="Digite o usuário" value="<?php
                    if (isset($valorForm['usuario'])) {
                        echo $valorForm['usuario'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> CPF</label>
                    <input name="cpf" type="text" id="cpf" class="form-control is-invalid" placeholder="Digite o CPF, somente números" value="<?php
                    if (isset($valorForm['cpf'])) {
                        echo $valorForm['cpf'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label>Cupom Site</label>
                    <input name="cupom_site" type="text" id="cupom_site" class="form-control is-invalid" placeholder="Digite o cupom" value="<?php
                    if (isset($valorForm['cupom_site'])) {
                        echo $valorForm['cupom_site'];
                    }
                    ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class = "text-danger">*</span>Loja</label>
                    <select name="loja_id" id="loja_id" class="form-control is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['loja_id'] as $l) {
                            extract($l);
                            if ($valorForm['loja_id'] == $id_loja) {
                                echo "<option value='$id_loja' selected>$loja</option>";
                            } else {
                                echo "<option value='$id_loja'>$loja</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Função</label>
                    <select name="cargo_id" id="cargo_id" class="form-control is-invalid" required="">
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['cargo_id'] as $c) {
                            extract($c);
                            if ($valorForm['cargo_id'] == $cargo_id) {
                                echo "<option value='$cargo_id' selected>$cargo</option>";
                            } else {
                                echo "<option value='$cargo_id'>$cargo</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Área</label>
                    <select name="adms_area_id" id="adms_area_id" class="form-control is-invalid" required="">
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['areas'] as $area) {
                            extract($area);
                            if ($valorForm['adms_area_id'] == $area_id) {
                                echo "<option value='$area_id' selected>$name_area</option>";
                            } else {
                                echo "<option value='$area_id'>$name_area</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Status</label>
                    <select name="status_id" id="loja_id" class="form-control is-invalid" required="">
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sit_id'] as $sit) {
                            extract($sit);
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
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadFunc" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
