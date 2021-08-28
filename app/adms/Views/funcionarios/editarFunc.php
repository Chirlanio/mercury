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
                <h2 class="display-4 titulo">Editar Cadastro do Funcionário</h2>
            </div>

            <?php
            if ($this->Dados['botao']['vis_func']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'ver-func/ver-func/' . $valorForm['id']; ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
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
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Nome Completo</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] >= 4) {
                        echo '<input name="nome" type="text" class="form-control" aria-label="Disabled input" disabled placeholder="Nome completo do Usuário" value="';
                        if (isset($valorForm['nome'])) {
                            echo $valorForm['nome'];
                        }
                        echo '">';
                    } else {
                        echo '<input name="nome" type="text" class="form-control" placeholder="Nome completo do Usuário" value ="';
                        if (isset($valorForm['nome'])) {
                            echo $valorForm['nome'];
                        }
                        echo '">';
                    }
                    ?>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Usuário</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] >= 4) {
                        echo '<input name="usuario" type="text" class="form-control" aria-label="Disabled input" disabled placeholder="Nome do Usuário" value="';
                        if (isset($valorForm['usuario'])) {
                            echo $valorForm['usuario'];
                        }
                        echo '">';
                    } else {
                        echo '<input name="usuario" type="text" class="form-control" placeholder="Nome do Usuário" value ="';
                        if (isset($valorForm['usuario'])) {
                            echo $valorForm['usuario'];
                        }
                        echo '">';
                    }
                    ?>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span><span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="CPF: Digite somente números, Ex: 12345678912">
                            <i class="fas fa-question-circle"></i>
                        </span> CPF</label>
                    <input name="cpf" class="form-control" value="<?php
                    if (isset($valorForm['cpf'])) {
                        echo $valorForm['cpf'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Loja</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] >= 4) {
                        echo '<select name="loja_id" id="loja_id" class="form-control" aria-label="Disabled input" disabled>';
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
                        echo '<select name="loja_id" id="loja_id" class="form-control">';
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
                    if ($_SESSION['adms_niveis_acesso_id'] >= 4) {
                        echo '<select name="cargo_id" id="cargo_id" class="form-control" aria-label="Disabled input" disabled>';
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
                        echo '<select name="cargo_id" id="cargo_id" class="form-control">';
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
            </div>

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span>Situação</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] >= 4) {
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
            <input name="modified" type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>">
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditFunc" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
