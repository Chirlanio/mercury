<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Responsável - Autorização</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['cad_resp']) {
                        echo "<a href='" . URLADM . "cadastrar-resp/cad-resp' class='btn btn-outline-success btn-sm'><i class='fa-solid fa-square-plus'></i> Novo</a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                        <?php
                        if ($this->Dados['botao']['cad_resp']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "cadastrar-resp/cad-resp'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (empty($this->Dados['listResp'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum Responsável encontrado!
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
                        <th>Nome</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listResp'] as $resp) {
                        extract($resp);
                        ?>
                        <tr>
                            <td class="align-middle">
                                <?php echo $nome; ?>
                            </td>
                            <td class="text-center align-middle">
                                <?php
                                if ($this->Dados['botao']['list_resp']) {
                                    echo "<a href='" . URLADM . "autorizar/listar/?resp=$id' class='btn btn-outline-info btn-sm' title='Autorizar Estornos'><i class='fas fa-tasks'></i> Autorizar Estornos</a> ";
                                }
                                if ($this->Dados['botao']['edit_resp']) {
                                    echo "<a href='" . URLADM . "editar-resp/edit-resp/$id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fas fa-pen-nib'></i> Editar</a> ";
                                }
                                if ($this->Dados['botao']['del_resp']) {
                                    echo "<a href='" . URLADM . "apagar-resp/apagar-resp/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i> Apagar</a> ";
                                }
                                ?>
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
