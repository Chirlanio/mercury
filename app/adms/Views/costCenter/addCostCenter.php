<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['select']['resp']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Centro de Custo</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_cost']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'cost-centers/list'; ?>" class="btn btn-outline-info btn-sm"><i class="fa-solid fa-list"></i> Listar</a>
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
                    <label><span class="text-danger">*</span> ID Centro de custo</label>
                    <input name="cost_center_id" type="text" class="form-control is-invalid cost_center" placeholder="3.2.1.00000" value="<?php
                    if (isset($valorForm['cost_center_id'])) {
                        echo $valorForm['cost_center_id'];
                    }
                    ?>" required autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Centro de custo</label>
                    <input name="name" type="text" class="form-control is-invalid" placeholder="Nome do centro de custo" value="<?php
                    if (isset($valorForm['name'])) {
                        echo $valorForm['name'];
                    }
                    ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Responsável</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5) {
                        echo '<select name="manager_id" id="manager_id" class="form-control is-invalid" aria-label="Disabled input" disabled required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['resp'] as $res) {
                            extract($res);
                            if ($valorForm['manager_id'] == $r_id) {
                                echo "<option value='$r_id' selected>$responsavel</option>";
                            } else {
                                echo "<option value='$r_id'>$responsavel</option>";
                            }
                        }
                    } else {
                        echo '<select name="manager_id" id="manager_id" class="form-control is-invalid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['resp'] as $sol) {
                            extract($sol);
                            if ($valorForm['manager_id'] == $r_id) {
                                echo "<option value='$r_id' selected>$responsavel</option>";
                            } else {
                                echo "<option value='$r_id'>$responsavel</option>";
                            }
                        }
                    }
                    echo "</select>";
                    ?>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Situação</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5) {
                        echo '<select name="status_id" id="status_id" class="form-control is-invalid" aria-label="Disabled input" disabled required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sits'] as $sit) {
                            extract($sit);
                            if ($valorForm['status_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$status</option>";
                            } else {
                                echo "<option value='$s_id'>$status</option>";
                            }
                        }
                    } else {
                        echo '<select name="status_id" id="status_id" class="form-control is-invalid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sits'] as $sit) {
                            extract($sit);
                            if ($valorForm['status_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$status</option>";
                            } else {
                                echo "<option value='$s_id'>$status</option>";
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
            <input name="AddCostCenter" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
