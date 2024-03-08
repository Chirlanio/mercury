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
                <h2 class="display-4 titulo">Cadastrar Cor</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_cor']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'cor/listar'; ?>" class="btn btn-outline-info btn-sm"><i class='fa-solid fa-list'></i></a>
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
                    <input name="nome" type="text" class="form-control is-invalid" placeholder="Nome da cor" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>" required autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Cor</label>
                    <input name="cor" type="text" class="form-control is-invalid" placeholder="Nome do seletor da cor no Bootstrap4" value="<?php
                    if (isset($valorForm['cor'])) {
                        echo $valorForm['cor'];
                    }
                    ?>" required>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadCor" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
