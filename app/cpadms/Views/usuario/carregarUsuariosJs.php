<?php
if (!defined('URLADM')) {
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
        <form class="form-inline" method="POST" action="">
            <div class="row">
                <div class="col-auto">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="pesqUser"><i class="fa-solid fa-magnifying-glass"></i></label>
                        </div>
                        <input name="pesqUser" type="text" id="pesqUser" class="form-control" aria-describedby="pesqUser" placeholder="Nome ou e-mail do usuário" />
                    </div>
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