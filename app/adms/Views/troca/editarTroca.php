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
                <h2 class="display-4 titulo">Editar Solicitação de Cadastro</h2>
            </div>
            <?php
            if ($this->Dados['botao']['vis_troca']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'listar-troca/listar-troca/'; ?>" class="btn btn-outline-primary btn-sm">Listar</a>
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
                    <label><span class="text-danger">*</span> Nome</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > 2) {
                        echo '<select name="func_id" id="func_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['func_id'] as $consul) {
                            extract($consul);
                            if ($valorForm['func_id'] == $func_id) {
                                echo "<option value='$func_id' selected>$consul</option>";
                            } else {
                                echo "<option value='$func_id'>$consul</option>";
                            }
                        }
                    } else {
                        echo '<select name="func_id" id="func_id" class="form-control">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['func_id'] as $consul) {
                            extract($consul);
                            if ($valorForm['func_id'] == $func_id) {
                                echo "<option value='$func_id' selected>$consul</option>";
                            } else {
                                echo "<option value='$func_id'>$consul</option>";
                            }
                        }
                    }
                    echo '</select>';
                    ?>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Loja</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > 2) {
                        echo '<select name="loja_id" id="loja_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['loja_id'] as $loja) {
                            extract($loja);
                            if ($valorForm['loja_id'] == $id_loja) {
                                echo "<option value='$id_loja' selected>$loja</option>";
                            } else {
                                echo "<option value='$id_loja'>$loja</option>";
                            }
                        }
                    } else {
                        echo '<select name="loja_id" id="loja_id" class="form-control">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['loja_id'] as $loja) {
                            extract($loja);
                            if ($valorForm['loja_id'] == $id_loja) {
                                echo "<option value='$id_loja' selected>$loja</option>";
                            } else {
                                echo "<option value='$id_loja'>$loja</option>";
                            }
                        }
                    }
                    echo '</select>';
                    ?>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > 2) {
                        if ($valorForm['sit_id'] == 3) {
                            echo "<label><span class='text-danger'>*</span> Referência</label>";
                            echo "<input name='referencia' type='text' class='form-control' placeholder='Referência' value='";
                            if (isset($valorForm['referencia'])) {
                                echo $valorForm['referencia'];
                            }
                            echo "'>";
                        } else {
                            echo "<label><span class='text-danger'>*</span> Referência</label>";
                            echo "<input name='referencia' type='text' class='form-control' placeholder='Referência' aria-label='Disabled input' disabled value='";
                            if (isset($valorForm['referencia'])) {
                                echo $valorForm['referencia'];
                            }
                            echo "'>";
                        }
                    } else {
                        echo "<label><span class='text-danger'>*</span> Referência</label>";
                        echo "<input name='referencia' type='text' class='form-control' placeholder='Referência' value='";
                        if (isset($valorForm['referencia'])) {
                            echo $valorForm['referencia'];
                        }
                        echo "'>";
                    }
                    ?>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Motivo</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > 2) {
                        echo '<select name="motivo_id" id="motivo_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['motivo_id'] as $sit) {
                            extract($sit);
                            if ($valorForm['motivo_id'] == $motivo_id) {
                                echo "<option value='$motivo_id' selected>$motivo</option>";
                            } else {
                                echo "<option value='$motivo_id'>$motivo</option>";
                            }
                        }
                    } else {
                        echo '<select name="motivo_id" id="motivo_id" class="form-control">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['motivo_id'] as $sit) {
                            extract($sit);
                            if ($valorForm['motivo_id'] == $motivo_id) {
                                echo "<option value='$motivo_id' selected>$motivo</option>";
                            } else {
                                echo "<option value='$motivo_id'>$motivo</option>";
                            }
                        }
                    }
                    echo '</select>';
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
                    echo '</select>';
                    ?>
                </div>
            </div>
            <input name="modified" type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>">
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditTroca" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
