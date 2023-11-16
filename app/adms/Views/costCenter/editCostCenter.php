<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['select']['areas']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Centro de Custo</h2>
            </div>

            <?php
            if ($this->Dados['botao']['view_cost']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'view-cost-center/cost-center/' . $valorForm['c_id']; ?>" class="btn btn-outline-primary btn-sm"><i class='fas fa-eye'></i> Visualizar</a>
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
            if (isset($valorForm['c_id'])) {
                echo $valorForm['c_id'];
            }
            ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Id Centro de Custo</label>
                    <input name="cost_center_id" id="cost_center_id" type="text" class="form-control" placeholder="0.0.0.0000" value="<?php
                    if (isset($valorForm['cost_center_id'])) {
                        echo $valorForm['cost_center_id'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Centro de Custo</label>
                    <input name="name"  type="text" class="form-control" placeholder="Nome do centro de custo" value="<?php
                    if (isset($valorForm['costCenter'])) {
                        echo $valorForm['costCenter'];
                    }
                    ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Responsável</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > ADMPERMITION) {
                        echo '<select name="manager_id" id="manager_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['resp'] as $resp) {
                            extract($resp);
                            if ($valorForm['manager_id'] == $f_id) {
                                echo "<option value='$f_id' selected>$gerencia</option>";
                            } else {
                                echo "<option value='$f_id'>$gerencia</option>";
                            }
                        }
                    } else {
                        echo '<select name="manager_id" id="manager_id" class="form-control">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['resp'] as $resp) {
                            extract($resp);
                            if ($valorForm['manager_id'] == $f_id) {
                                echo "<option value='$f_id' selected>$gerencia</option>";
                            } else {
                                echo "<option value='$f_id'>$gerencia</option>";
                            }
                        }
                    }
                    echo "</select>";
                    ?>
                </div>

                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Área</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > ADMPERMITION) {
                        echo '<select name="adms_area_id" id="adms_area_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['areas'] as $area) {
                            extract($area);
                            if ($valorForm['adms_area_id'] == $a_id) {
                                echo "<option value='$a_id' selected>$name_area</option>";
                            } else {
                                echo "<option value='$a_id'>$name_area</option>";
                            }
                        }
                    } else {
                        echo '<select name="adms_area_id" id="adms_area_id" class="form-control">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['areas'] as $area) {
                            extract($area);
                            if ($valorForm['adms_area_id'] == $a_id) {
                                echo "<option value='$a_id' selected>$name_area</option>";
                            } else {
                                echo "<option value='$a_id'>$name_area</option>";
                            }
                        }
                    }
                    echo "</select>";
                    ?>
                </div>

                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Situação</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > ADMPERMITION) {
                        echo '<select name="status_id" id="status_id" class="form-control" aria-label="Disabled input" disabled>';
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
                        echo '<select name="status_id" id="status_id" class="form-control">';
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
            <input name="EditCostCenter" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
