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
                <h2 class="display-4 titulo">Campanhas & Novidades</h2>
            </div>
        </div><hr>
        <div class="row">
            <div class="col-md-8 blog-main border-right">
                <?php
                if (empty($this->Dados['listArtigo'])) {
                    echo "<div class='alert alert-danger'>Erro: Nenhum artigo encontrado!</div>";
                }
                $cont_artigo = 1;
                if (!empty($this->Dados['listArtigo'])) {
                    foreach ($this->Dados['listArtigo'] as $art) {
                        extract($art);
                        if ($cont_artigo == 1) {
                            ?>
                            <div class="row featurette">
                                <div class="col-md-7 order-md-2" id="anim-right">
                                    <a href="<?php echo URLADM . 'visualizar-artigo/index/' . $slug; ?>">
                                        <h2 class="featurette-heading text-primary"><?php echo $titulo; ?></h2>
                                    </a>
                                    <p class="lead"><?php echo strip_tags($resumo_publico); ?> <a href="<?php echo URLADM . 'visualizar-artigo/index/' . $slug; ?>" style="text-decoration: none;" class="text-primary">Continuar lendo</a></p>
                                </div>
                                <div class="col-md-5 order-md-1" id="anim-left">
                                    <img class="featurette-image img-fluid img-thumbnail mx-auto" src="<?php echo URLADM . 'assets/imagens/artigos/' . $id . '/' . $imagem; ?>" alt="<?php echo $titulo; ?>">
                                </div>
                            </div>
                            <hr class="featurette-divider">
                            <?php
                            $cont_artigo = 2;
                        } else {
                            ?>
                            <div class = "row featurette">
                                <div class = "col-md-7 anim_left">
                                    <a href="<?php echo URLADM . 'visualizar-artigo/index/' . $slug; ?>">
                                        <h2 class="featurette-heading text-primary"><?php echo $titulo; ?></h2>
                                    </a>
                                    <p class="lead"><?php echo strip_tags($resumo_publico); ?> <a href="<?php echo URLADM . 'visualizar-artigo/index/' . $slug; ?>"  style="text-decoration: none;" class="text-primary">Continuar lendo</a></p>
                                </div>
                                <div class = "col-md-5 anim_right">
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
            <aside class="col-md-4 blog-sidebar">
                <div class="card text-dark bg-light mb-3">
                    <div class="card-header p-3">
                        <h4 class="font-italic">Recentes</h4>
                    </div>
                    <div class="card-body">
                        <ol class="lead list-unstyled mb-0">
                            <?php
                            foreach ($this->Dados['artRecente'] as $artigoRec) {
                                extract($artigoRec);
                                if ($dias <= 10) {
                                    echo "<li><a href='" . URLADM . "visualizar-artigo/index/$slug'>$titulo</a></li>";
                                }
                            }
                            ?>
                        </ol>
                    </div>
                </div>
                <div class="card text-dark bg-light mb-3">
                    <div class="card-header p-3">
                        <h4 class="font-italic">Destaque</h4>
                    </div>
                    <div class="card-body">
                        <ol class="lead list-unstyled mb-0">
                            <?php
                            foreach ($this->Dados['artDestaque'] as $artigoDest) {
                                extract($artigoDest);
                                echo "<li><a href='" . URLADM . "visualizar-artigo/index/$slug'>$titulo</a></li>";
                            }
                            ?>
                        </ol>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>