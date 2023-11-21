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
                <h2 class="display-4 titulo">Biblioteca de Processos</h2>
            </div>
            <?php
            if ($this->Dados['botao']['add_process']) {
                ?>
                <a href="<?php echo URLADM . 'add-process-library/add-process'; ?>">
                    <div class="p-2">
                        <button class="btn btn-outline-success btn-sm"><span><i class="fas fa-plus d-block d-md-none fa-2x"></i>
                                <span class='d-none d-md-block'>Cadastrar</span>
                            </span>
                        </button>
                    </div>
                </a>
                <?php
            }
            ?>
        </div>
        <?php
        if (empty($this->Dados['listProcess'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhuma política ou processo encontrado!
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
        ?><hr>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titulo</th>
                        <th class="d-none d-sm-table-cell">Data Inicial</th>
                        <th class="d-none d-sm-table-cell">Data Final</th>
                        <th class="d-none d-sm-table-cell">Área</th>
                        <th class="d-none d-sm-table-cell">Setor</th>
                        <th class="d-none d-sm-table-cell">Versão</th>
                        <th class="d-none d-sm-table-cell">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listProcess'] as $pro) {
                        extract($pro);
                        ?>
                            <th><?php echo $id; ?></th>
                            <td><?php echo $title; ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo date('d/m/Y', strtotime($date_validation_start)); ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo date('d/m/Y', strtotime($date_validation_end)); ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo $area; ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo $sector_name; ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo $version_number; ?></td>
                            <td class="d-none d-sm-table-cell text-center"><span class="badge badge-<?php echo $color;?>"><?php echo $status; ?></span></td>
                            <td class="text-center">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['view_process']) {
                                        echo "<a href='" . URLADM . "view-process/view-process/$id' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                                    }
                                    if ($this->Dados['botao']['edit_process']) {
                                        echo "<a href='" . URLADM . "edit-process/edit-process/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                                    }
                                    if ($this->Dados['botao']['del_process']) {
                                        echo "<a href='" . URLADM . "delete-process/delete-process/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['view_process']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "view-process/view-process/$id'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_process']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "edit-process/edit-process/$id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_process']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "delete-process/delete-process/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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