<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['botao']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Remanejo</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_relocation']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'relocation/list'; ?>" class="btn btn-outline-info btn-sm"><i class='fas fa-list d-block d-md-none fa-2x'></i> <span class='d-none d-md-block'><i class='fa-solid fa-list'></i></span></a>
                </div>
                <?php
            }
            ?>
        </div>
        <hr>
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
                    <input name="relocation_name" id="relocation_name" type="text" class="form-control is-invalid" placeholder="Digite o nome" value="<?php
                    if (isset($valorForm['relocation_name'])) {
                        echo $valorForm['relocation_name'];
                    }
                    ?>" autofocus required>
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Arquivo</label>
                    <input name="file_relocation" type="file" class="form-control-file">
                </div>

            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="SendRelocation" type="submit" class="btn btn-success" value="Cadastrar">
        </form>
    </div>
</div>