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
                <h2 class="display-4 titulo">Cadastrar Tipo - Artigo</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_tipo']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'tipo-artigo/listar'; ?>" class="btn btn-outline-info btn-sm">Listar</a>
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
                    <label><span class="text-danger">*</span> Tipo de Artipo</label>
                    <input name="nome" type="text" class="form-control is-invalid" placeholder="Nome do tipo do artigo" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>" autofocus required>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadTipo" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
