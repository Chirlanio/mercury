<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Divergências</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_balanco']) {
                ?>
                <div class="p-2">
                    <a href='<?php echo URLADM . "balanco-produto/listar/?id=" . $_SESSION['id']; ?>' class="btn btn-outline-info btn-sm"><i class='fas fa-list d-block d-md-none fa-2x'></i> <span class='d-none d-md-block'>Listar</span></a>
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
                <div class = "form-group col-md-3">
                    <label><span class = "text-danger">*</span> Balanço</label>
                    <select name="balanco_id" id="balanco_id" class="custom-select is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['b_id'] as $l) {
                            extract($l);
                            if (!empty($_SESSION['id'])) {
                                if ($_SESSION['id'] == $b_id) {
                                    echo "<option value='$b_id' selected>$loja - $ciclo - $ano</option>";
                                } else {
                                    echo "<option value='$b_id'>$loja - $ciclo - $ano</option>";
                                }
                            } else {
                                if ($valorForm['balanco_id'] == $b_id) {
                                    echo "<option value='$b_id' selected>$loja - $ciclo - $ano</option>";
                                } else {
                                    echo "<option value='$b_id'>$loja - $ciclo - $ano</option>";
                                }
                                echo "<option value='$b_id' selected>$loja - $ciclo - $ano</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Referência</label>
                    <input name="referencia" type="text" class="form-control is-invalid" placeholder="A0376266800080" value="<?php
                    if (isset($valorForm['referencia'])) {
                        echo strtoupper($valorForm['referencia']);
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Código de Barras</label>
                    <input name="cod_barras" type="text" class="form-control is-invalid" placeholder="7909634452266" value="<?php
                    if (isset($valorForm['cod_barras'])) {
                        echo $valorForm['cod_barras'];
                    }
                    ?>" required>
                </div>
                <div class = "form-group col-md-1">
                    <label><span class = "text-danger">*</span> Tamanho</label>
                    <select name="tam_id" id="tam_id" class="custom-select is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['tam_id'] as $l) {
                            extract($l);
                            if (isset($valorForm['tam_id']) and $valorForm['tam_id'] == $id_tam) {
                                echo "<option value='$id_tam' selected>$tam</option>";
                            } else {
                                echo "<option value='$id_tam'>$tam</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-1">
                    <label><span class="text-danger">*</span> Estoque</label>
                    <input name="qtde_estoque" type="number" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['qtde_estoque'])) {
                        echo $valorForm['qtde_estoque'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-1">
                    <label><span class="text-danger">*</span> Contagem</label>
                    <input name="qtde_contagem" type="number" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['qtde_contagem'])) {
                        echo $valorForm['qtde_contagem'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-1">
                    <label><span class="text-danger">*</span> Divergência</label>
                    <input name="qtde_divergencia" type="number" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['qtde_divergencia'])) {
                        echo $valorForm['qtde_divergencia'];
                    }
                    ?>" required>
                </div>
                <div class = "form-group col-md-1">
                    <label><span class = "text-danger">*</span> Tipo</label>
                    <select name="tipo" id="tipo" class="custom-select is-invalid" required>
                        <?php
                        if (isset($valorForm['tipo']) and $valorForm['tipo'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Sobra</option>";
                            echo "<option value='2'>Falta</option>";
                        } elseif (isset($valorForm['tipo']) and $valorForm['tipo'] == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Sobra</option>";
                            echo "<option value='2' selected>Falta</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Sobra</option>";
                            echo "<option value='2'>Falta</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="situacao" id="situacao" class="custom-select is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sit_prod'] as $c) {
                            extract($c);
                            if (isset($valorForm['situacao']) and $valorForm['situacao'] == $j_id) {
                                echo "<option value='$j_id' selected>$situacao</option>";
                            } else {
                                echo "<option value='$j_id'>$situacao</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Solução</label>
                    <input name="solucao" type="text" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['solucao'])) {
                        echo $valorForm['solucao'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Status</label>
                    <select name="status_id" id="status_id" class="custom-select is-invalid" required>
                        <option value = "">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sit'] as $c) {
                            extract($c);
                            if (isset($valorForm['status_id']) and $valorForm['status_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$s_id'>$sit</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Observação</label>
                    <textarea name="obs_resposta" id="editor" class="form-control is-invalid editorCK" rows="3" required><?php
                        if (isset($valorForm['obs_resposta'])) {
                            echo $valorForm['obs_resposta'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadBalanco" type="submit" class="btn btn-success" value="Cadastrar">
        </form>
    </div>
</div>
