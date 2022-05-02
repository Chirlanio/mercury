<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_ordem_servico'][0])) {
    extract($this->Dados['dados_ordem_servico'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Detalhes da Ordem de Serviço</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_ordem_servico']) {
                            echo "<a href='" . URLADM . "ordem-servico/listar' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i> Listar</a> ";
                        }
                        if ($this->Dados['botao']['edit_ordem_servico']) {
                            echo "<a href='" . URLADM . "editar-ordem-servico/edit-ordem-servico/$id' class='btn btn-outline-warning btn-sm'><i class='fas fa-pen-fancy'></i> Editar</a> ";
                        }
                        if ($this->Dados['botao']['del_ordem_servico']) {
                            echo "<a href='" . URLADM . "apagar-ordem-servico/apagar-ordem-servico/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i> Apagar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_ordem_servico']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "ordem-servico/listar'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_ordem_servico']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-ordem-servico/edit-ordem-servico/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_ordem_servico']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-ordem-servico/apagar-ordem-servico/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
                            <span class="text-muted">Resultado - Ordem de Serviço</span>
                        </h4>
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-2">Data - Transferência:</h6>
                                    <small class="text-muted lead"><?php echo date("d/m/Y", strtotime($data_emissao_nota_transf)); ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-2">Confirmação - Transferência:</h6>
                                    <small class="text-muted lead"><?php echo date("d/m/Y", strtotime($data_confir_nota_transf)); ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-2">Diferença:</h6>
                                    <small class="text-muted lead" ><?php echo $data_dif_emissao_confir; ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between bg-light">
                                <div>
                                    <h6 class="my-2">Nota - Devolução:</h6>
                                    <small class="lead"><?php echo $nf_conserto_devolucao; ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-2">Data - Emissão:</h6>
                                    <small class="lead"><?php echo date('d/m/Y', strtotime($data_emissao_conserto)); ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between bg-light">
                                <div>
                                    <h6 class="my-2">Nota - Retorno:</h6>
                                    <small class="lead"><?php echo $nf_retorno_conserto; ?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-2">Data - Confirmação:</h6>
                                    <small class="lead"><?php echo date('d/m/Y', strtotime($data_confir_retorno_conserto)); ?></small>
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
                        <h4 class="mb-3">Dados da Ordem de Serviço</h4>
                        <form class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="loja_id">Loja</label>
                                    <input type="text" class="form-control bg-white" id="loja_id" readonly value="<?php echo $loja; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tipo_ordem_id">Tipo:</label>
                                    <input type="text" class="form-control bg-white" id="tipo_ordem_id" value="<?php echo $tipo; ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="referencia">Referência</label>
                                    <input type="text" class="form-control bg-white" id="referencia" value="<?php echo $referencia; ?>" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="tam_id">Tamanho</label>
                                    <input type="text" class="form-control bg-white" id="tam_id" value="<?php echo $tam; ?>" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="reftam">RefTam</label>
                                    <input type="text" class="form-control bg-white" id="reftam" value="<?php echo $reftam; ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="cod_barras">Código de Barras</label>
                                    <input type="text" class="form-control bg-white" id="cod_barras" value="<?php echo $cod_barras; ?>" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="marca_id">Marca</label>
                                    <input type="text" class="form-control bg-white" id="marca_id" value="<?php echo $marca; ?>" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="qtde">Quantidade</label>
                                    <input type="text" class="form-control bg-white" id="qtde" value="<?php echo $qtde; ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="loja_id_conserto">Loja - Conserto</label>
                                    <input type="text" class="form-control bg-white" id="loja_id_conserto" value="<?php echo $loja_conserto; ?>" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="loja_id_conserto">Situação</label>
                                    <input type="text" class="form-control bg-white" id="loja_id_conserto" value="<?php echo $sit; ?>" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="ordem_servico">Ordem de Serviço</label>
                                    <input type="text" class="form-control bg-white" id="ordem_servico" value="<?php echo $ordem_servico; ?>" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0"><p>Observações - Loja:</p></h6>
                                            <small class="text-muted lead"><?php echo $obs_loja; ?></small>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="mb-3">
                                <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0"><p>Observações - Qualidade:</p></h6>
                                            <small class="text-muted lead"><?php echo $obs_qualidade; ?></small>
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
    $UrlDestino = URLADM . 'ordem-conserto/listar';
    header("Location: $UrlDestino");
}