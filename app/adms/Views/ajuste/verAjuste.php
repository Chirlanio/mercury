<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_ajuste'][0])) {
    extract($this->Dados['dados_ajuste'][0]);
?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Detalhes da Solicitação</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_ajuste']) {
                            echo "<a href='" . URLADM . "ajuste/listar-ajuste' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i> Listar</a> ";
                        }
                        if ($this->Dados['botao']['edit_ajuste']) {
                            echo "<a href='" . URLADM . "editar-ajuste/edit-ajuste/$id' class='btn btn-outline-warning btn-sm'><i class='fas fa-pen-fancy'></i> Editar</a> ";
                        }
                        if ($this->Dados['botao']['del_ajuste']) {
                            echo "<a href='" . URLADM . "apagar-ajuste/apagar-ajuste/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i> Apagar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                            <?php
                            if ($this->Dados['botao']['list_ajuste']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "ajuste/listarAjuste'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_ajuste']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-ajuste/edit-ajuste/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_ajuste']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-ajuste/apagar-ajuste/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
            <div style="width: 150px; height: 150px;"><?php echo "<img class='img-thumbnail' src='http://www.meiasola.com/powerbi/" . $referencia . ".jpg' width='150' height='150' alt='" . $referencia . "'>"; ?></div><br>
            <dl class="row">

                <dt class="col-sm-2">ID</dt>
                <dd class="col-sm-10"><?php echo $id; ?></dd>

                <dt class="col-sm-2">Solicitante</dt>
                <dd class="col-sm-10"><?php echo $usuario; ?></dd>

                <dt class="col-sm-2">Loja</dt>
                <dd class="col-sm-10"><?php echo $nome_loja; ?></dd>

                <dt class="col-sm-2">Referência</dt>
                <dd class="col-sm-10"><?php echo $referencia; ?></dd>

                <dt class="col-sm-2">Tamanho</dt>
                <dd class="col-sm-10"><?php echo $tam; ?></dd>

                <dt class="col-sm-2">Quantidade</dt>
                <dd class="col-sm-10"><?php echo $qtde; ?></dd>

                <dt class="col-sm-2">Consultora</dt>
                <dd class="col-sm-10"><?php echo $func; ?></dd>

                <dt class="col-sm-2">Cliente</dt>
                <dd class="col-sm-10"><?php echo $cliente; ?></dd>

                <dt class="col-sm-2">Grade</dt>
                <dd class="col-sm-1"><?php echo 'Bolsa - ' . $t01; ?></dd>
                <dd class="col-sm-1"><?php echo '33 - ' . $t33; ?></dd>
                <dd class="col-sm-1"><?php echo '34 - ' . $t34; ?></dd>
                <dd class="col-sm-1"><?php echo '35 - ' . $t35; ?></dd>
                <dd class="col-sm-1"><?php echo '36 - ' . $t36; ?></dd>
                <dd class="col-sm-1"><?php echo '37 - ' . $t37; ?></dd>
                <dd class="col-sm-1"><?php echo '38 - ' . $t38; ?></dd>
                <dd class="col-sm-1"><?php echo '39 - ' . $t39; ?></dd>
                <dd class="col-sm-1"><?php echo '40 - ' . $t40; ?></dd>
                <dd class="col-sm-1"><?php echo 'Total - ' . $total; ?></dd>

                <?php
                if ($total_2 > 0) {
                ?>
                    <dt class="col-sm-2"><?php echo $referencia_2; ?></dt>
                    <dd class="col-sm-1"><?php echo 'Bolsa - ' . $t01_2; ?></dd>
                    <dd class="col-sm-1"><?php echo '33 - ' . $t33_2; ?></dd>
                    <dd class="col-sm-1"><?php echo '34 - ' . $t34_2; ?></dd>
                    <dd class="col-sm-1"><?php echo '35 - ' . $t35_2; ?></dd>
                    <dd class="col-sm-1"><?php echo '36 - ' . $t36_2; ?></dd>
                    <dd class="col-sm-1"><?php echo '37 - ' . $t37_2; ?></dd>
                    <dd class="col-sm-1"><?php echo '38 - ' . $t38_2; ?></dd>
                    <dd class="col-sm-1"><?php echo '39 - ' . $t39_2; ?></dd>
                    <dd class="col-sm-1"><?php echo '40 - ' . $t40_2; ?></dd>
                    <dd class="col-sm-1"><?php echo 'Total - ' . $total_2; ?></dd>
                <?php
                }
                if ($total_3 > 0) {
                ?>
                    <dt class="col-sm-2"><?php echo $referencia_3; ?></dt>
                    <dd class="col-sm-1"><?php echo 'Bolsa - ' . $t01_3; ?></dd>
                    <dd class="col-sm-1"><?php echo '33 - ' . $t33_3; ?></dd>
                    <dd class="col-sm-1"><?php echo '34 - ' . $t34_3; ?></dd>
                    <dd class="col-sm-1"><?php echo '35 - ' . $t35_3; ?></dd>
                    <dd class="col-sm-1"><?php echo '36 - ' . $t36_3; ?></dd>
                    <dd class="col-sm-1"><?php echo '37 - ' . $t37_3; ?></dd>
                    <dd class="col-sm-1"><?php echo '38 - ' . $t38_3; ?></dd>
                    <dd class="col-sm-1"><?php echo '39 - ' . $t39_3; ?></dd>
                    <dd class="col-sm-1"><?php echo '40 - ' . $t40_3; ?></dd>
                    <dd class="col-sm-1"><?php echo 'Total - ' . $total_3; ?></dd>
                <?php
                }
                if ($total_4 > 0) {
                ?>
                    <dt class="col-sm-2"><?php echo $referencia_4; ?></dt>
                    <dd class="col-sm-1"><?php echo 'Bolsa - ' . $t01_4; ?></dd>
                    <dd class="col-sm-1"><?php echo '33 - ' . $t33_4; ?></dd>
                    <dd class="col-sm-1"><?php echo '34 - ' . $t34_4; ?></dd>
                    <dd class="col-sm-1"><?php echo '35 - ' . $t35_4; ?></dd>
                    <dd class="col-sm-1"><?php echo '36 - ' . $t36_4; ?></dd>
                    <dd class="col-sm-1"><?php echo '37 - ' . $t37_4; ?></dd>
                    <dd class="col-sm-1"><?php echo '38 - ' . $t38_4; ?></dd>
                    <dd class="col-sm-1"><?php echo '39 - ' . $t39_4; ?></dd>
                    <dd class="col-sm-1"><?php echo '40 - ' . $t40_4; ?></dd>
                    <dd class="col-sm-1"><?php echo 'Total - ' . $total_4; ?></dd>
                <?php }
                ?>
                <dt class="col-sm-2">Observação</dt>
                <dd class="col-sm-10"><?php echo $obs; ?></dd>

                <dt class="col-sm-2">Status</dt>
                <dd class="col-sm-10"><?php echo $status; ?></dd>

                <dt class="col-sm-2">Cadastrado</dt>
                <dd class="col-sm-10"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></dd>

                <dt class="col-sm-2">Atualizado</dt>
                <dd class="col-sm-10"><?php
                                        if (!empty($modified)) {
                                            echo date('d/m/Y H:i:s', strtotime($modified));
                                        }
                                        ?>
                </dd>
            </dl>
        </div>
    </div>
<?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Página não encontrada!</div>";
    $UrlDestino = URLADM . 'ajuste/listarAjuste';
    header("Location: $UrlDestino");
}
