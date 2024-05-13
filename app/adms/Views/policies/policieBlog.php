<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Políticas</h2>
            </div>
        </div><hr>
        <div class="row">
            <div class="col-md-8 blog-main border-right">
                <?php
                if (empty($this->Dados['listPolicies'])) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Nenhuma Polítca não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                }
                $cont_policie = 1;
                if (!empty($this->Dados['listPolicies'])) {
                    foreach ($this->Dados['listPolicies'] as $policie) {
                        extract($policie);
                        if ($cont_policie == 1) {
                            ?>
                            <div class="row featurette">
                                <div class="col-md-7 order-md-2" id="anim-right">
                                    <a href="<?php echo URLADM . 'view-policie-blog/index/' . $slug; ?>">
                                        <h2 class="featurette-heading text-primary"><?php echo $title; ?></h2>
                                    </a>
                                    <p class="lead"><?php echo strip_tags($public_summary); ?> <a href="<?php echo URLADM . 'view-policie-blog/index/' . $slug; ?>" style="text-decoration: none;" class="text-primary">Continuar lendo</a></p>
                                </div>
                                <div class="col-md-5 order-md-1" id="anim-left">
                                    <img class="featurette-image img-fluid img-thumbnail mx-auto" src="<?php echo URLADM . 'assets/imagens/policies/' . $id . '/' . $image; ?>" alt="<?php echo $title; ?>">
                                </div>
                            </div>
                            <hr class="featurette-divider">
                            <?php
                            $cont_policie = 2;
                        } else {
                            ?>
                            <div class = "row featurette">
                                <div class = "col-md-7 anim_left">
                                    <a href="<?php echo URLADM . 'view-policie-blog/index/' . $slug; ?>">
                                        <h2 class="featurette-heading text-primary"><?php echo $title; ?></h2>
                                    </a>
                                    <p class="lead"><?php echo strip_tags($public_summary); ?> <a href="<?php echo URLADM . 'view-policie-blog/index/' . $slug; ?>"  style="text-decoration: none;" class="text-primary">Continuar lendo</a></p>
                                </div>
                                <div class = "col-md-5 anim_right">
                                    <img class = "featurette-image img-fluid img-thumbnail mx-auto" src = "<?php echo URLADM . 'assets/imagens/policies/' . $id . '/' . $image; ?>" alt="<?php echo $title; ?>">
                                </div>
                            </div>
                            <hr class = "featurette-divider">
                            <?php
                            $cont_policie = 1;
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
                                    echo "<li><a href='" . URLADM . "view-policie-blog/index/$slug'>$title</a></li>";
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
                                echo "<li><a href='" . URLADM . "view-policie-blog/index/$slug'>$title</a></li>";
                            }
                            ?>
                        </ol>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>