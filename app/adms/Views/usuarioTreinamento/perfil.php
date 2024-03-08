<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Perfil</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-md-block">
                    <a href="<?php echo URLADM . 'editar-perfil-treinamento/alt-perfil'; ?>" class="btn btn-outline-warning btn-sm"><i class="fa-solid fa-pen-nib"></i></a>
                    <a href="<?php echo URLADM . 'alterar-senha-treinamento/alt-senha'; ?>" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-key"></i></a>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">    
                        <a class="dropdown-item" href="<?php echo URLADM . 'editar-perfil-treinamento/alt-perfil'; ?>">Editar</a>
                        <a class="dropdown-item" href="<?php echo URLADM . 'alterar-senha-treinamento/alt-senha'; ?>">Editar a Senha</a>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <dl class="row">
            <?php
            if (!empty($this->Dados['dados_perfil'][0])) {
                extract($this->Dados['dados_perfil'][0]);
                ?>
                <dt class="col-sm-2">Foto</dt>
                <dd class="col-sm-10">                    
                    <?php
                    if (!empty($_SESSION['usuario_imagem'])) {
                        echo "<img class='imagem img-thumbnail' src='" . URLADM . "assets/imagens/usuario/treinamento/" . $_SESSION['usuario_id'] . "/" . $_SESSION['usuario_imagem'] . "' alt='Foto do usuário'>";
                    } else {
                        echo "<img class='imagem img-thumbnail' src='" . URLADM . "assets/imagens/usuario/icone_usuario.png' alt='Foto do usuário'>";
                    }
                    ?>
                </dd>

                <dt class="col-sm-2">ID</dt>
                <dd class="col-sm-10"><?php echo $id; ?></dd>

                <dt class="col-sm-2">Nome</dt>
                <dd class="col-sm-10"><?php echo $nome; ?></dd>

                <dt class="col-sm-2">Usuário</dt>
                <dd class="col-sm-10"><?php echo $usuario; ?></dd>

                <dt class="col-sm-2">E-mail</dt>
                <dd class="col-sm-10"><?php echo $email; ?></dd>
                <?php
            }
            ?>
        </dl>
    </div>
</div>
