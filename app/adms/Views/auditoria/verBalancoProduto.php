<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_balanco'][0])) {
    extract($this->Dados['dados_balanco'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Detalhes do Produto</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_balanco_produto']) {
                            echo "<a href='" . URLADM . "balanco-produto/listar/$balanco_id' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i> Listar</a> ";
                        }
                        if ($this->Dados['botao']['edit_balanco_produto']) {
                            echo "<a href='" . URLADM . "editar-balanco-produto/edit-balanco/$id' class='btn btn-outline-warning btn-sm'><i class='fas fa-pen-fancy'></i> Editar</a> ";
                        }
                        if ($this->Dados['botao']['del_balanco_produto']) {
                            echo "<a href='" . URLADM . "apagar-balanco-produto/apagar-balanco/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i> Apagar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_balanco_produto']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "balanco-produto/listar'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_balanco_produto']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-balanco-produto/edit-balanco/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_balanco_produto']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-balanco-produto/apagar-balanco/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
                <h4 class="mb-3">Dados da Contagem</h4>
                <div class="img-media mb-3">
                    <?php
                    $filePath = "http://www.meiasola.com/powerbi/image/$referencia.jpg";
                    if (!file_exists($filePath)) {
                        echo "<img class='img-media img-thumbnail img-fluid' src='http://www.meiasola.com/powerbi/image/$referencia.jpg' alt='$referencia' />";
                    } else {
                        echo "<img class='img-media img-thumbnail img-fluid' src='" . URLADM . "/assets/imagens/naodisp.jpg' alt='$referencia' alt='$referencia' />";
                    }
                    ?>
                </div>
                <form class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="referencia">Referência</label>
                            <input type="text" class="form-control bg-white" id="referencia" readonly value="<?php echo $referencia; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="cod_barras">Código Barras</label>
                            <input type="text" class="form-control bg-white" id="cod_barras" value="<?php echo $cod_barras; ?>" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tam">Tamanho</label>
                            <input type="text" class="form-control bg-white text-center" id="tam" value="<?php echo $tam; ?>" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="qtde_estoque">Estoque</label>
                            <input type="text" class="form-control bg-white text-center" id="qtde_estoque" value="<?php echo $qtde_estoque; ?>" readonly>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="qtde_contagem">Contagem</label>
                            <input type="text" class="form-control bg-white text-center" id="qtde_contagem" value="<?php echo $qtde_contagem; ?>" readonly>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="qtde_divergencia">Divergência</label>
                            <input type="text" class="form-control bg-white text-center" id="qtde_divergencia" value="<?php echo $qtde_divergencia; ?>" readonly>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="qtde_divergencia">Tipo</label>
                            <input type="text" class="form-control bg-white" id="qtde_divergencia" value="<?php echo $tipo; ?>" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="situacao">Situação</label>
                            <input type="text" class="form-control bg-white" id="situacao" value="<?php echo $situacao; ?>" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="solucao">Solução</label>
                            <input type="text" class="form-control bg-white" id="solucao" value="<?php echo $solucao; ?>" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="obs_justificativa">Observações</label>
                            <input type="text" class="form-control bg-white" id="obs_justificativa" value="<?php echo strip_tags($obs_justificativa); ?>" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Imagens</label><hr>
                        <?php
                        if (empty($img_um) and empty($img_dois) and empty($img_tres)) {
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Nenhum foto encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                        } else {
                            if (!empty($img_um)) {
                                echo "<img class='imagem img-thumbnail' id='img_um' src='" . URLADM . "assets/imagens/balanco/$id/$img_um' />";
                            }
                            if (!empty($img_dois)) {
                                echo "<img class='imagem img-thumbnail' id='img_dois' src='" . URLADM . "assets/imagens/balanco/$id/$img_dois' />";
                            }
                            if (!empty($img_tres)) {
                                echo "<img class='imagem img-thumbnail' id='img_tres' src='" . URLADM . "assets/imagens/balanco/$id/$img_tres' />";
                            }
                        }
                        ?>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0"><p>Documentos:</p></h6>
                                    <small class="text-muted">
                                        <?php
                                        $types = array('png', 'jpg', 'jpeg', 'gif', 'xls', 'txt', 'doc', 'csv', 'pdf', 'docx', 'xlsx');
                                        $path = 'assets/imagens/balanco/' . $id . '/';
                                        try {
                                            $dir = new DirectoryIterator($path);
                                            foreach ($dir as $fileInfo) {
                                                $ext = strtolower($fileInfo->getExtension());
                                                if (in_array($ext, $types)) {
                                                    $arquivo = $fileInfo->getFilename();
                                                    echo "<span class='m-auto lead'>";
                                                    echo $arquivo . " - <a href='" . URLADM . "assets/imagens/balanco/$id/$arquivo' class='btn btn-outline-primary btn-sm mr-2' download><i class='fas fa-download'></i> Baixar</a>";
                                                    echo "</span>";
                                                }
                                            }
                                        } catch (Exception $exc) {
                                            echo "<span class='lead'>Nenhuma imagem ou documento enviado...</span>";
                                        }
                                        ?>
                                    </small>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0"><p>Resposta:</p></h6>
                                    <small class="text-muted lead"><?php echo $obs_resposta; ?></small>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="status_id">Status</label>
                            <input type="text" class="form-control bg-white" id="status_id" value="<?php echo $status; ?>" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="created">Cadatrado</label>
                            <input type="text" class="form-control bg-white text-center" id="created" value="<?php echo date('d/m/Y H:i:s', strtotime($created)); ?>" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="modified">Atualizado</label>
                            <input type="text" class="form-control bg-white text-center" id="modified" value="<?php
                                    if (!empty($modified)) {
                                        echo date('d/m/Y H:i:s', strtotime($modified));
                                    }
                                        ?>" readonly>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Solicitação não encontrada!</div>";
    $UrlDestino = URLADM . 'balanco-produto/listar';
    header("Location: $UrlDestino");
}    