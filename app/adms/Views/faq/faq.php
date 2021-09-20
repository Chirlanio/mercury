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
                <?php
                if (!empty($this->Dados['visuFaq'][0])) {
                    extract($this->Dados['visuFaq'][0]);
                    ?>
                    <h2 class="display-4 titulo blog-post-title"><?php echo $titulo; ?></h2>
                    <?php
                }
                ?>
            </div>
            <div>
                <?php
                if ($this->Dados['botao']['list_faq']) {
                    ?>
                    <a href="<?php echo URLADM . 'faq/listar'; ?>">
                        <div class="p-2">
                            <button class="btn btn-outline-info btn-sm"><span><i class="fas fa-list d-block d-md-none fa-2x"></i>
                                    <span class='d-none d-md-block'>Voltar</span>
                                </span>
                            </button>
                        </div>
                    </a>
                    <?php
                }
                ?>
            </div>
        </div><hr>
        <main role="main">
            <div class="row">
                <div class="col-md-12 blog-main">
                    <?php
                    if (!empty($this->Dados['visuFaq'][0])) {
                        extract($this->Dados['visuFaq'][0]);
                        ?>
                        <div class="blog-post">
                            <div class="text-center">
                                <img src="<?php echo URLADM . 'assets/imagens/artigos/' . $id . '/' . $imagem; ?>" class="img-fluid img-thumbnail shadow mt-2" alt="<?php echo $titulo; ?>" style="margin-bottom: 20px; border-radius: 0px 20px 0px 0px;"><br>
                                <?php echo strip_tags($descricao) . "<small class='text-muted'>" . ' Publicado: ' . date('d/m/Y H:i:s', strtotime($created)) . "</small>"; ?>
                            </div>
                            <hr>
                            <?php echo $conteudo; ?>
                        </div>

                        <?php
                    } else {
                        echo "<div class='alert alert-danger'>Erro: Artigo não encontrado!</div>";
                    }
                    ?>      
                </div>
            </div>
            <?php
            if (!empty($this->Dados['visuFaq'][0])) {
                extract($this->Dados['visuFaq'][0]);
                if (!empty($modified)) {
                    echo "<hr><small class='text-muted'>" . 'Atualizado: ' . date('d/m/Y H:i:s', strtotime($modified)) . "</small>";
                }
            }
            ?>
        </main>
    </div>
</div>