<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (empty($this->Dados['listUser'])) {
    ?>
    <div class="alert alert-danger" role="alert">
        Nenhum usuário encontrado!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
}
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th>Nome</th>
                <th class="d-none d-sm-table-cell">E-mail</th>
                <th class="d-none d-lg-table-cell text-center">Situação</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($this->Dados['listUser'] as $usuario) {
                extract($usuario);
                ?>
                <tr>
                    <th class="text-center align-middle"><?php echo $id; ?></th>
                    <td class="align-middle"><?php echo $nome; ?></td>
                    <td class="d-none d-sm-table-cell align-middle"><?php echo $email; ?></td>
                    <td class="d-none d-lg-table-cell align-middle text-center">
                        <span class="badge badge-<?php echo $cor_cr; ?>"><?php echo $nome_sit; ?></span>
                    </td>
                    <td class="text-center">
                        <span class="d-none d-md-block">
                            <?php
                            /* if ($this->Dados['botao']['vis_usuario']) {
                              echo "<a href='" . URLADM . "ver-usuario/ver-usuario/$id' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                              } */
                            if ($this->Dados['botao']['vis_usuario']) {
                                echo "<button type='button' class='btn btn-outline-primary btn-sm view_data' id='" . $id . "' title='Visualizar'><i class='fas fa-eye'></i></button> ";
                            }
                            if ($this->Dados['botao']['edit_usuario_modal']) {
                                echo "<button type='button' class='btn btn-outline-warning btn-sm view_data_edit' id='" . $id . "' title='Editar'><i class='fas fa-pen-nib'></i></button> ";
                            }
                            if ($this->Dados['botao']['del_usuario']) {
                                echo "<a href='" . URLADM . "apagar-usuario/apagar-usuario/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                            }
                            ?>
                        </span>
                        <div class="dropdown d-block d-md-none">
                            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Ações
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                <?php
                                if ($this->Dados['botao']['vis_usuario']) {
                                    echo "<a class='dropdown-item' href='" . URLADM . "ver-usuario/ver-usuario/$id'>Visualizar</a>";
                                }
                                if ($this->Dados['botao']['edit_usuario']) {
                                    echo "<a class='dropdown-item' href='" . URLADM . "editar-usuario/edit-usuario/$id'>Editar</a>";
                                }
                                if ($this->Dados['botao']['del_usuario']) {
                                    echo "<a class='dropdown-item' href='" . URLADM . "apagar-usuario/apagar-usuario/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                }
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php
    echo $this->Dados['paginacao'];
    ?>
</div>