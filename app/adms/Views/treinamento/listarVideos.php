<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 mb-4 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Treinamentos</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->Dados['botao']['cad_video']) {
                    echo "<a href='" . URLADM . "cadastrar-video/cad-videos' class='btn btn-outline-success btn-sm'><i class='fa-solid fa-square-plus'></i> Novo</a> ";
                }
                ?>                
            </div>
        </div>
        <form class="form d-print-none" method="POST" action="<?php echo URLADM . 'pesq-videos/listar'; ?>" enctype="multipart/form-data"> 
            <div class="row">
                <div class="col-sm-12 col-lg-12 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="font-weight: bold;" for="titulo"><i class="fa-solid fa-magnifying-glass"></i></label>
                        </div>
                        <input name="titulo" type="text" id="titulo" class="form-control" placeholder="Digite o Título ou Subtitulo do treinamento" value="<?php
                        if (isset($_SESSION['titulo'])) {
                            echo $_SESSION['titulo'];
                        }
                        ?>">
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="form-group ml-sm-3 ml-md-3 ml-lg-3 ml-3">
                    <input name="PesqVideo" type="submit" class="btn btn-outline-primary" value="Pesquisar">
                </div>
            </div>
        </form><hr>
        <?php
        if (empty($this->Dados['listVideos'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum treinamento encontrado!
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
        <div>

            <div class="card-deck mb-2 row row-cols-1 row-cols-md-3">
                <?php
                foreach ($this->Dados['listVideos'] as $video) {
                    extract($video);
                    ?>

                    <div class="card">
                        <img src="<?php echo URLADM . 'assets/imagens/treinamento/' . $id . '/' . $image_thumb ?>" class="card-img-top" alt="<?php echo $titulo; ?>" width="320" height="240">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $titulo; ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo $subtitulo; ?></h6>
                            <hr>
                            <h6 class="card-subtitle mb-2 text-muted">Descrição:</h6>
                            <p class="card-text"><?php echo $description; ?></p>
                            <p class="card-text"><?php echo (!empty($modified) ? "<hr><strong>Atualizado:</strong> " . date('d/m/Y', strtotime($modified)) : ""); ?></p>
                        </div>
                        <div class="card-footer text-center">
                            <small class="text-muted">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['vis_video']) {
                                        echo "<a href='" . URLADM . "ver-video/ver-video/$id' class='btn btn-outline-primary btn-sm'></i> <strong>Assistir </strong><i class='fa-solid fa-play'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['edit_video']) {
                                        echo "<a href='" . URLADM . "editar-video/edit-video/$id' class='btn btn-outline-warning btn-sm'><i class='fas fa-pen-fancy'></i> Editar</a> ";
                                    }
                                    if ($this->Dados['botao']['del_video']) {
                                        echo "<a href='" . URLADM . "apagar-video/apagar-video/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i> Apagar</a> ";
                                    }
                                    ?>
                                </span>
                            </small>
                        </div>
                    </div>

                    <?php
                }
                ?>
            </div>

            <?php
            echo $this->Dados['paginacao'];
            ?>
        </div>
    </div>
</div>
