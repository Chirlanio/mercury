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
                <h2 class="display-4 titulo">Cadastrar Rota</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_rota']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'rota/listar'; ?>" class="btn btn-outline-info btn-sm">Listar</a>
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
                    <label><span class="text-danger">*</span> Nome</label>
                    <input name="nome" type="text" class="form-control is-invalid" placeholder="Nome da rota" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Cor</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > 2) {
                        echo '<select name="adms_cor_id" id="adms_cor_id" class="form-control is-invalid" aria-label="Disabled input" disabled required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['cor'] as $c) {
                            extract($c);
                            if ($valorForm['c_id'] == $c_id) {
                                echo "<option value='$c_id' selected>$cor</option>";
                            } else {
                                echo "<option value='$c_id'>$cor</option>";
                            }
                        }
                    } else {
                        echo '<select name="adms_cor_id" id="adms_cor_id" class="form-control is-invalid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['cor'] as $c) {
                            extract($c);
                            if ($valorForm['c_id'] == $c_id) {
                                echo "<option value='$c_id' selected>$cor</option>";
                            } else {
                                echo "<option value='$c_id'>$cor</option>";
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
            <input name="CadRota" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
