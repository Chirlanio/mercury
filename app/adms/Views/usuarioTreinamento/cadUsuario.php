<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['select']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Usuário</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_usuario']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'usuarios-treinamento/listar'; ?>" class="btn btn-outline-info btn-sm"><i class='fa-solid fa-list'></i></a>
                </div>
                <?php
            }
            ?>
        </div>
        <hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" class="was-validated" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Nome</label>
                    <input name="nome" type="text" class="form-control is-invalid" placeholder="Digite o nome completo" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>" required autofocus>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Usuário</label>
                    <input name="usuario" type="text" class="form-control is-invalid" placeholder="Como gostaria de ser chamado" value="<?php
                    if (isset($valorForm['usuario'])) {
                        echo $valorForm['usuario'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> E-mail</label>
                    <input name="email" type="text" class="form-control is-invalid" placeholder="E-mail" value="<?php
                    if (isset($valorForm['email'])) {
                        echo $valorForm['email'];
                    }
                    ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> CPF</label>
                    <input name="cpf" type="text" id="cpf" class="form-control is-invalid" placeholder="CPF" value="<?php
                    if (isset($valorForm['cpf'])) {
                        echo $valorForm['cpf'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Senha</label>
                    <input name="senha" type="password" class="form-control is-invalid" id="senha" autocomplete="off" placeholder="Senha com mínimo 6 caracteres" value="<?php
                    if (isset($valorForm['senha'])) {
                        echo $valorForm['senha'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Nível de Acesso</label>
                    <select name="adms_niveis_acesso_id" id="adms_niveis_acesso_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['nivac'] as $nivac) {
                            extract($nivac);
                            if ($valorForm['adms_niveis_acesso_id'] == $id_nivac) {
                                echo "<option value='$id_nivac' selected>$nome_nivac</option>";
                            } else {
                                echo "<option value='$id_nivac'>$nome_nivac</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="adms_sits_usuario_id" id="adms_sits_usuario_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sit'] as $sit) {
                            extract($sit);
                            if ($valorForm['adms_sits_usuario_id'] == $id_sit) {
                                echo "<option value='$id_sit' selected>$nome_sit</option>";
                            } else {
                                echo "<option value='$id_sit'>$nome_sit</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Foto (150x150)</label>
                    <input name="imagem_nova" type="file" onchange="previewImagem();">
                </div>
                <div class="form-group col-md-6">
                    <?php
                    $imagem_antiga = URLADM . 'assets/imagens/usuario/preview_img.png';
                    ?>
                    <img src="<?php echo $imagem_antiga; ?>" alt="Imagem do Usuário" id="preview-user" class="img-thumbnail" style="width: 150px; height: 150px;">
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadUsuario" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
