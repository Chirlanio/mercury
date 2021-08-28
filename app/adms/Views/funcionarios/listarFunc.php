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
                <h2 class="display-4 titulo">Listar Funcionários</h2>
            </div>
            <?php
            if ($this->Dados['botao']['listFunc']) {
                ?>
                <a href="<?php echo URLADM . 'cadastrar-func/cad-func'; ?>">
                    <div class="p-2">
                        <button class="btn btn-outline-success btn-sm">
                            Cadastrar
                        </button>
                    </div>
                </a>
                <?php
            }
            ?>
        </div>
        <form class="form" method="POST" action="<?php echo URLADM . 'pesq-func/listar'; ?>" enctype="multipart/form-data"> 
            <div class="row">
                <div class="col-sm-12 col-lg-6 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold;" for="cliente">Nome</label>
                        </div>
                        <input name="nome" type="text" id="nome" class="form-control" placeholder="Digite o nome do funcionário" value="<?php
                        if (isset($_SESSION['nome'])) {
                            echo $_SESSION['nome'];
                        }
                        ?>">
                    </div>
                </div>
                <?php
                if ($_SESSION['adms_niveis_acesso_id'] != 5) {

                    echo "<div class='col-sm-12 col-lg-6 mb-3'>";
                    echo "<div class='input-group'>";
                    echo "<div class='input-group-prepend'>";
                    echo "<label class='input-group-text' style='font-weight: bold;' for='loja_id'>Loja</label>";
                    echo "</div>";

                    echo "<select name='loja_id' id='loja_id' class='custom-select'>";
                    echo "<option value = ''>Selecione</option>";
                    foreach ($this->Dados['select']['loja_id'] as $ld) {
                        extract($ld);
                        if ($this->Dados['select']['loja_id'] == $loja_id) {
                            echo "<option value='$loja_id' selected>$loja</option>";
                        } else {
                            echo "<option value='$loja_id'>$loja</option>";
                        }
                    }
                    echo "</select>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </div>
            <div class="row">
                <div class="form-group ml-sm-2 ml-md-2 ml-lg-2 ml-3">
                    <input name="PesqFunc" type="submit" class="btn btn-outline-primary mx-sm-2" value="Pesquisar">
                </div>
            </div>
        </form><hr>
        <?php
        if (empty($this->Dados['listFunc'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum funcionário encontrado!
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
                        <th class="d-none d-sm-table-cell">Função</th>
                        <th class="d-none d-sm-table-cell">Loja</th>
                        <th class="d-none d-sm-table-cell">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listFunc'] as $func) {
                        extract($func);
                        ?>
                        <tr>
                            <th class="text-center align-middle"><?php echo $id; ?></th>
                            <td class="align-middle"><?php echo $nome; ?></td>
                            <td class="d-none d-sm-table-cell align-middle"><?php echo $cargo; ?></td>
                            <td class="d-none d-sm-table-cell align-middle"><?php echo $loja; ?></td>
                            <td class="d-none d-sm-table-cell align-middle"><?php echo $sit; ?></td>
                            <td class="text-center">
                                <span class="d-none d-md-block">

                                    <?php
                                    if ($this->Dados['botao']['vis_func']) {
                                        echo "<a href='" . URLADM . "ver-func/ver-func/$id' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['edit_func']) {
                                        echo "<a href='" . URLADM . "editar-func/edit-func/$id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['del_func']) {
                                        echo "<a href='" . URLADM . "apagar-func/apagar-func/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <a class='dropdown-item' href='<?php echo $link; ?>'  target="_blank">Acessar</a>
                                        <?php
                                        if ($this->Dados['botao']['vis_func']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "ver-func/ver-func/$id'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_func']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "editar-func/edit-func/$id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_func']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "apagar-func/apagar-func/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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