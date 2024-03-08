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
                <h2 class="display-4 titulo">Listar Itens de Menu</h2>
            </div>
            <?php
            if ($this->Dados['botao']['cad_menu']) {
                echo "<a href='" . URLADM . "cadastrar-menu/cad-menu' class='btn btn-outline-success btn-sm'><i class='fa-solid fa-square-plus'></i> Novo</a> ";
            }
            ?>
        </div>
        <hr>
        <?php
        if (empty($this->Dados['listItensMenu'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum item de menu encontrado!
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
                        <th class="d-none d-sm-table-cell text-center">Ordem</th>
                        <th class="d-none d-lg-table-cell text-center">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listItensMenu'] as $itenMenu) {
                        extract($itenMenu);
                        ?>
                        <tr>
                            <th class="text-center align-middle"><?php echo $id; ?></th>
                            <td class="align-middle">
                                <?php echo "<i class='" . $icone . "'></i> - " . $nome; ?>
                            </td>
                            <td class="d-none d-sm-table-cell text-center align-middle"><?php echo $ordem; ?></td>
                            <td class="d-none d-lg-table-cell text-center align-middle">
                                <span class="badge badge-<?php echo $cor_cr; ?>"><?php echo $nome_sit; ?></span>
                            </td>
                            <td class="text-center">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['ordem_menu']) {
                                        echo "<a href='" . URLADM . "alt-ordem-item-menu/alt-ordem-item-menu/$id' class='btn btn-outline-secondary btn-sm'><i class='fas fa-angle-double-up'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['vis_menu']) {
                                        echo "<a href='" . URLADM . "ver-menu/ver-menu/$id' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['edit_menu']) {
                                        echo "<a href='" . URLADM . "editar-menu/edit-menu/$id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['del_menu']) {
                                        echo "<a href='" . URLADM . "apagar-menu/apagar-menu/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['vis_menu']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "ver-menu/ver-menu/$id'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_menu']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "editar-menu/edit-menu/$id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_menu']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "apagar-menu/apagar-menu/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
