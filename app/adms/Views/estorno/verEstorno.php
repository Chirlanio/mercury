<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_estorno'][0])) {
    extract($this->Dados['dados_estorno'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Detalhes da Solicitação</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_estorno']) {
                            echo "<a href='" . URLADM . "estorno/listar' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i></a> ";
                        }
                        if ($this->Dados['botao']['edit_estorno']) {
                            echo "<a href='" . URLADM . "editar-estorno/edit-estorno/$id' class='btn btn-outline-warning btn-sm'><i class='fa-solid fa-pen-to-square'></i></a> ";
                        }
                        if ($this->Dados['botao']['del_estorno']) {
                            echo "<a href='" . URLADM . "apagar-estorno/apagar-estorno/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a>";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_estorno']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "estorno/listar'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_estorno']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-estorno/edit-estorno/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_estorno']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-estorno/apagar-estorno/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div><hr>
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
            <div class="content p1">
                <div class="row">
                    <div class="col-md-4 order-md-2 mb-4">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Dados do Cliente</span>
                        </h4>
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-2">Nome:</h6>
                                    <small class="text-muted lead"><?php echo $nome_cliente; ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-2">CPF:</h6>
                                    <small class="text-muted" id="cpf"><?php echo $cpf_cliente; ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-2">Valor Registrado:</h6>
                                    <small class="text-muted lead" ><?php echo "R$ " . number_format($valor_lancado, 2, ',', '.'); ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between bg-light">
                                <div class="text-success">
                                    <h6 class="my-2">Valor Correto:</h6>
                                    <small class="lead"><?php echo "R$ " . number_format($valor_correto, 2, ',', '.'); ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div class="text-danger">
                                    <h6 class="my-2">Valor Estorno:</h6>
                                    <small class="lead"><?php echo "R$ " . number_format($valor_estorno, 2, ',', '.'); ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-2">Situação:</h6>
                                    <small class="badge badge-info badge-pill lead"><?php echo $sit; ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-2">Cadastrado</h6>
                                    <small class="lead"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></small>
                                    <small class="lead"><?php
                                        if (!empty($modified)) {
                                            echo '<h6 class="my-2">Atualizado</h6>';
                                            echo date('d/m/Y H:i:s', strtotime($modified));
                                        }
                                        ?>
                                    </small>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-8 order-md-1">
                        <h4 class="mb-3">Dados da Venda</h4>
                        <form class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="loja_id">Loja</label>
                                    <input type="text" class="form-control bg-white" id="loja_id" readonly value="<?php echo $loja; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="adms_func_id">Consultora</label>
                                    <input type="text" class="form-control bg-white" id="adms_func_id" value="<?php echo $func; ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="doc_nf">Cupom - Nota Fiscal</label>
                                    <input type="text" class="form-control bg-white" id="doc_nf" value="<?php echo $doc_nf; ?>" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="tb_forma_pag_id">Forma de Pagamento</label>
                                    <input type="text" class="form-control bg-white" id="tb_forma_pag_id" value="<?php echo $pag; ?>" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="adms_bandeira_id">Bandeira</label>
                                    <input type="text" class="form-control bg-white" id="adms_bandeira_id" value="<?php echo $bandeira; ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="nsu">NSU</label>
                                    <input type="text" class="form-control bg-white" id="nsu" value="<?php echo $nsu; ?>" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="auto_cartao">Autorização - Cartão</label>
                                    <input type="text" class="form-control bg-white" id="auto_cartao" value="<?php echo $auto_cartao; ?>" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="adms_tps_est_id">Tipo de Estorno</label>
                                    <input type="text" class="form-control bg-white" id="adms_tps_est_id" value="<?php echo ($adms_tps_est_id = 1) ? "Total" : "Parcial"; ?>" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="adms_resp_aut_id">Motivo do Estorno</label>
                                <input type="text" class="form-control bg-white" id="adms_resp_aut_id" value="<?php echo $motivo; ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="adms_resp_aut_id">Responsável</label>
                                <input type="text" class="form-control bg-white" id="adms_resp_aut_id" value="<?php echo $resp; ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0"><p>Documentos:</p></h6>
                                            <small class="text-muted">
                                                <?php
                                                $types = array('png', 'jpg', 'jpeg', 'gif', 'xls', 'txt', 'doc', 'csv', 'pdf', 'docx', 'xlsx');
                                                $path = 'assets/files/estorno/' . $id . '/';
                                                $dir = new DirectoryIterator($path);
                                                foreach ($dir as $fileInfo) {
                                                    $ext = strtolower($fileInfo->getExtension());
                                                    if (in_array($ext, $types)) {
                                                        $arquivo = $fileInfo->getFilename();
                                                        echo "<span class='m-auto lead'>";
                                                        echo $arquivo . " - <a href='" . URLADM . "assets/files/estorno/$id/$arquivo' class='btn btn-outline-dark btn-sm' download><i class='fas fa-download'></i> Baixar</a><br>";
                                                        echo "</span>";
                                                    }
                                                }
                                                ?>
                                            </small>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="mb-3">
                                <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0"><p>Observações:</p></h6>
                                            <small class="text-muted lead"><?php echo $obs; ?></small>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Solicitação não encontrada!</div>";
    $UrlDestino = URLADM . 'estorno/listar';
    header("Location: $UrlDestino");
}