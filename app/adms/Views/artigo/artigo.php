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
                if (!empty($this->Dados['visuArtigos'][0])) {
                    extract($this->Dados['visuArtigos'][0]);
                    ?>
                    <h2 class="display-4 titulo blog-post-title"><?php echo $titulo; ?></h2>
                    <?php
                }
                ?>
            </div>
            <div>
                <?php
                if ($this->Dados['botao']['list_art']) {
                    ?>
                    <a href="<?php echo URLADM . 'blog/listar'; ?>">
                        <div class="p-2">
                            <button class="btn btn-outline-info btn-sm"><span><i class="fas fa-list d-block d-md-none fa-2x"></i>
                                    <span class='d-none d-md-block'>Listar</span>
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
                <div class="col-md-9 blog-main border-right">
                    <?php
                    if (!empty($this->Dados['visuArtigos'][0])) {
                        extract($this->Dados['visuArtigos'][0]);
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
                <aside class="col-md-3 blog-sidebar">

                    <div class="card text-dark bg-light mb-3">
                        <div class="card-header p-3">
                            <h4 class="font-italic">Recentes</h4>
                        </div>
                        <div class="card-body">
                            <ol class="lead list-unstyled mb-0">
                                <?php
                                foreach ($this->Dados['artRecente'] as $artigoRec) {
                                    extract($artigoRec);
                                    if ($dias >= 0 && $dias <= 3) {
                                        echo "<li><a href='" . URLADM . "visu-artigo/index/$slug' style='text-decoration: none;'>$titulo</a></li>";
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
                                    echo "<li><a href='" . URLADM . "visu-artigo/index/$slug' style='text-decoration: none;'>$titulo</a></li>";
                                }
                                ?>
                            </ol>
                        </div>
                    </div>
                    <div class="card text-dark bg-light mb-3">
                        <div class="card-header p-3">
                            <h4 class="font-italic">Downloads</h4>
                        </div>
                        <div class="card-body">
                            <ol class="lead list-unstyled mb-0">
                                <?php
                                foreach ($this->Dados['visuArtigos'] as $arq) {
                                    extract($arq);
                                    echo "<li><a href='" . URLADM . "assets/download/$id_arq/$link' style='text-decoration: none;' download>$nome_arq</a></li>";
                                }
                                ?>
                            </ol>
                        </div>
                    </div>
                    <div class="card text-dark bg-light mb-3">
                        <div class="card-header p-3">
                            <h4 class="font-italic">Vigência</h4>
                        </div>
                        <div class="card-body">
                            <ol class="list-unstyled mb-0">
                                <?php
                                if (!empty($this->Dados['visuArtigos'][0])) {
                                    extract($this->Dados['visuArtigos'][0]);
                                    ?>
                                    <li class="lead font-weight-bold"><?php echo "Data Inicial: " . date('d/m/Y', strtotime($dataInicial)); ?></li>
                                    <li class="lead font-weight-bold"><?php echo "Data Final: " . date('d/m/Y', strtotime($dataFinal)); ?></li>
                                        <?php
                                    }
                                    ?>
                            </ol>
                        </div>
                    </div>
                </aside>
            </div>
            <?php
            if (!empty($this->Dados['visuArtigos'][0])) {
                extract($this->Dados['visuArtigos'][0]);
                if (!empty($modified)) {
                    echo "<hr><small class='text-muted'>" . 'Atualizado: ' . date('d/m/Y H:i:s', strtotime($modified)) . "</small>";
                }
            }
            ?>
        </main>
    </div>
</div>