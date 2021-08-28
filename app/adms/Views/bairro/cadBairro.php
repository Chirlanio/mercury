<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['select']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Bairro</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_bairro']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'bairro/listar'; ?>" class="btn btn-outline-info btn-sm">Listar</a>
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
                    <label><span class="text-danger">*</span> Nome do Bairro</label>
                    <input name="nome" type="text" class="form-control is-invalid" placeholder="Nome do bairro" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Rota</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5) {
                        echo '<select name="rota_id" id="rota_id" class="form-control is-invalid" aria-label="Disabled input" disabled required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['rota_id'] as $sol) {
                            extract($sol);
                            if ($valorForm['r_id'] == $r_id) {
                                echo "<option value='$r_id' selected>$rota</option>";
                            } else {
                                echo "<option value='$r_id'>$rota</option>";
                            }
                        }
                    } else {
                        echo '<select name="rota_id" id="rota_id" class="form-control is-invalid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['rota_id'] as $sol) {
                            extract($sol);
                            if ($valorForm['r_id'] == $r_id) {
                                echo "<option value='$r_id' selected>$rota</option>";
                            } else {
                                echo "<option value='$r_id'>$rota</option>";
                            }
                        }
                    }
                    echo "</select>";
                    ?>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadBairro" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
