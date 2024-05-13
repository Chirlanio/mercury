<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 mb-4 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Políticas</h2>
            </div>
            <?php
            if ($this->Dados['botao']['add_policies']) {
                echo "<a href='" . URLADM . "add-policies/add-policie' class='btn btn-outline-success btn-sm'><i class='fa-solid fa-square-plus'></i> Novo</a>";
            }
            ?>
        </div>
        <hr>
        <?php
        if (empty($this->Dados['listPolicies'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhuma política encontrada!
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
                        <th class="text-center">#ID</th>
                        <th class="d-none d-sm-table-cell">Titulo</th>
                        <th class="d-none d-sm-table-cell">Data Inicial</th>
                        <th class="d-none d-sm-table-cell">Data Final</th>
                        <th class="d-none d-sm-table-cell">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listPolicies'] as $Policie) {
                        extract($Policie);
                        ?>
                <th class="text-center"><?php echo $id; ?></th>
                    <td><?php echo $title; ?></td>
                    <td class="d-none d-sm-table-cell"><?php echo date('d/m/Y', strtotime($dataInicial)); ?></td>
                    <td class="d-none d-sm-table-cell"><?php echo date('d/m/Y', strtotime($dataFinal)); ?></td>
                    <td class="d-none d-sm-table-cell text-center"><span class="badge badge-<?php echo $color; ?>"><?php echo $status; ?></span></td>
                    <td class="text-center">
                        <span class="d-none d-md-block">
                            <?php
                            if ($this->Dados['botao']['view_policies']) {
                                echo "<a href='" . URLADM . "view-policies/view-policie/$id' class='btn btn-outline-primary btn-sm'><i class='fa-solid fa-eye'></i></a> ";
                            }
                            if ($this->Dados['botao']['edit_policies']) {
                                echo "<a href='" . URLADM . "edit-policies/edit-policie/$id' class='btn btn-outline-warning btn-sm'><i class='fa-solid fa-pen-to-square'></i></a> ";
                            }
                            if ($this->Dados['botao']['del_policies']) {
                                echo "<a href='" . URLADM . "delete-policies/del-policie/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fa-solid fa-eraser'></i></a> ";
                            }
                            ?>
                        </span>
                        <div class="dropdown d-block d-md-none">
                            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Ações
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                <?php
                                if ($this->Dados['botao']['view_policies']) {
                                    echo "<a class='dropdown-item' href='" . URLADM . "view-policies/view-policie/$id'>Visualizar</a>";
                                }
                                if ($this->Dados['botao']['edit_policies']) {
                                    echo "<a class='dropdown-item' href='" . URLADM . "edit-policies/edit-policie/$id'>Editar</a>";
                                }
                                if ($this->Dados['botao']['del_policies']) {
                                    echo "<a class='dropdown-item' href='" . URLADM . "delete-policies/del-policie/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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