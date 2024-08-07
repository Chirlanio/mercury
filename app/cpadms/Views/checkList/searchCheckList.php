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
                <h2 class="display-4 titulo">Pesquisar Check List</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['check_list']) {
                        echo "<a href='" . URLADM . "check-list/list' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i></a> ";
                    }
                    if ($this->Dados['botao']['add_check_list']) {
                        echo "<a href='" . URLADM . "add-check-list/check-list' class='btn btn-outline-success btn-sm'><i class='fa-solid fa-square-plus'></i> Novo</a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                        <?php
                        if ($this->Dados['botao']['check_list']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "check-list/list'>Listar</a>";
                        }
                        if ($this->Dados['botao']['add_check_list']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "add-check-list/check-list'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <form class="form" method="POST" action="<?php echo URLADM . 'search-check-list/list'; ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 col-lg-12 mb-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
                        </div>
                        <input name="search" type="text" id="search" class="form-control" aria-describedby="search" placeholder="Pesquise por Loja ou ID" value="<?php
                        if ((isset($_SESSION['search'])) AND (!empty($_SESSION['search']))) {
                            echo $_SESSION['search'];
                        }
                        ?>" autofocus>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group ml-sm-2 ml-md-2 ml-lg-2 ml-3">
                    <input name="SearchCheckList" type="submit" class="btn btn-outline-primary mx-sm-2" value="Pesquisar">
                </div>
            </div>
        </form>
        <?php
        if (empty($this->Dados['data_check_list'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum check list encontrado!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
            $redirectUrl = URLADM . 'check-list/list';
            if (empty($this->Dados['list_check_list'])) {
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
                        <th class="d-none d-sm-table-cell">Aplicador</th>
                        <th class="d-none d-sm-table-cell">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['data_check_list'] as $check) {
                        extract($check);
                        ?>
                <th class="text-center"><?php echo $hash_id; ?></th>
                    <td><?php echo $store; ?></td>
                    <td class="d-none d-sm-table-cell"><?php echo $responsible_applicator == 1 ? "Deborah Costa" : "Larissa Mascrenhas"; ?></td>
                    <td class="d-none d-sm-table-cell align-middle text-center">
                        <span class="badge badge-<?php echo $cor_cr; ?>"><?php echo $status; ?></span>
                    </td>
                    <td class="text-center">
                        <span class="d-none d-md-block">
                            <?php
                            if ($this->Dados['botao']['view_check_list']) {
                                echo "<a href='" . URLADM . "view-check-list/check-list/$hash_id' class='btn btn-outline-primary btn-sm'><i class='fas fa-eye'></i></a> ";
                            }
                            if ($this->Dados['botao']['edit_check_list']) {
                                echo "<a href='" . URLADM . "edit-check-list/check-list/$hash_id' class='btn btn-outline-warning btn-sm'><i class='fas fa-pen-fancy'></i></a> ";
                            }
                            if ($this->Dados['botao']['del_check_list']) {
                                echo "<a href='" . URLADM . "delete-check-list/check-list/$hash_id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a> ";
                            }
                            ?>
                        </span>
                        <div class="dropdown d-block d-md-none">
                            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Ações
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                <?php
                                if ($this->Dados['botao']['view_check_list']) {
                                    echo "<a class='dropdown-item' href='" . URLADM . "view-check-list/check-list/$hash_id'>Visualizar</a>";
                                }
                                if ($this->Dados['botao']['edit_check_list']) {
                                    echo "<a class='dropdown-item' href='" . URLADM . "edit-check-list/check-list/$hash_id'>Editar</a>";
                                }
                                if ($this->Dados['botao']['del_check_list']) {
                                    echo "<a class='dropdown-item' href='" . URLADM . "delete-check-list/check-list/$hash_id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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