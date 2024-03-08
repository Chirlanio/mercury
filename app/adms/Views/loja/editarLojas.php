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
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Cadastro de Lojas</h2>
            </div>
            <span class="d-none d-md-block">
                <?php
                if ($this->Dados['botao']['list_loja']) {
                    echo "<a href='" . URLADM . "lojas/listar-lojas' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i></a> ";
                }
                if ($this->Dados['botao']['vis_loja']) {
                    echo "<a href='" . URLADM . "ver-loja/ver-loja/{$valorForm['id']}' class='btn btn-outline-primary btn-sm'><i class='fa-solid fa-eye'></i></a> ";
                }
                ?>
            </span>

        </div>
        <hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" class="was-validated" enctype="multipart/form-data"> 
            <input name="id_loja" type="hidden" value="<?php
            if (isset($valorForm['id_loja'])) {
                echo $valorForm['id_loja'];
            }
            ?>">
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Código da Loja</label>
                    <input name="id" type="text" class="form-control is-invalid" placeholder="Código da loja" value="<?php
                    if (isset($valorForm['id'])) {
                        echo $valorForm['id'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-10">
                    <label><span class="text-danger">*</span> Nome da Loja</label>
                    <input name="nome" type="text" class="form-control is-invalid" placeholder="Nome da Loja a ser apresentado no menu" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> CNPJ</label>
                    <input name="cnpj" type="text" id="cnpj" class="form-control is-invalid" placeholder="00.000.000/0000-00" value="<?php
                    if (isset($valorForm['cnpj'])) {
                        echo $valorForm['cnpj'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Razão Social</label>
                    <input name="razao_social" type="text" class="form-control is-invalid" placeholder="Ex: MEIA SOLA ACESSORIOS DE MODA" value="<?php
                    if (isset($valorForm['razao_social'])) {
                        echo $valorForm['razao_social'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Supervisão</label>
                    <select name="super_id" id="super_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['super_id'] as $re) {
                            extract($re);
                            if ($valorForm['super_id'] == $super_id) {
                                echo "<option value='$super_id' selected>$super</option>";
                            } else {
                                echo "<option value='$super_id'>$super</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Inscrição Estadual</label>
                    <input name="ins_estadual" type="text" id="inscricao_estadual" class="form-control is-invalid" placeholder="Digite somente números" value="<?php
                    if (isset($valorForm['ins_estadual'])) {
                        echo $valorForm['ins_estadual'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-10">
                    <label><span class="text-danger">*</span> Endereço</label>
                    <input name="endereco" type="text" class="form-control is-invalid" placeholder="Avenida Dom Manuel, 621 Centro Fortaleza - CE" value="<?php
                    if (isset($valorForm['endereco'])) {
                        echo $valorForm['endereco'];
                    }
                    ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Rede</label>
                    <select name="rede_id" id="adms_sits_pg_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['rede'] as $re) {
                            extract($re);
                            if ($valorForm['rede_id'] == $id_rede) {
                                echo "<option value='$id_rede' selected>$rede</option>";
                            } else {
                                echo "<option value='$id_rede'>$rede</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Gerente</label>
                    <select name="func_id" id="func_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['func_id'] as $re) {
                            extract($re);
                            if ($valorForm['func_id'] == $func_id) {
                                echo "<option value='$func_id' selected>$func</option>";
                            } else {
                                echo "<option value='$func_id'>$func</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="status_id" id="adms_sits_pg_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sit'] as $s) {
                            extract($s);
                            if ($valorForm['status_id'] == $id_sit) {
                                echo "<option value='$id_sit' selected>$sit</option>";
                            } else {
                                echo "<option value='$id_sit'>$sit</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditLoja" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
