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
                <h2 class="display-4 titulo">Editar Rota</h2>
            </div>

            <?php
            if ($this->Dados['botao']['vis_rota']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'ver-rota/ver-rota/' . $valorForm['r_id']; ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
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
            if (isset($valorForm['r_id'])) {
                echo $valorForm['r_id'];
            }
            ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Nome</label>
                    <input name="nome" type="text" class="form-control" placeholder="Nome da rota" value="<?php
                    if (isset($valorForm['rota'])) {
                        echo $valorForm['rota'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Cor</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > 2) {
                        echo '<select name="adms_cor_id" id="adms_cor_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['cor'] as $s) {
                            extract($s);
                            if ($valorForm['cor_id'] == $cor_id) {
                                echo "<option value='$cor_id' selected>$n_cor</option>";
                            } else {
                                echo "<option value='$cor_id'>$n_cor</option>";
                            }
                        }
                    } else {
                        echo '<select name="adms_cor_id" id="adms_cor_id" class="form-control">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['cor'] as $s) {
                            extract($s);
                            if ($valorForm['cor_id'] == $cor_id) {
                                echo "<option value='$cor_id' selected>$n_cor</option>";
                            } else {
                                echo "<option value='$cor_id'>$n_cor</option>";
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
            <input name="EditRota" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
