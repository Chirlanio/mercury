<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
//var_dump($_SESSION['terms']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 mb-4 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Pesquisar Movimentação de Pessoal</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['list_moviment']) {
                        echo "<a href='" . URLADM . "personnel-moviments/list' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i></a> ";
                    }
                    if ($this->Dados['botao']['add_moviment']) {
                        echo "<a href='" . URLADM . "add-personnel-moviments/add-moviment' class='btn btn-outline-success btn-sm'>Cadastrar</a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                        <?php
                        if ($this->Dados['botao']['list_moviment']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "personnel-moviments/list'>Listar</a>";
                        }
                        if ($this->Dados['botao']['add_moviment']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "add-personnel-moviments/add-moviment'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <form class="form" method="POST" action="<?php echo URLADM . 'search-personnel-moviments/list'; ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 col-lg-12 mb-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
                        </div>
                        <input name="search" type="text" id="search" class="form-control" aria-describedby="search" placeholder="Pesquise por Colaborador, Área, Loja ou ID" value="<?php
                        if ((isset($_SESSION['search'])) AND (!empty($_SESSION['search']))) {
                            echo $_SESSION['search'];
                        }
                        ?>" autofocus>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group ml-sm-2 ml-md-2 ml-lg-2 ml-3">
                    <input name="SearchMoviments" type="submit" class="btn btn-outline-primary mx-sm-2" value="Pesquisar">
                </div>
            </div>
        </form>
        <?php
        if (empty($this->Dados['list_moviment'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhuma movimentação encontrada!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
            $redirectUrl = URLADM . 'personnel-moviments/list';
            if (empty($this->Dados['list_moviment'])) {
                header("Location: $redirectUrl");
                exit();
            }
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
                        <th class="d-none d-sm-table-cell">Loja</th>
                        <th class="d-none d-sm-table-cell">Colaborador</th>
                        <th class="d-none d-sm-table-cell">Último Dia Trabalhado</th>
                        <th class="d-none d-sm-table-cell">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['list_moviment'] as $moviment) {
                        extract($moviment);
                        ?>
                    <th><?php echo $id; ?></th>
                    <td><?php echo $store; ?></td>
                    <td class="d-none d-sm-table-cell"><?php echo $funcionario; ?></td>
                    <td class="d-none d-sm-table-cell"><?php echo date("d/m/Y", strtotime($last_day_worked)); ?></td>
                    <td class="d-none d-sm-table-cell align-middle text-center">
                        <span class="badge badge-<?php echo $cor_cr; ?>"><?php echo $status; ?></span>
                    </td>
                    <td class="text-center">
                        <span class="d-none d-md-block">
                            <?php
                            if ($this->Dados['botao']['view_moviment']) {
                                echo "<a href='" . URLADM . "view-personnel-moviments/view-moviment/$id' class='btn btn-outline-primary btn-sm'><i class='fas fa-eye'></i></a> ";
                            }
                            if ($this->Dados['botao']['edit_moviment']) {
                                echo "<a href='" . URLADM . "edit-personnel-moviments/edit-moviment/$id' class='btn btn-outline-warning btn-sm'><i class='fas fa-pen-fancy'></i></a> ";
                            }
                            if ($this->Dados['botao']['del_moviment']) {
                                echo "<a href='" . URLADM . "delete-personnel-moviments/delete-moviment/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a> ";
                            }
                            ?>
                        </span>
                        <div class="dropdown d-block d-md-none">
                            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Ações
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                <?php
                                if ($this->Dados['botao']['view_moviment']) {
                                    echo "<a class='dropdown-item' href='" . URLADM . "view-personnel-moviments/view-moviment/$id'>Visualizar</a>";
                                }
                                if ($this->Dados['botao']['edit_moviment']) {
                                    echo "<a class='dropdown-item' href='" . URLADM . "edit-personnel-moviments/edit-moviment/$id'>Editar</a>";
                                }
                                if ($this->Dados['botao']['del_moviment']) {
                                    echo "<a class='dropdown-item' href='" . URLADM . "delete-personnel-moviments/delete-moviment/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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