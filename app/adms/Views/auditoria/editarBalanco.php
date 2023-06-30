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
                <h2 class="display-4 titulo">Editar Balanço</h2>
            </div>
            <?php
            if ($this->Dados['botao']['vis_balanco']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'ver-balanco/ver-balanco/' . $valorForm['id']; ?>" class="btn btn-outline-primary btn-sm"><i class='fas fa-eye d-block d-md-none fa-2x'></i> <span class='d-none d-md-block'>Visualizar</span></a>
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
                    <label><span class="text-danger">*</span> Loja</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > 2) {
                        echo '<select name="loja_id" id="loja_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['loja_id'] as $loja) {
                            extract($loja);
                            if ($valorForm['loja_id'] == $loja_id) {
                                echo "<option value='$loja_id' selected>$loja</option>";
                            } else {
                                echo "<option value='$loja_id'>$loja</option>";
                            }
                        }
                    } else {
                        echo '<select name="loja_id" id="loja_id" class="form-control">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['loja_id'] as $loja) {
                            extract($loja);
                            if ($valorForm['loja_id'] == $loja_id) {
                                echo "<option value='$loja_id' selected>$loja</option>";
                            } else {
                                echo "<option value='$loja_id'>$loja</option>";
                            }
                        }
                    }
                    ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Ciclo</label>
                    <select name="ciclo_id" id="ciclo_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['ciclo'] as $cl) {
                            extract($cl);
                            if ($valorForm['ciclo_id'] == $c_id) {
                                echo "<option value='$c_id' selected>$ciclo</option>";
                            } else {
                                echo "<option value='$c_id'>$ciclo</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Responsável</label>
                    <select name="responsavel_loja_id" id="responsavel_loja_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['func_id'] as $consul) {
                            extract($consul);
                            if ($valorForm['responsavel_loja_id'] == $resp_loja_id) {
                                echo "<option value='$resp_loja_id' selected>$resp_loja</option>";
                            } else {
                                echo "<option value='$resp_loja_id'>$resp_loja</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Auditor</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > 2) {
                        echo '<select name="responsavel_auditoria_id" id="responsavel_auditoria_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['resp'] as $loja) {
                            extract($loja);
                            if ($valorForm['responsavel_auditoria_id'] == $r_id) {
                                echo "<option value='$r_id' selected>$resp_aud</option>";
                            } else {
                                echo "<option value='$r_id'>$resp_aud</option>";
                            }
                        }
                    } else {
                        echo '<select name="responsavel_auditoria_id" id="responsavel_auditoria_id" class="form-control">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['resp'] as $loja) {
                            extract($loja);
                            if ($valorForm['responsavel_auditoria_id'] == $r_id) {
                                echo "<option value='$r_id' selected>$resp_aud</option>";
                            } else {
                                echo "<option value='$r_id'>$resp_aud</option>";
                            }
                        }
                    }
                    echo "</select>";
                    ?>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Situação</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > 2) {
                        echo '<select name="status_id" id="status_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sit_id'] as $sit) {
                            extract($sit);
                            if ($valorForm['sit_id'] == $sit_id) {
                                echo "<option value='$sit_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$sit_id'>$sit</option>";
                            }
                        }
                    } else {
                        echo '<select name="status_id" id="status_id" class="form-control">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sit_id'] as $sit) {
                            extract($sit);
                            if ($valorForm['sit_id'] == $sit_id) {
                                echo "<option value='$sit_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$sit_id'>$sit</option>";
                            }
                        }
                    }
                    ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Observação</label>
                    <textarea name="obs" id="editor" class="form-control editorCK" rows="3"><?php
                        if (isset($valorForm['obs'])) {
                            echo $valorForm['obs'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditBalanco" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
