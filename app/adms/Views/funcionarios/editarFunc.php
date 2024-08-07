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
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Cadastro do Funcionário</h2>
            </div>
            <span class="d-none d-md-block">
                <?php
                if ($this->Dados['botao']['list_func']) {
                    echo "<a href='" . URLADM . "funcionarios/listar-func' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i></a> ";
                }
                if ($this->Dados['botao']['vis_func']) {
                    echo "<a href='" . URLADM . "ver-func/ver-func/{$valorForm['id']}' class='btn btn-outline-primary btn-sm'><i class='fa-solid fa-eye'></i></a> ";
                }
                ?>
            </span>

        </div><hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" class="was-validated" enctype="multipart/form-data"> 
            <input name="id" type="hidden" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Nome Completo</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] > FINANCIALPERMITION) {
                        echo '<input name="nome" type="text" class="form-control is-invalid" aria-label="Disabled input" disabled placeholder="Nome completo do Usuário" value="';
                        if (isset($valorForm['nome'])) {
                            echo $valorForm['nome'];
                        }
                        echo '" required>';
                    } else {
                        echo '<input name="nome" type="text" class="form-control is-invalid" placeholder="Nome completo do Usuário" value ="';
                        if (isset($valorForm['nome'])) {
                            echo $valorForm['nome'];
                        }
                        echo '" required>';
                    }
                    ?>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Usuário</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] > FINANCIALPERMITION) {
                        echo '<input name="usuario" type="text" class="form-control is-invalid" aria-label="Disabled input" disabled placeholder="Nome do Usuário" value="';
                        if (isset($valorForm['usuario'])) {
                            echo $valorForm['usuario'];
                        }
                        echo '" required>';
                    } else {
                        echo '<input name="usuario" type="text" class="form-control is-invalid" placeholder="Nome do Usuário" value ="';
                        if (isset($valorForm['usuario'])) {
                            echo $valorForm['usuario'];
                        }
                        echo '" required>';
                    }
                    ?>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span><span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="CPF: Digite somente números, Ex: 12345678912">
                            <i class="fas fa-question-circle"></i>
                        </span> CPF</label>
                    <input name="cpf" id="cpf" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['cpf'])) {
                        echo $valorForm['cpf'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label>Cupom Site</label>
                    <input name="cupom_site" type="text" id="cupom_site" class="form-control is-valid" placeholder="Digite o cupom" value="<?php
                    if (isset($valorForm['cupom_site'])) {
                        echo $valorForm['cupom_site'];
                    }
                    ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Loja</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] > FINANCIALPERMITION) {
                        echo '<select name="loja_id" id="loja_id" class="form-control is-invalid" aria-label="Disabled input" disabled required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['loja_id'] as $l) {
                            extract($l);
                            if ($valorForm['loja_id'] == $id_loja) {
                                echo "<option value='$id_loja' selected>$loja</option>";
                            } else {
                                echo "<option value='$id_loja'>$loja</option>";
                            }
                        }
                    } else {
                        echo '<select name="loja_id" id="loja_id" class="form-control is-invalid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['loja_id'] as $l) {
                            extract($l);
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
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Função</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] > FINANCIALPERMITION) {
                        echo '<select name="cargo_id" id="cargo_id" class="form-control is-invalid" aria-label="Disabled input" disabled required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['cargo_id'] as $c) {
                            extract($c);
                            if ($valorForm['cargo_id'] == $cargo_id) {
                                echo "<option value='$cargo_id' selected>$cargo</option>";
                            } else {
                                echo "<option value='$cargo_id'>$cargo</option>";
                            }
                        }
                    } else {
                        echo '<select name="cargo_id" id="cargo_id" class="form-control is-invalid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['cargo_id'] as $c) {
                            extract($c);
                            if ($valorForm['cargo_id'] == $cargo_id) {
                                echo "<option value='$cargo_id' selected>$cargo</option>";
                            } else {
                                echo "<option value='$cargo_id'>$cargo</option>";
                            }
                        }
                    }
                    ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Área</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] > FINANCIALPERMITION) {
                        echo '<select name="adms_area_id" id="adms_area_id" class="form-control is-invalid" aria-label="Disabled input" disabled required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['areas'] as $area) {
                            extract($area);
                            if ($valorForm['adms_area_id'] == $area_id) {
                                echo "<option value='$area_id' selected>$name_area</option>";
                            } else {
                                echo "<option value='$area_id'>$name_area</option>";
                            }
                        }
                    } else {
                        echo '<select name="adms_area_id" id="adms_area_id" class="form-control is-invalid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['areas'] as $area) {
                            extract($area);
                            if ($valorForm['adms_area_id'] == $area_id) {
                                echo "<option value='$area_id' selected>$name_area</option>";
                            } else {
                                echo "<option value='$area_id'>$name_area</option>";
                            }
                        }
                    }
                    ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span>Situação</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] > FINANCIALPERMITION) {
                        echo '<select name="status_id" id="status_id" class="form-control is-invalid" aria-label="Disabled input" disabled required>';
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
                        echo '<select name="status_id" id="status_id" class="form-control is-invalid" required>';
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
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditFunc" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
