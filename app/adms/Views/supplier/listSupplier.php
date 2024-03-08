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
                <h2 class="display-4 titulo">Fornecedores</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->Dados['botao']['add_supplier']) {
                    echo "<a href='" . URLADM . "add-supplier/add-supplier' class='btn btn-outline-success btn-sm'><i class='fa-solid fa-square-plus'></i> Novo</a> ";
                }
                ?>                
            </div>
        </div>
        <?php
        if (empty($this->Dados['listSupplier'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum fornecedor encontrado!
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
        <form class="form" method="POST" action="<?php echo URLADM . 'search-supplier/list'; ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 col-lg-12 mb-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="searchSupplier"><i class="fa-solid fa-magnifying-glass"></i></label>
                        </div>
                        <input name="searchSupplier" type="text" id="searchSupplier" class="form-control" aria-describedby="searchSupplier" placeholder="Pesquise por Razão Social, Nome Fantasia ou CNPJ" value="<?php
                        if (isset($_SESSION['searchSupplier'])) {
                            echo $_SESSION['searchSupplier'];
                        }
                        ?>" autofocus>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group ml-sm-2 ml-md-2 ml-lg-2 ml-3">
                    <input name="SearchSupplier" type="submit" class="btn btn-outline-primary mx-sm-2" value="Pesquisar">
                </div>
            </div>
        </form>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">#ID</th>
                        <th>Razão Social</th>
                        <th>Nome Fantasia</th>
                        <th>Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listSupplier'] as $c) {
                        extract($c);
                        ?>
                        <tr>
                            <th class="text-center align-middle"><?php echo $id_supp; ?></th>
                            <td class="align-middle"><?php echo $corporate_social; ?></td>
                            <td class="align-middle"><?php echo $fantasy_name; ?></td>
                            <td class="align-middle"><?php echo $status; ?></td>
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
                                        echo "<a href='" . URLADM . "delete-supplier/delete-supplier/$id_supp' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
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
