<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Listar Usuários</h2>
            </div>
            <?php
            if ($this->Dados['botao']['cad_usuario']) {
                ?>
                <a href="<?php echo URLADM . 'cadastrar-usuario/cad-usuario'; ?>">
                    <div class="p-2">
                        <button class="btn btn-outline-success btn-sm">
                            Cadastrar
                        </button>
                    </div>
                </a>
                <?php
            }
            ?>
        </div>
        <form class="form-inline" method="POST" action="<?php echo URLADM . 'pesq-usuarios/listar'; ?>">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input name="nome" type="text" id="nome" class="form-control mx-sm-3" placeholder="Digite o nome do usuário" autofocus>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input name="email" type="email" id="email" class="form-control mx-sm-3" placeholder="Digite o e-mail do usuário">
            </div>
            <input name="PesqUsuario" type="submit" class="btn btn-outline-primary" my-2 value="Pesquisar">
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