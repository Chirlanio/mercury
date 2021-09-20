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
                <h2 class="display-4 titulo">FAQ - Grupo Meia Sola</h2>
            </div>
        </div><hr>
        <div class="row">
            <div class="col-md-12 blog-main">
                <?php
                if (empty($this->Dados['listFaq'])) {
                    echo "<div class='alert alert-danger'>Erro: Nenhum artigo encontrado!</div>";
                }
                $cont_artigo = 1;
                if (!empty($this->Dados['listFaq'])) {
                    foreach ($this->Dados['listFaq'] as $art) {
                        extract($art);
                        if ($cont_artigo == 1) {
                            ?>
                            <div class="row featurette">
                                <div class="col-md-7 order-md-2 anima-right">
                                    <a href="<?php echo URLADM . 'visu-faq/index/' . $slug; ?>" style="text-decoration: none;">
                                        <h2 class="featurette-heading text-primary"><?php echo $titulo; ?></h2>
                                    </a>
                                    <p class="lead"><?php echo strip_tags($resumo_publico); ?> <a href="<?php echo URLADM . 'visu-faq/index/' . $slug; ?>" style="text-decoration: none;" class="text-primary">Continuar lendo</a></p>
                                </div>
                                <div class="col-md-5 order-md-1 anima-left">
                                    <img class="featurette-image img-fluid img-thumbnail mx-auto" src="<?php echo URLADM . 'assets/imagens/artigos/' . $id . '/' . $imagem; ?>" alt="<?php echo $titulo; ?>">
                                </div>
                            </div>
                            <hr class="featurette-divider">
                            <?php
                            $cont_artigo = 2;
                        } else {
                            ?>
                            <div class = "row featurette">
                                <div class = "col-md-7 anima-left">
                                    <a href="<?php echo URLADM . 'visu-faq/index/' . $slug; ?>" style="text-decoration: none;">
                                        <h2 class="featurette-heading text-primary"><?php echo $titulo; ?></h2>
                                    </a>
                                    <p class="lead"><?php echo strip_tags($resumo_publico); ?> <a href="<?php echo URLADM . 'visu-artigo/index/' . $slug; ?>"  style="text-decoration: none;" class="text-primary">Continuar lendo</a></p>
                                </div>
                                <div class = "col-md-5 anima-right">
                                    <img class = "featurette-image img-fluid img-thumbnail mx-auto" src = "<?php echo URLADM . 'assets/imagens/artigos/' . $id . '/' . $imagem; ?>" alt="<?php echo $titulo; ?>">
                                </div>
                            </div>
                            <hr class = "featurette-divider">
                            <?php
                            $cont_artigo = 1;
                        }
                    }
                }
                echo $this->Dados['paginacao'];
                ?>
            </div>
        </div>
    </div>
</div>