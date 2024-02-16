<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
?>
<nav class="navbar navbar-expand navbar-dark bg-<?php echo $_SESSION['nivac_cor']; ?>">
    <a class="sidebar-toggle text-light mr-3">
        <span class="navbar-toggler-icon"></span>
    </a>

    <a class="navbar-brand" href="<?php echo URLADM . ($_SESSION['adms_niveis_acesso_id'] == 13 ? 'home-treinamento/index' : 'home/index'); ?>"><img class="rounded-circle" src="<?php echo URLADM . 'assets/imagens/logo/sandalia_asa_branca.png'; ?>" width="50" height="50"><span class="d-none d-sm-inline">Mercury - Grupo Meia Sola</span></a>

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle menu-header" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown">
                    <?php if (isset($_SESSION['usuario_imagem']) AND (!empty($_SESSION['usuario_imagem']))) { ?>
                        <img class="rounded-circle" src="<?php echo URLADM . ($_SESSION['adms_niveis_acesso_id'] != 13 ? 'assets/imagens/usuario/' : 'assets/imagens/usuario/treinamento/') . $_SESSION['usuario_id'] . '/' . $_SESSION['usuario_imagem']; ?>" width="50" height="50" alt="Foto do usuário"> &nbsp;<span class="d-none d-sm-inline">
                        <?php } else { ?>
                            <img class="rounded-circle" src="<?php echo URLADM . 'assets/imagens/usuario/icone_usuario.png'; ?>" width="50" height="50" alt="Foto do usuário"> &nbsp;<span class="d-none d-sm-inline">
                                <?php
                            }
                            $nome = explode(" ", $_SESSION['usuario_nome']);
                            if (!empty($nome[1])) {
                                $prim_nome = $nome[0];
                                $prim_nome .= " " . $nome[1];
                            } else {
                                $prim_nome = $nome[0];
                            }
                            echo $prim_nome;
                            ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] != 13) {
                        ?>
                        <a class="dropdown-item" href="<?php echo URLADM . 'ver-perfil/perfil'; ?>"><i class="fas fa-user"></i> Perfil</a>
                        <a class="dropdown-item" href="https://meiasola.movidesk.com/" target="_blank"><i class="fas fa-headset"></i> Movidesk</a>
                    <?php } else { ?>
                        <a class="dropdown-item" href="<?php echo URLADM . 'ver-perfil-treinamento/perfil'; ?>"><i class="fas fa-user"></i> Perfil</a>
                    <?php } ?>
                    <a class="dropdown-item" href="<?php echo URLADM . ($_SESSION['adms_niveis_acesso_id'] == 13 ? 'login-treinamento/logout' : 'login/logout'); ?>"><i class="fas fa-sign-out-alt"></i> Sair</a>
                </div>
            </li>
        </ul>                
    </div>
</nav>
