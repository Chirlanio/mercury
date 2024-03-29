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
                <h2 class="display-4 titulo">Listar Nível de Acesso</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['sincro_permi']) {
                        echo "<a href='" . URLADM . "sincro-pg-niv-ac/sincro-pg-niv-ac' class='btn btn-outline-warning btn-sm' title='Sincronizar'><i class='fa-solid fa-rotate'></i></a> ";
                    }
                    if ($this->Dados['botao']['cad_nivac']) {
                        echo "<a href='" . URLADM . "cadastrar-niv-ac/cad-niv-ac' class='btn btn-outline-success btn-sm'><i class='fa-solid fa-square-plus'></i> Novo</a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                        <?php
                        if ($this->Dados['botao']['sincro_permi']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "sincro-pg-niv-ac/sincro-pg-niv-ac'>Sincronizar</a>";
                        }
                        if ($this->Dados['botao']['cad_nivac']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "cadastrar-niv-ac/cad-niv-ac'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <?php
        if (empty($this->Dados['listNivAc'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum nível de acesso encontrado!
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
                        <th class="d-none d-sm-table-cell">Ordem</th>
                        <th class="d-none d-sm-table-cell">Cor do Perfil</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $qnt_linhas_exe = 1;
                    foreach ($this->Dados['listNivAc'] as $nivAc) {
                        extract($nivAc);
                        ?>
                        <tr>
                            <th class="text-center align-middle"><?php echo $id; ?></th>
                            <td class="align-middle"><?php echo $nome; ?></td>
                            <td class="d-none d-sm-table-cell align-middle"><?php echo $ordem; ?></td>
                            <td class="d-none d-sm-table-cell align-middle">
                                <span class="badge badge-<?php echo $cor_cr; ?>"><?php echo $nome_cor; ?></span>
                            </td>
                            <td class="text-center">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($qnt_linhas_exe <= 2) {
                                        if ($this->Dados['botao']['ordem_nivac']) {
                                            echo "<button class='btn btn-outline-secondary btn-sm disabled'><i class='fas fa-angle-double-up'></i></button> ";
                                        }
                                    } else {
                                        if ($this->Dados['botao']['ordem_nivac']) {
                                            echo "<a href='" . URLADM . "alt-ordem-niv-ac/alt-ordem-niv-ac/$id' class='btn btn-outline-secondary btn-sm'><i class='fas fa-angle-double-up'></i></a> ";
                                        }
                                    }
                                    $qnt_linhas_exe++;
                                    if ($this->Dados['botao']['list_permi']) {
                                        echo "<a href='" . URLADM . "permissoes/listar/1?niv=$id' class='btn btn-outline-info btn-sm' title='Permissões'><i class='fas fa-tasks'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['vis_nivac']) {
                                        echo "<a href='" . URLADM . "ver-niv-ac/ver-niv-ac/$id' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['edit_nivac']) {
                                        echo "<a href='" . URLADM . "editar-niv-ac/edit-niv-ac/$id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['del_nivac']) {
                                        echo "<a href='" . URLADM . "apagar-niv-ac/apagar-niv-ac/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['vis_nivac']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "ver-niv-ac/ver-niv-ac/$id'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_nivac']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "editar-niv-ac/edit-niv-ac/$id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_nivac']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "apagar-niv-ac/apagar-niv-ac/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
    </div>
</div>
