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
                <h2 class="display-4 titulo">Cadastrar Bandeira</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_bandeira']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'bandeira/listar'; ?>" class="btn btn-outline-info btn-sm">Listar</a>
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
                    <label><span class="text-danger">*</span> Bandeira</label>
                    <input name="nome" type="text" class="form-control is-invalid" placeholder="Nome da bandeira" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>" required autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label>
                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Página de icone: <a href='https://fontawesome.com/icons?d=gallery' target='_blank'>fontawesome</a>. Somente inserir o nome, Ex: fas fa-volume-up">
                            <i class="fas fa-question-circle"></i>
                        </span> <span class="text-danger">*</span> Ícone</label>
                    <input name="icone" type="text" class="form-control is-invalid" placeholder="Ex: fas fa-cc-visa" value="<?php
                    if (isset($valorForm['icone'])) {
                        echo $valorForm['icone'];
                    }
                    ?>" required>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadBandeira" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
