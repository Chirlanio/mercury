<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_usuario'][0])) {
    extract($this->Dados['dados_usuario'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Ver Usuário</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_usuario']) {
                            echo "<a href='" . URLADM . "usuarios-treinamento/listar' class='btn btn-outline-info btn-sm'><i class='fa-solid fa-list'></i> Listar</a> ";
                        }
                        if ($this->Dados['botao']['edit_usuario']) {
                            echo "<a href='" . URLADM . "editar-usuario-treinamento/edit-usuario/$id' class='btn btn-outline-warning btn-sm'><i class='fa-solid fa-pen-nib'></i> Editar</a> ";
                        }
                        if ($this->Dados['botao']['edit_senha']) {
                            echo "<a href='" . URLADM . "editar-senha-treinamento/edit-senha/$id' class='btn btn-outline-danger btn-sm'><i class='fa-solid fa-key'></i> Editar Senha</a> ";
                        }
                        if ($this->Dados['botao']['del_usuario']) {
                            echo "<a href='" . URLADM . "apagar-usuario-treinamento/apagar-usuario/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fa-solid fa-eraser'></i> Apagar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_usuario']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "usuarios-treinamento/listar'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_usuario']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-usuario-treinamento/edit-usuario/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['edit_senha']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-senha-treinamento/edit-senha/$id'>Editar Senha</a>";
                            }
                            if ($this->Dados['botao']['del_usuario']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-usuario-treinamento/apagar-usuario/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
            <dl class="row">
                <dt class="col-sm-3">Foto</dt>
                <dd class="col-sm-9">                    
                    <?php
                    if (!empty($image)) {
                        echo "<img class='img-thumbnail' src='" . URLADM . "assets/imagens/usuario/treinamento/" . $id . "/" . $image . "' width='150' heigth='150'>";
                    } else {
                        echo "<img class='img-thumbnail' src='" . URLADM . "assets/imagens/usuario/icone_usuario.png' width='150' heigth='150'>";
                    }
                    ?>
                </dd>

                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?php echo $id; ?></dd>

                <dt class="col-sm-3">Nome</dt>
                <dd class="col-sm-9"><?php echo $nome; ?></dd>

                <dt class="col-sm-3">Usuário</dt>
                <dd class="col-sm-9"><?php echo $usuario; ?></dd>

                <dt class="col-sm-3">E-mail</dt>
                <dd class="col-sm-9"><?php echo $email; ?></dd>

                <dt class="col-sm-3">Recuperar Senha</dt>
                <dd class="col-sm-9"><?php
                    if (!empty($recuperar_senha)) {
                        echo URLADM . "atualizar-senha/atual-senha?chave=" . $recuperar_senha;
                    }
                    ?></dd>

                <dt class="col-sm-3">Nível de Acesso</dt>
                <dd class="col-sm-9"><?php echo $nome_nivac; ?></dd>

                <dt class="col-sm-3">Situação</dt>
                <dd class="col-sm-9">
                    <span class="badge badge-<?php echo $cor_cr; ?>"><?php echo $nome_sit; ?></span>
                </dd>

                <dt class="col-sm-3">Cadastrado</dt>
                <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></dd>

                <dt class="col-sm-3">Atualizazo</dt>
                <dd class="col-sm-9"><?php
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
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Usuário não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    $UrlDestino = URLADM . 'usuarios-treinamento/listar';
    header("Location: $UrlDestino");
}
