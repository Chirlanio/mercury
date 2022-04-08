<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
?>
<span class="endereco" data-endereco="<?php echo URLADM; ?>"></span>
<span class="enderecoList" data-enderecoList="<?php echo URLADM; ?>"></span>
<span class="conteudo" data-conteudo="listar_usuario"></span>

<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Listar Usuários</h2>
            </div>
            <?php
            if ($this->Dados['botao']['cad_usuario']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'cadastrar-usuario/cad-usuario'; ?>">

                        <button class="btn btn-outline-success btn-sm">
                            Cadastrar
                        </button>
                    </a>
                </div>
                <?php
            }
            if ($this->Dados['botao']['cad_usuario_modal']) {
                ?>
                <div class="p-2">
                    <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#addUsuarioModal">
                        Cadastrar Modal
                    </button>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="form-inline" method="POST" action="">
            <div class="col-12 p-0">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="pesqUser"><i class="fa-solid fa-magnifying-glass"></i></label>
                    </div>
                    <input name="pesqUser" type="text" id="pesqUser" class="form-control" aria-describedby="pesqUser" placeholder="Nome ou e-mail do usuário" />
                </div>
            </div>
        </form><hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <span id="conteudo"></span>
    </div>
</div>

<div class="modal fade" id="visulUsuarioModal" tabindex="-1" aria-labelledby="visulUsuarioModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="visulUsuarioModal">Detalhes do Usuário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="visul_usuario"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-info" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Formulário para cadastrar usuários -->
<?php
if ($this->Dados['botao']['cad_usuario_modal']) {
    ?>
    <span class="enderecocad" data-enderecocad="<?php echo URLADM; ?>cadastrar-usuario-modal/cad-usuario"></span>
    <div class="modal fade addModal" id="addUsuarioModal" tabindex="-1" aria-labelledby="addUsuarioModal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUsuarioModal">Cadastrar Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="msgCad"></span>
                    <form method="POST" id="insert_form" class="was-validated" enctype="multipart/form-data">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label><span class="text-danger">*</span> Nome</label>
                                <input name="nome" type="text" class="form-control is-invalid" placeholder="Digite o nome completo" value="<?php
                                if (isset($valorForm['nome'])) {
                                    echo $valorForm['nome'];
                                }
                                ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label><span class="text-danger">*</span> Apelido</label>
                                <input name="apelido" type="text" class="form-control is-invalid" placeholder="Como gostaria de ser chamado" value="<?php
                                if (isset($valorForm['apelido'])) {
                                    echo $valorForm['apelido'];
                                }
                                ?>" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label><span class="text-danger">*</span> E-mail</label>
                                <input name="email" type="text" class="form-control is-invalid" placeholder="Seu melhor e-mail" value="<?php
                                if (isset($valorForm['email'])) {
                                    echo $valorForm['email'];
                                }
                                ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label><span class="text-danger">*</span> Usuário</label>
                                <input name="usuario" type="text" class="form-control is-invalid" id="nome" placeholder="Digite o usuário" value="<?php
                                if (isset($valorForm['usuario'])) {
                                    echo $valorForm['usuario'];
                                }
                                ?>" required>
                            </div>
                            <div class="form-group col-md-2">
                                <label><span class="text-danger">*</span> Senha</label>
                                <input name="senha" type="password" class="form-control is-invalid" id="senha" placeholder="Senha com mínimo 6 caracteres" value="<?php
                                if (isset($valorForm['senha'])) {
                                    echo $valorForm['senha'];
                                }
                                ?>" required autocomplete="false">
                            </div>
                            <div class="form-group col-md-2">
                                <label><span class="text-danger">*</span> Loja</label>
                                <select name="loja_id" id="loja_id" class="form-control is-invalid" required>
                                    <option value="">Selecione</option>
                                    <?php
                                    foreach ($this->Dados['select']['loja'] as $l) {
                                        extract($l);
                                        if (isset($valorForm['loja_id']) == $id_loja) {
                                            echo "<option value='$id_loja' selected>$loja</option>";
                                        } else {
                                            echo "<option value='$id_loja'>$loja</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
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
                            <div class="form-group col-md-6">
                                <label><span class="text-danger">*</span> Situação</label>
                                <select name="adms_sits_usuario_id" id="adms_sits_usuario_id" class="form-control is-invalid" required>
                                    <option value="1">Selecione</option>
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
                        <input name="CadUsuario" id="CadUsuario" type="submit" class="btn btn-warning" value="Salvar">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>

<div class="modal fade addModal" id="addSucessoModal" tabindex="-1" aria-labelledby="addSucessoModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Usuario cadatrado com sucesso!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
if ($this->Dados['botao']['edit_usuario_modal']) {
    ?>
    <span class="enderecoedit" data-enderecoedit="<?php echo URLADM; ?>"></span>
    <div class="modal fade addModal" id="editUsuarioModal" tabindex="-1" aria-labelledby="editUsuarioModal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUsuarioModal">Editar Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="msgEdit"></span>
                    <span id="edit_usuario"></span>

                </div>
            </div>
        </div>
    </div>
    <?php
}
?>