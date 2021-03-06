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
                <h2 class="display-4 titulo">Listar Marcas</h2>
            </div>
            <?php
            if ($this->Dados['botao']['cad_marca']) {
                ?>
                <a href="<?php echo URLADM . 'cadastrar-marca/cad-marca'; ?>">
                    <div class="p-2">
                        <button class="btn btn-outline-success btn-sm">
                            <span><i class="fas fa-plus d-block d-md-none fa-2x"></i>
                                <span class='d-none d-md-block'>Cadastrar</span>
                            </span>
                        </button>
                    </div>
                </a>
                <?php
            }
            ?>
        </div>
        <hr />
        <?php
        if (empty($this->Dados['listMarca'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhuma solicitação encontrada!
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
                        <th class="d-none d-sm-table-cell">Cadastrado</th>
                        <th class="d-none d-sm-table-cell">Atualizado</th>
                        <th class="d-none d-sm-table-cell">Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listMarca'] as $Marca) {
                        extract($Marca);
                        ?>
                        <tr>
                            <th class="text-center align-middle"><?php echo $id; ?></th>
                            <td class="align-middle"><?php echo $nome; ?></td>
                            <td class="d-none d-sm-table-cell align-middle"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></td>
                            <td class="d-none d-sm-table-cell align-middle">
                                <?php
                                if (!empty($modified)) {
                                    echo date('d/m/Y H:i:s', strtotime($modified));
                                }
                                ?>
                            </td>
                            <td class="d-none d-sm-table-cell align-middle text-center"><?php echo $status; ?></td>
                            <td class="text-center">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['vis_marca']) {
                                        echo "<a href='" . URLADM . "ver-marca/ver-marca/$id' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['edit_marca']) {
                                        echo "<a href='" . URLADM . "editar-marca/edit-marca/$id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['del_marca']) {
                                        echo "<a href='" . URLADM . "apagar-marca/apagar-marca/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['vis_marca']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "ver-marca/ver-marca/$id'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_marca']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "editar-marca/edit-marca/$id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_marca']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "apagar-marca/apagar-marca/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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