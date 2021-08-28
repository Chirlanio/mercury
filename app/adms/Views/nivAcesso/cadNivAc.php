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
                <h2 class="display-4 titulo">Cadastrar Nível de Acesso</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_nivac']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'nivel-acesso/listar'; ?>" class="btn btn-outline-info btn-sm">Listar</a>
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
                <div class="form-group col-md-9">
                    <label><span class="text-danger">*</span> Nome</label>
                    <input name="nome" type="text" class="form-control is-invalid" placeholder="Digite o nome do nível de acesso" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Cor</label>
                    <select name="adms_cor_id" id="adms_cor_id" class="form-control is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['cor'] as $t) {
                            extract($t);
                            if ($valorForm['cor_id'] == $cor_id) {
                                echo "<option value='$cor_id' selected>$cor</option>";
                            } else {
                                echo "<option value='$cor_id'>$cor</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadNivAc" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
