<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
//var_dump($this->Dados['viewPolicie']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <?php
                if (!empty($this->Dados['viewPolicie'][0])) {
                    extract($this->Dados['viewPolicie'][0]);
                    ?>
                    <h2 class="display-4 titulo blog-post-title"><?php echo $title; ?></h2>
                    <?php
                }
                ?>
            </div>
            <div class="p-2">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['list_policies']) {
                        echo "<a href='" . URLADM . "policie-blog/list' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i></a> ";
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
                            echo "<a class='dropdown-item' href='" . URLADM . "policie-blog/list'>Listar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <main role="main">
            <div class="row">
                <div class="col-md-9 blog-main border-right">
                    <?php
                    if (!empty($this->Dados['viewPolicie'][0])) {
                        extract($this->Dados['viewPolicie'][0]);
                        ?>
                        <div class="blog-post">
                            <div class="text-center">
                                <img src="<?php echo URLADM . 'assets/imagens/policies/' . $id . '/' . $image; ?>" class="img-fluid img-thumbnail shadow mt-2" alt="<?php echo $title; ?>" style="margin-bottom: 20px; border-radius: 0px 20px 0px 0px;"><br>
                                <?php echo strip_tags($description) . "<small class='text-muted'><br>" . ' Publicado: ' . date('d/m/Y H:i:s', strtotime($created)) . "</small>"; ?>
                            </div>
                            <hr>
                            <?php echo $content; ?>
                        </div>

                        <?php
                    } else {
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Política não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                    }
                    ?>      
                </div>
                <aside class="col-md-3 blog-sidebar">

                    <div class="card text-dark bg-light mb-3">
                        <div class="card-header p-3">
                            <h4 class="font-italic">Recentes</h4>
                        </div>
                        <div class="card-body">
                            <ol class="list-unstyled mb-0">
                                <?php
                                foreach ($this->Dados['artRecente'] as $artigoRec) {
                                    extract($artigoRec);
                                    if ($dias >= 0 && $dias <= 3) {
                                        echo "<li><a href='" . URLADM . "view-policie-blog/index/$slug' style='text-decoration: none;'>$title</a></li>";
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
                            <ol class="list-unstyled mb-0">
                                <?php
                                foreach ($this->Dados['artDestaque'] as $artigoDest) {
                                    extract($artigoDest);
                                    echo "<li><a href='" . URLADM . "view-policie-blog/index/$slug' style='text-decoration: none;'>$title</a></li>";
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
                            <ol class="list-unstyled mb-0">
                                <?php
                                foreach ($this->Dados['viewPolicie'] as $file) {
                                    extract($file);
                                    echo "<li><a href='" . URLADM . "assets/files/policie/$id/$link' style='text-decoration: none;' download>$file_name</a></li>";
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
                                if (!empty($this->Dados['viewPolicie'][0])) {
                                    extract($this->Dados['viewPolicie'][0]);
                                    ?>
                                    <li class="font-weight-bold"><?php echo "Data Inicial: " . date('d/m/Y', strtotime($dataInicial)); ?></li>
                                    <li class="font-weight-bold"><?php echo "Data Final: " . date('d/m/Y', strtotime($dataFinal)); ?></li>
                                    <?php
                                }
                                ?>
                            </ol>
                        </div>
                    </div>
                </aside>
            </div>
            <?php
            if (!empty($this->Dados['viewPolicie'][0])) {
                extract($this->Dados['viewPolicie'][0]);
                if (!empty($modified)) {
                    echo "<hr><small class='text-muted'>" . 'Atualizado: ' . date('d/m/Y H:i:s', strtotime($modified)) . "</small>";
                }
            }
            ?>
        </main>
    </div>
</div>