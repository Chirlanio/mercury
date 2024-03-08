<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Perfil</h2>
            </div>
            <div class="p-2">
                <a href="<?php echo URLADM . 'ver-perfil-treinamento/perfil'; ?>" class="btn btn-outline-primary btn-sm"><i class='fa-solid fa-eye'></i></a>
            </div>
        </div><hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        if (isset($this->Dados['form'])) {
            $valorForm = $this->Dados['form'];
        }
        if (isset($this->Dados['form'][0])) {
            $valorForm = $this->Dados['form'][0];
        }
        ?>
        <form method="POST" action="" enctype="multipart/form-data"> 
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Nome</label>
                    <input name="nome" type="text" class="form-control" placeholder="Digite o nome completo" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>" <?php echo $_SESSION['adms_niveis_acesso_id'] == 11 ? 'disabled' : ''; ?>>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Usuário</label>
                    <input name="usuario" type="text" class="form-control" id="nome" placeholder="Digite o usuário" value="<?php
                    if (isset($valorForm['usuario'])) {
                        echo $valorForm['usuario'];
                    }
                    ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> E-mail</label>
                    <input name="email" type="text" class="form-control" placeholder="Seu melhor e-mail" value="<?php
                    if (isset($valorForm['email'])) {
                        echo $valorForm['email'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input name="image" type="hidden" value="<?php
                    if (isset($valorForm['image'])) {
                        echo $valorForm['image'];
                    } elseif (isset($valorForm['imagem_nova'])) {
                        echo $valorForm['imagem_nova'];
                    }
                    ?>">

                    <label><span class="text-danger">*</span> Foto (150x150)</label>
                    <input name="imagem_nova" type="file" onchange="previewImagem();">
                </div>
                <div class="form-group col-md-6">
                    <?php
                    if (isset($valorForm['image']) AND (!empty($valorForm['image']))) {
                        $imagem_antiga = URLADM . 'assets/imagens/usuario/treinamento/' . $_SESSION['usuario_id'] . '/' . $_SESSION['usuario_imagem'];
                    } else {
                        $imagem_antiga = URLADM . 'assets/imagens/usuario/preview_img.png';
                    }
                    ?>
                    <img src="<?php echo $imagem_antiga; ?>" alt="Imagem do Usuário" id="preview-user" class="img-thumbnail" style="width: 150px; height: 150px;">
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EdiPerfil" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
