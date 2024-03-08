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
                <h2 class="display-4 titulo">Cadastrar Local de Defeito</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_def_local']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'defeito-local/listar'; ?>" class="btn btn-outline-info btn-sm"><i class='fa-solid fa-list'></i></a>
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
                    <label><span class="text-danger">*</span> Local</label>
                    <input name="descricao" type="text" class="form-control is-invalid" placeholder="Descrição do local do defeito" value="<?php
                    if (isset($valorForm['descricao'])) {
                        echo $valorForm['descricao'];
                    }
                    ?>" required autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">* </span>Situação</label>
                    <select name="status_id" class="custom-select is-invalid" required>
                        <option value="">Selecione...</option>
                        <?php
                        foreach ($this->Dados['select']['sit'] as $st) {
                            extract($st);
                            if (isset($valorForm['status_id']) == $s_id) {
                                echo "<option value='$s_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$s_id'>$sit</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadDefLocal" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
