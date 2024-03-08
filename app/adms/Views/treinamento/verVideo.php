<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_video'][0])) {
    extract($this->Dados['dados_video'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
                <div class="mr-auto p-2">
                    <h2 class="titulo"><?php echo $titulo; ?></h2>
                    <h6 class="titulo display-4 text-muted Subscript"><?php echo $subtitulo; ?></h6>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_video']) {
                            echo "<a href='" . URLADM . "escola-digital/listar-videos' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i></a> ";
                        }
                        if ($this->Dados['botao']['edit_video']) {
                            echo "<a href='" . URLADM . "editar-video/edit-video/$id' class='btn btn-outline-warning btn-sm'><i class='fa-solid fa-pen-to-square'></i></a> ";
                        }
                        if ($this->Dados['botao']['del_video']) {
                            echo "<a href='" . URLADM . "apagar-video/apagar-video/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_video']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "escola-digital/listar-videos'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_video']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-video/edit-video/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_video']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-video/apagar-video/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
                
                <div class="row row-cols-1">
                    <video width="1280" height="960" controls>
                        <source src="<?php echo URLADM . 'assets/videos/treinamento/' . $id . '/' . $nome_video ?>" type="video/mp4">
                        <source src="<?php echo URLADM . 'assets/videos/treinamento/' . $id . '/' . $nome_video ?>" type="video/ogg">
                        <source src="<?php echo URLADM . 'assets/videos/treinamento/' . $id . '/' . $nome_video ?>" type="video/webm">
                        Your browser does not support the video tag.
                    </video>
                </div>
                
                <div class="row pt-3">
                    <strong class="m-1">Tema:</strong>
                    <span class="m-1"><?php echo $tema?></span>
                </div>
                
                <div class="row pt-3">
                    <strong class="m-1">Descrição do treinamento: </strong>
                    <p class="m-1 "><?php echo strip_tags($description)?></p>
                </div>
                
                <div class="row pt-3">
                    <small><?php echo (!empty($modified) ? "<strong>Atualizado:</strong> " . date('d/m/Y', strtotime($modified)) : "")?></small>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Treinamento não encontrado!</div>";
    $UrlDestino = URLADM . 'escola-digital/listar-videos';
    header("Location: $UrlDestino");
}