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
                <h2 class="display-4 titulo">Centros de Custos</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->Dados['botao']['cad_cost']) {
                    echo "<a href='" . URLADM . "add-cost-center/cost-center' class='btn btn-outline-success btn-sm'>Cadastrar</a> ";
                }
                ?>                
            </div>
        </div>
        <form class="form" method="POST" action="<?php echo URLADM . 'pesq-cost-center/list'; ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 col-lg-12 mb-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
                        </div>
                        <input name="search" type="text" id="search" class="form-control" aria-describedby="search" placeholder="Digite o nome do Centro de Custos" value="<?php
                        if (isset($_SESSION['search'])) {
                            echo $_SESSION['search'];
                        }
                        ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group ml-sm-2 ml-md-2 ml-lg-2 ml-3">
                    <input name="PesqCostCenter" type="submit" class="btn btn-outline-primary mx-sm-2" value="Pesquisar">
                </div>
            </div>
        </form>
        <?php
        if (empty($this->Dados['listCostCenter'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum Centro de custo encontrado!
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
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">ID Centro de Custo</th>
                        <th class="text-center">Centro de custo</th>
                        <th class="text-center">Resposável</th>
                        <th class="text-center">Área</th>
                        <th class="text-center">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listCostCenter'] as $cc) {
                        extract($cc);
                        ?>
                        <tr>
                            <th class="text-center align-middle"><?php echo $cc_id; ?></th>
                            <td class="text-center align-middle cost_center"><?php echo $cost_center_id; ?></td>
                            <td class="text-center align-middle"><?php echo $costCenter; ?></td>
                            <td class="text-center align-middle"><?php echo $gerencia; ?></td>
                            <td class="text-center align-middle"><?php echo $name_area; ?></td>
                            <td class="text-center align-middle"><?php echo $status; ?></td>
                            <td class="text-center align-middle">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['view_cost']) {
                                        echo "<a href='" . URLADM . "view-cost-center/cost-center/$cc_id' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['edit_cost']) {
                                        echo "<a href='" . URLADM . "edit-cost-center/cost-center/$cc_id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['del_cost']) {
                                        echo "<a href='" . URLADM . "delete-cost-center/cost-center/$cc_id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['view_cost']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "view-cost-center/cost-center/$cc_id'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_cost']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "edit-cost-center/cost-center/$cc_id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_cost']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "delete-cost-center/cost-center/$cc_id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
