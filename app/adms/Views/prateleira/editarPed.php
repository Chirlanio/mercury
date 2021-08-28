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
                <h2 class="display-4 titulo">Editar Pedidos - Prateleira Infinita</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_ped']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'prateleira-infinita/listar'; ?>" class="btn btn-outline-info btn-sm">Listar</a>
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
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Referência</label>
                    <?php
                    if ($valorForm['sit_id'] == 2) {
                        echo '<input name="referencia" type="text" class="form-control" aria-label="Disabled input" disabled placeholder="Digite a referência completa" value="';
                        if (isset($valorForm['referencia'])) {
                            echo $valorForm['referencia'];
                        }
                        echo '">';
                    } else {
                        echo '<input name="referencia" type="text" class="form-control" placeholder="Digite a referência completa" value ="';
                        if (isset($valorForm['referencia'])) {
                            echo $valorForm['referencia'];
                        }
                        echo '">';
                    }
                    ?>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Tamanho</label>
                    <?php
                    if ($valorForm['sit_id'] == 2) {
                        echo '<select name="tam_id" id="tam_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['tam'] as $t) {
                            extract($t);
                            if ($valorForm['tam_id'] == $tam_id) {
                                echo "<option value='$tam_id' selected>$tam</option>";
                            } else {
                                echo "<option value='$tam_id'>$tam</option>";
                            }
                        }
                        echo "</select>";
                    } else {
                        echo '<select name="tam_id" id="tam_id" class="form-control">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['tam'] as $t) {
                            extract($t);
                            if ($valorForm['tam_id'] == $tam_id) {
                                echo "<option value='$tam_id' selected>$tam</option>";
                            } else {
                                echo "<option value='$tam_id'>$tam</option>";
                            }
                        }
                        echo "</select>";
                    }
                    ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label><span class = "text-danger">*</span> Loja</label>
                    <?php
                    if ($valorForm['sit_id'] == 2) {
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
                        echo "</select>";
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
                        echo "</select>";
                    }
                    ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Solicitante</label>
                    <?php
                    if ($valorForm['sit_id'] == 2) {
                        echo '<select name="func_id" id="func_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['func'] as $f) {
                            extract($f);
                            if ($valorForm['func_id'] == $id_func) {
                                echo "<option value='$id_func' selected>$func</option>";
                            } else {
                                echo "<option value='$id_func'>$func</option>";
                            }
                        }
                        echo "</select>";
                    } else {
                        echo '<select name="func_id" id="func_id" class="form-control">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['func'] as $f) {
                            extract($f);
                            if ($valorForm['func_id'] == $id_func) {
                                echo "<option value='$id_func' selected>$func</option>";
                            } else {
                                echo "<option value='$id_func'>$func</option>";
                            }
                        }
                        echo "</select>";
                    }
                    ?>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> NF - Transferência</label>
                    <?php
                    if ($valorForm['sit_id'] == 2) {
                        echo '<input name="nf_transf" type="text" class="form-control" aria-label="Disabled input" disabled placeholder="Digite a referência completa" value="';
                        if (isset($valorForm['nf_transf'])) {
                            echo $valorForm['nf_transf'];
                        }
                        echo '">';
                    } else {
                        echo '<input name="nf_transf" type="text" class="form-control" placeholder="Digite a referência completa" value ="';
                        if (isset($valorForm['nf_transf'])) {
                            echo $valorForm['nf_transf'];
                        }
                        echo '">';
                    }
                    ?>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> NF - Venda</label>
                    <?php
                    if ($valorForm['sit_id'] == 2) {
                        echo '<input name="nf_venda" type="text" class="form-control" aria-label="Disabled input" disabled placeholder="Digite a referência completa" value="';
                        if (isset($valorForm['nf_venda'])) {
                            echo $valorForm['nf_venda'];
                        }
                        echo '">';
                    } else {
                        echo '<input name="nf_venda" type="text" class="form-control" placeholder="Digite a referência completa" value ="';
                        if (isset($valorForm['nf_venda'])) {
                            echo $valorForm['nf_venda'];
                        }
                        echo '">';
                    }
                    ?>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Situação</label>
                    <?php
                    if ($valorForm['sit_id'] == 2) {
                        echo '<select name="status_id" id="status_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sit'] as $sit) {
                            extract($sit);
                            if ($valorForm['sit_id'] == $sit_id) {
                                echo "<option value='$sit_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$sit_id'>$sit</option>";
                            }
                        }
                        echo "</select>";
                    } else {
                        echo '<select name="status_id" id="sit_id" class="form-control">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sit'] as $sit) {
                            extract($sit);
                            if ($valorForm['sit_id'] == $sit_id) {
                                echo "<option value='$sit_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$sit_id'>$sit</option>";
                            }
                        }
                        echo "</select>";
                    }
                    ?>
                </div>
            </div>
            <input name="modified" type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>">
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditPed" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
