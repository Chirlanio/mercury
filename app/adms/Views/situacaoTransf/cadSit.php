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
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Situação - Transferência</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_sit']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'situacao-transf/listar'; ?>" class="btn btn-outline-info btn-sm"><i class='fa-solid fa-list'></i></a>
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
                    <input name="nome" type="text" class="form-control is-invalid" placeholder="Nome da situação" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>" required autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Cor</label>
                    <select name="adms_cor_id" id="adms_cor_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['cor'] as $cor) {
                            extract($cor);
                            if ($valorForm['adms_cor_id'] == $id_cor) {
                                echo "<option value='$id_cor' selected>$nome_cor</option>";
                            } else {
                                echo "<option value='$id_cor'>$nome_cor</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadSit" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
