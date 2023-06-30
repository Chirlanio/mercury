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
                <h2 class="display-4 titulo">Cadastrar Categoria - Artigo</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_cat']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'categoria-artigo/listar'; ?>" class="btn btn-outline-info btn-sm">Listar</a>
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
                    <label><span class="text-danger">*</span> Nome da Categoria</label>
                    <input name="nome" type="text" class="form-control is-invalid" placeholder="Nome da categoria do artigo" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>" autofocus required>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Status</label>
                    <select name="adms_sit_id" id="adms_sit_id" class="form-control is-invalid" required>
                        <?php
                        if (isset($valorForm['adms_sit_id']) == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Ativo</option>";
                            echo "<option value='2'>Inativo</option>";
                        } elseif (isset($valorForm['troca']) == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Ativo</option>";
                            echo "<option value='2' selected>Inativo</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Ativo</option>";
                            echo "<option value='2'>Inativo</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadCat" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
