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
                <h2 class="display-4 titulo">Tabela de CFOP's</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->Dados['botao']['cad_cfop']) {
                    echo "<a href='" . URLADM . "cadastrar-cfop/cad-cfop' class='btn btn-outline-success btn-sm'>Cadastrar</a> ";
                }
                ?>
            </div>
        </div><hr>
        <?php
        if (empty($this->Dados['listCfop'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum CFOP encontrado!
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
                        <th class="d-none d-sm-table-cell text-center">Operação</th>
                        <th class="text-center">CFOP</th>
                        <th class="d-none d-sm-table-cell text-center">Estado</th>
                        <th class="text-center">CST ICMS</th>
                        <th class="text-center">ALIQ.ICMS</th>
                        <th class="text-center">CST IPI</th>
                        <th class="text-center">CST PIS/COFINS</th>
                        <th class="text-center">PIS</th>
                        <th class="text-center">COFINS</th>
                        <th class="d-none d-sm-table-cell text-center">PRODUTO</th>
                        <?php
                        if ($_SESSION['adms_niveis_acesso_id'] <= 3) {
                            echo "<th class='text-center'>Ações</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listCfop'] as $cor) {
                        extract($cor);
                        ?>
                        <tr>
                            <td class="text-center align-middle"><?php echo $operation; ?></td>
                            <td class="text-center align-middle"><?php echo $cfop; ?></td>
                            <td class="text-center align-middle"><?php echo ($estado == 1) ? "Ceará" : "Outros Estados"; ?></td>
                            <td class="text-center align-middle"><?php echo $cst_icms; ?></td>
                            <td class="text-center align-middle"><?php echo $aliq_icms . '%'; ?></td>
                            <td class="text-center align-middle"><?php echo $cst_ipi; ?></td>
                            <td class="text-center align-middle"><?php echo $cst_pis_cofins; ?></td>
                            <td class="text-center align-middle"><?php echo $pis . '%'; ?></td>
                            <td class="text-center align-middle"><?php echo $cofins . '%'; ?></td>
                            <td class="text-center align-middle"><?php echo ($tipo_produto == 1) ? "Acessórios" : (($tipo_produto == 2) ? "Couro" : "Todos Produtos"); ?></td>
                            <?php
                            if ($_SESSION['adms_niveis_acesso_id'] <= 3) {
                                echo"<td class='text-center'>";
                                echo "<span class='d-none d-md-block'>";
                                if ($this->Dados['botao']['vis_cfop']) {
                                    echo "<a href='" . URLADM . "ver-cfop/ver-cfop/$id' class='btn btn-outline-primary btn-sm mb-1' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                }
                                if ($this->Dados['botao']['edit_cfop']) {
                                    echo "<a href='" . URLADM . "editar-cfop/edit-cfop/$id' class='btn btn-outline-warning btn-sm mb-1' title='Editar'><i class='fas fa-pen-nib'></i></a> ";
                                }
                                if ($this->Dados['botao']['del_cfop']) {
                                    echo "<a href='" . URLADM . "apagar-cfop/apagar-cfop/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                                }
                                echo"</span>";
                                echo"<div class='dropdown d-block d-md-none'>";
                                echo"<button class='btn btn-primary dropdown-toggle btn-sm' type='button' id='acoesListar' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Ações</button>";
                                echo '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">';
                                if ($this->Dados['botao']['vis_cfop']) {
                                    echo "<a class='dropdown-item' href='" . URLADM . "ver-cfop/ver-cfop/$id'>Visualizar</a>";
                                }
                                if ($this->Dados['botao']['edit_cfop']) {
                                    echo "<a class='dropdown-item' href='" . URLADM . "editar-cfop/edit-cfop/$id'>Editar</a>";
                                }
                                if ($this->Dados['botao']['del_cfop']) {
                                    echo "<a class='dropdown-item' href='" . URLADM . "apagar-cfop/apagar-cfop/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                }
                                echo"</div>";
                                echo"</div>";
                                echo "</td>";
                            }
                            ?>
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
