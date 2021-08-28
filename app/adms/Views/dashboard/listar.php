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
                <h2 class="display-4 titulo">Dashboard's</h2>
            </div>
            <?php
            if ($this->Dados['botao']['listDash']) {
                ?>
                <a href="<?php echo URLADM . 'cadastrar-dashboard/cad-dash'; ?>">
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
        <?php
        if (empty($this->Dados['listDash'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum Dashboard encontrado!
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
                        <th class="d-none d-sm-table-cell">Descrição</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listDash'] as $dash) {
                        extract($dash);
                        ?>
                        <tr>
                            <th class="text-center align-middle"><?php echo $id; ?></th>
                            <td class="align-middle"><?php echo $nome; ?></td>
                            <td class="d-none d-sm-table-cell align-middle"><?php echo $descricao; ?></td>
                            <td class="text-center align-middle">
                                <span class="d-none d-md-block">
                                    <a href="<?php echo $link; ?>" class="btn btn-outline-info btn-sm" target="_blank" title='Acessar'><i class='fas fa-external-link-alt'></i></a>
                                    <?php
                                    if ($this->Dados['botao']['vis_dash']) {
                                        echo "<a href='". URLADM . "ver-dashboard/ver-dashboard/$id' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['edit_dash']) {
                                        echo "<a href='". URLADM . "editar-dashboard/edit-dashboard/$id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['del_dash']) {
                                        echo "<a href='". URLADM . "apagar-dashboard/apagar-dashboard/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <a class='dropdown-item' href='<?php echo $link; ?>'  target="_blank">Acessar</a>
                                        <?php
                                        if ($this->Dados['botao']['vis_dash']) {
                                            echo "<a class='dropdown-item' href='". URLADM . "ver-dashboard/ver-dashboard/$id'>Detalhar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_dash']) {
                                            echo "<a class='dropdown-item' href='". URLADM . "editar-dashboard/edit-dashboard/$id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_dash']) {
                                            echo "<a class='dropdown-item' href='". URLADM . "apagar-dashboard/apagar-dashboard/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";                                           
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