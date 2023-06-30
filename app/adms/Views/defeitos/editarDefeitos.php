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
                <h2 class="display-4 titulo">Editar Defeitos</h2>
            </div>

            <?php
            if ($this->Dados['botao']['vis_defeitos']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'ver-defeitos/ver-defeitos/' . $valorForm['id']; ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
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
                <div class="form-group col-md-9">
                    <label><span class="text-danger">* </span>Descrição</label>
                    <input name="descricao" class="form-control" value="<?php
                    if (isset($valorForm['descricao'])) {
                        echo $valorForm['descricao'];
                    }
                    ?>">
                </div>
                
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span>Situação</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > 2) {
                        echo '<select name="status_id" id="status_id" class="custom-select is-invalid" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sit'] as $st) {
                            extract($st);
                            if ($valorForm['status_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$s_id'>$sit</option>";
                            }
                        }
                    } else {
                        echo '<select name="status_id" id="sit_id" class="form-control">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sit'] as $st) {
                            extract($st);
                            if ($valorForm['status_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$s_id'>$sit</option>";
                            }
                        }
                    }
                    ?>
                    </select>
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditDefeitos" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
