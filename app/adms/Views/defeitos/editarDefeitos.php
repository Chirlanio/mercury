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
                <h2 class="display-4 titulo">Editar Dashboard</h2>
            </div>

            <?php
            if ($this->Dados['botao']['vis_dash']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'ver-dashboard/ver-dashboard/' . $valorForm['id']; ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
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
                    <label><span class="text-danger">*</span>Nome</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > 2) {
                        echo '<input name="nome" type="text" class="form-control" aria-label="Disabled input" disabled placeholder="Nome do dashboard" value="';
                        if (isset($valorForm['nome'])) {
                            echo $valorForm['nome'];
                        }
                        echo '">';
                    } else {
                        echo '<input name="nome" type="text" class="form-control" placeholder="Nome do dashboard" value ="';
                        if (isset($valorForm['nome'])) {
                            echo $valorForm['nome'];
                        }
                        echo '">';
                    }
                    ?>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span>Descrição</label>
                    <input name="descricao" class="form-control" value="<?php
                    if (isset($valorForm['descricao'])) {
                        echo $valorForm['descricao'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span>Área</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > 2) {
                        echo '<select name="area_id" id="area_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['area_id'] as $area) {
                            extract($area);
                            if ($valorForm['area_id'] == $area_id) {
                                echo "<option value='$area_id' selected>$area</option>";
                            } else {
                                echo "<option value='$area_id'>$area</option>";
                            }
                        }
                    } else {
                        echo '<select name="area_id" id="area_id" class="form-control">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['area_id'] as $area) {
                            extract($area);
                            if ($valorForm['area_id'] == $area_id) {
                                echo "<option value='$area_id' selected>$area</option>";
                            } else {
                                echo "<option value='$area_id'>$area</option>";
                            }
                        }
                    }
                    ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span>Loja</label>
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
                        echo '<select name="loja_id" id="area_id" class="form-control">';
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
                    ?>
                    </select>
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-md-9">
                    <label><span class="text-danger">*</span>Link</label>
                    <input name="link" type="text" class="form-control" placeholder="link do dashboard" value="<?php
                    if (isset($valorForm['link'])) {
                        echo $valorForm['link'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span>Situação</label>
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
                        echo '<select name="status_id" id="sit_id" class="form-control">';
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

            <input name="modified" type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>">
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditDash" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
