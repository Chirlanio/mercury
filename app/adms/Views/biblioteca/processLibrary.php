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
                <h2 class="display-4 titulo">Biblioteca de Processos</h2>
            </div>
            <?php
            if ($this->Dados['botao']['add_process']) {
                echo "<a href='" . URLADM . "add-process-library/add-process' class='btn btn-outline-success btn-sm'><i class='fa-solid fa-square-plus'></i> Novo</a> ";
            }
            ?>
        </div>
        <hr>
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
        ?>
        <div class="accordion" id="accordionExample">
            <div class="table-responsive">
                <?php
                foreach ($this->Dados['areas'] as $key => $area) {
                    extract($area);
                    //var_dump($this->Dados['areas']);
                    ?>
                    <div class="card mb-2">
                        <div class="card-header" id="heading<?php echo $id; ?>">
                            <h2 class="mb-0">
                                <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse<?php echo $id; ?>" aria-expanded="true" aria-controls="collapse<?php echo $id; ?>">
                                    <strong><?php echo $name; ?></strong> - <span class="btn-link text-decoration-none">Clique aqui</span> para ver os processos!
                                </button>
                            </h2>
                        </div>

                        <div id="collapse<?php echo $id; ?>" class="collapse" aria-labelledby="heading<?php echo $id; ?>" data-parent="#accordionExample">
                            <div class="card-body">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Titulo</th>
                                            <th class="d-none d-sm-table-cell">Setor</th>
                                            <th class="d-none d-sm-table-cell">Versão</th>
                                            <th class="d-none d-sm-table-cell">Data Inicial</th>
                                            <th class="d-none d-sm-table-cell">Data Final</th>
                                            <th class="d-none d-sm-table-cell">Situação</th>
                                            <th class="text-center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php
                                            foreach ($this->Dados['listProcess'] as $process) {
                                                extract($process);
                                                //var_dump($this->Dados['areas'][$key]['id'], $adms_area_id);
                                                if ($adms_area_id == $this->Dados['areas'][$key]['id']) {
                                                    ?>
                                                    <th><?php echo $id; ?></th>
                                                    <td><?php echo $title; ?></td><td class="d-none d-sm-table-cell"><?php echo $sector_name; ?></td>
                                                    <td class="d-none d-sm-table-cell"><?php echo $version_number; ?></td>
                                                    <td class="d-none d-sm-table-cell"><?php echo date('d/m/Y', strtotime($date_validation_start)); ?></td>
                                                    <td class="d-none d-sm-table-cell"><?php echo date('d/m/Y', strtotime($date_validation_end)); ?></td>
                                                    <td class="d-none d-sm-table-cell text-center"><span class="badge badge-<?php echo $color; ?>"><?php echo $status; ?></span></td>
                                                    <td class="text-center">
                                                        <span class="d-none d-md-block">
                                                            <?php
                                                            if ($this->Dados['botao']['view_process']) {
                                                                echo "<a href='" . URLADM . "view-process-library/process-library/$id' class='btn btn-outline-primary btn-sm'><i class='fas fa-eye'></i></a> ";
                                                            }
                                                            if ($this->Dados['botao']['edit_process']) {
                                                                echo "<a href='" . URLADM . "edit-process-library/process-library/$id' class='btn btn-outline-warning btn-sm'><i class='fas fa-pen-fancy'></i></a> ";
                                                            }
                                                            if ($this->Dados['botao']['del_process']) {
                                                                echo "<a href='" . URLADM . "delete-process-library/process-library/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a> ";
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
                                                                    echo "<a class='dropdown-item' href='" . URLADM . "view-process-library/process-library/$id'>Visualizar</a>";
                                                                }
                                                                if ($this->Dados['botao']['edit_process']) {
                                                                    echo "<a class='dropdown-item' href='" . URLADM . "edit-process-library/process-library/$id'>Editar</a>";
                                                                }
                                                                if ($this->Dados['botao']['del_process']) {
                                                                    echo "<a class='dropdown-item' href='" . URLADM . "delete-process-library/process-library/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

            </div>
        </div>
    </div>
</div>