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
                <h2 class="display-4 titulo">Abertura de Vagas</h2>
            </div>
            <?php
            if ($this->Dados['botao']['spreadsheet']) {
                ?>
                <a href="<?php echo URLADM . 'generate-excel-spreadsheet/generate-excel'; ?>" class='btn btn-success btn-sm mr-2'>
                    <i class="fa-solid fa-table"></i> Gerar Excel
                </a>
                <?php
            }
            if ($this->Dados['botao']['add_vacancy']) {
                ?>
                <a href="<?php echo URLADM . 'add-vacancy-opening/add-vacancy'; ?>" class='btn btn-outline-success btn-sm'>
                    <i class='fa-solid fa-square-plus'></i> Novo
                </a>
                <?php
            }
            ?>
        </div>
        <form class="form" method="POST" action="<?php echo URLADM . 'search-vacancy-opening/list'; ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 col-lg-12 mb-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold" for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
                        </div>
                        <input name="search" type="text" id="search" class="form-control" aria-describedby="search" placeholder="Pesquise por Consultor(a), Loja, Situação ou ID" value="<?php
            if (isset($_SESSION['search'])) {
                echo $_SESSION['search'];
            }
            ?>" autofocus>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group ml-sm-2 ml-md-2 ml-lg-2 ml-3">
                    <input name="SearchVacancy" type="submit" class="btn btn-outline-primary mx-sm-2" value="Pesquisar">
                </div>
            </div>
        </form>
        <?php
        if (empty($this->Dados['list_vacancy'])) {
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
        ?><hr>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">#ID</th>
                        <th>Loja</th>
                        <th class="d-none d-sm-table-cell">Colaborador</th>
                        <th class="d-none d-sm-table-cell">Cargo</th>
                        <th class="d-none d-sm-table-cell">Tipo</th>
                        <th class="d-none d-sm-table-cell">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['list_vacancy'] as $vacancy) {
                        extract($vacancy);
                        ?>
                        <tr>
                            <th class="text-center"><?php echo $v_id; ?></th>
                            <td><?php echo $store_name; ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo!empty($funcionario) ? $funcionario : $type_name; ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo $cargo; ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo $type_name; ?></td>
                            <td class="d-none d-sm-table-cell align-middle text-center">
                                <span class="badge badge-<?php echo $cor_cr; ?>"><?php echo $status; ?></span>
                            </td>
                            <td class="text-center">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['view_vacancy']) {
                                        echo "<a href='" . URLADM . "view-vacancy-opening/view-vacancy/$v_id' class='btn btn-outline-primary btn-sm m-1'><i class='fas fa-eye'></i></a>";
                                    }
                                    if ($this->Dados['botao']['edit_vacancy']) {
                                        echo "<a href='" . URLADM . "edit-vacancy-opening/edit-vacancy/$v_id' class='btn btn-outline-warning btn-sm m-1'><i class='fas fa-pen-fancy'></i></a>";
                                    }
                                    if ($this->Dados['botao']['del_vacancy']) {
                                        echo "<a href='" . URLADM . "delete-vacancy-opening/delete-vacancy/$v_id' class='btn btn-outline-danger btn-sm m-1' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['view_vacancy']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "view-vacancy-opening/view-vacancy/$v_id'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_vacancy']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "edit-vacancy-opening/edit-vacancy/$v_id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_vacancy']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "delete-vacancy-opening/delete-vacancy/$v_id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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