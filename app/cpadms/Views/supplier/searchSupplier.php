<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
//var_dump($_SESSION['terms']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Pesquisar Fornecedores</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['list_supplier']) {
                        echo "<a href='" . URLADM . "supplier/list' class='btn btn-outline-info btn-sm ml-2'><i class='fas fa-list'></i></a> ";
                    }
                    if ($this->Dados['botao']['add_supplier']) {
                        echo "<a href='" . URLADM . "add-supplier/add-supplier' class='btn btn-outline-success btn-sm'>Cadastrar</a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                        <?php
                        if ($this->Dados['botao']['list_supplier']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "supplier/list'>Listar</a>";
                        }
                        if ($this->Dados['botao']['add_supplier']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "add-supplier/add-supplier'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <form class="form" method="POST" action="<?php echo URLADM . 'search-supplier/list'; ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 col-lg-12 mb-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="searchSupplier"><i class="fa-solid fa-magnifying-glass"></i></label>
                        </div>
                        <input name="searchSupplier" type="text" id="searchSupplier" class="form-control" aria-describedby="searchSupplier" placeholder="Pesquise por Razão Social, Nome Fantásia ou CNPJ" value="<?php
                        if ((isset($_SESSION['searchSupplier'])) AND (!empty($_SESSION['searchSupplier']))) {
                            echo $_SESSION['searchSupplier'];
                        }
                        ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group ml-sm-2 ml-md-2 ml-lg-2 ml-3">
                    <input name="SearchSupplier" type="submit" class="btn btn-outline-primary mx-sm-2" value="Pesquisar">
                </div>
            </div>
        </form>
        <?php
        if (empty($this->Dados['list_supplier'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum fornecedor encontrado!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
            $redirectUrl = URLADM . 'supplier/list';
            if ((empty($this->Dados['list_supplier']))) {
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
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>Razão Social</th>
                        <th>Nome Fantasia</th>
                        <th>Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['list_supplier'] as $c) {
                        extract($c);
                        ?>
                        <tr>
                            <th class="text-center align-middle"><?php echo $id_supp; ?></th>
                            <td class="align-middle"><?php echo $corporate_social; ?></td>
                            <td class="align-middle"><?php echo $fantasy_name; ?></td>
                            <td class="align-middle"><span class="badge badge-<?php echo $cor; ?>"><?php echo $status; ?></span></td>
                            <td class="text-center align-middle">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['view_supplier']) {
                                        echo "<a href='" . URLADM . "view-supplier/view-supplier/$id_supp' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['edit_supplier']) {
                                        echo "<a href='" . URLADM . "edit-supplier/edit-supplier/$id_supp' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['del_supplier']) {
                                        echo "<a href='" . URLADM . "delete-supplier/del-supplier/$id_supp' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['view_supplier']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "view-supplier/view-supplier/$id_supp'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_supplier']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "edit-supplier/edit-supplier/$id_supp'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_supplier']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "delete-supplier/delete-supplier/$id_supp' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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