<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_policies'][0])) {
    extract($this->Dados['dados_policies'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Política</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_policies']) {
                            echo "<a href='" . URLADM . "policies/list' class='btn btn-outline-info btn-sm'><i class='fa-solid fa-list'></i></a> ";
                        }
                        if ($this->Dados['botao']['edit_policies']) {
                            echo "<a href='" . URLADM . "edit-policies/edit-policie/$id' class='btn btn-outline-warning btn-sm'><i class='fa-solid fa-pen-to-square'></i></a> ";
                        }
                        if ($this->Dados['botao']['del_policies']) {
                            echo "<a href='" . URLADM . "delete-policies/del-policie/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fa-solid fa-eraser'></i></a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                            <?php
                            if ($this->Dados['botao']['list_policies']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "policies/list'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_policies']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-policies/edit-policie/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_policies']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "delete-policies/del-policie/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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

            <h2 class="display-4 titulo mb-3">Conteúdo</h2>
            <dl class="row">
                <dt class="col-sm-3">Imagem</dt>
                <dd class="col-sm-9">                    
                    <?php
                    if (!empty($image)) {
                        echo "<img src='" . URLADM . "assets/imagens/policies/" . $id . "/" . $image . "' class='img img-thumbnail' width='250' height='120'>";
                    }
                    ?>
                </dd>

                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?php echo $id; ?></dd>

                <dt class="col-sm-3">Titulo</dt>
                <dd class="col-sm-9"><?php echo $title; ?></dd>

                <dt class="col-sm-3">Resumo Público</dt>
                <dd class="col-sm-9"><?php echo $description; ?></dd>

                <dt class="col-sm-3">Conteúdo</dt>
                <dd class="col-sm-9"><?php echo $content; ?></dd>

                <dt class="col-sm-3">Arquivos</dt>
                <dd class="col-sm-9">
                    <a href="<?php echo URLADM . 'assets/files/policies/' . $id . '/' . $link; ?>" download>
                        <?php echo $file_name; ?>
                    </a>                        
                </dd>

                <dt class="col-sm-3">Situação</dt>
                <dd class="col-sm-9">
                    <span class="badge badge-<?php echo $cor_cr; ?>"><?php echo $nome_sit; ?></span>
                </dd>

                <dt class="col-sm-3">Inserido</dt>
                <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></dd>

                <dt class="col-sm-3">Alterado</dt>
                <dd class="col-sm-9"><?php
                    if (!empty($modified)) {
                        echo date('d/m/Y H:i:s', strtotime($modified));
                    }
                    ?>
                </dd>
            </dl><hr>

            <h2 class="display-4 titulo">SEO</h2>
            <dl class="row">

                <dt class="col-sm-3">Slug</dt>
                <dd class="col-sm-9"><?php echo $slug; ?></dd>

                <dt class="col-sm-3">Palavra Chave</dt>
                <dd class="col-sm-9"><?php echo $keywords; ?></dd>

                <dt class="col-sm-3">Data Inicial</dt>
                <dd class="col-sm-9"><?php echo date('d/m/Y', strtotime($dataInicial)); ?></dd>

                <dt class="col-sm-3">Data Final</dt>
                <dd class="col-sm-9"><?php echo date('d/m/Y', strtotime($dataFinal)); ?></dd>

                <dt class="col-sm-3">Destaque</dt>
                <dd class="col-sm-9"><?php echo ($destaque = 1 ? "Sim" : "Não"); ?></dd>
            </dl>

        </div>
    </div>
    <?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    $UrlDestino = URLADM . 'policies/list';
    header("Location: $UrlDestino");
}
