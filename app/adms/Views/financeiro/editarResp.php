<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Cadastro</h2>
            </div>

            <?php
            if ($this->Dados['botao']['list_resp']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'autorizacao-resp/listar'; ?>" class="btn btn-outline-info btn-sm">Listar</a>
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
        <form method="POST" action="" enctype="multipart/form-data"> 
            <input name="id" type="hidden" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Rede</label>
                    <input name="nome" type="text" class="form-control" placeholder="Nome da Rede" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Responsável</label>
                    <select name="adms_func_id" id="adms_func_id" class="form-control">
                        <?php
                        foreach ($this->Dados['select']['resp'] as $r) {
                            extract($r);
                            if ($valorForm['adms_func_id'] == $id_resp) {
                                echo "<option value='$id_resp' selected>$resp</option>";
                            } else {
                                echo "<option value='$id_resp'>$resp</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditResp" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
