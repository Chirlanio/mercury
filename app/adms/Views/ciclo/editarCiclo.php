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
                <h2 class="display-4 titulo">Editar Ciclo</h2>
            </div>

            <?php
            if ($this->Dados['botao']['vis_ciclo']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'ver-ciclo/ver-ciclo/' . $valorForm['id']; ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
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
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Nome</label>
                    <input name="nome" type="text" class="form-control" placeholder="Nome do ciclo" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Nome</label>
                    <input name="ano" type="number" class="form-control" placeholder="2022" value="<?php
                    if (isset($valorForm['ano'])) {
                        echo $valorForm['ano'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Situação</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] >= 4) {
                        echo '<select name="status_id" id="status_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sit'] as $sol) {
                            extract($sol);
                            if ($valorForm['status_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$s_id'>$sit</option>";
                            }
                        }
                    } else {
                        echo '<select name="status_id" id="status_id" class="form-control">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sit'] as $sol) {
                            extract($sol);
                            if ($valorForm['status_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$s_id'>$sit</option>";
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
            <input name="EditCiclo" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
