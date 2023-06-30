<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
extract($this->Dados['select']);
//var_dump($this->Dados['select']);
?>
<div class="content p-1">
    <div class="list-group-item">

        <!-- inicio NavBar -->
        <div class="d-flex">
            <div class="mr-auto p-2"> 
                <h2 class="display-4 titulo"><?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5) {
                        $nome = explode(" ", $_SESSION['nome_gerente']);
                        if (!empty($nome[1])) {
                            $prim_nome = $nome[0];
                        } else {
                            $prim_nome = $nome[1];
                        }
                        echo "Bem vindo(a), " . $prim_nome . " e equipe - " . $_SESSION['nome_loja'];
                    } else {
                        echo "Bem vindo(a), " . $prim_nome;
                    }
                    ?>
                </h2>
            </div>
        </div>
        <!-- Final NavBar -->

        <hr>

        <!-- Inicio Cards -->
        <div class="row">
            <!-- Inicio Cards Treinamentos-->
            <div class="col-lg-6 col-sm-6 mb-3">
                <div class="card bg-success text-white anima-left-delay">
                    <a href="<?php echo URLADM . 'escola-digital/listar-videos/'; ?>" class="text-white text-decoration-none">
                        <div class="card-body">
                            <i class="fa-solid fa-video fa-3x"></i>
                            <?php
                            foreach ($this->Dados['select']['vid'] as $aj) {
                                extract($aj);
                                ?>
                                <h6 class="card-title blockquote">Treinamentos</h6>
                                <figcaption class="blockquote-footer text-white">
                                    Total de <cite title="Treinamentos">treinamentos</cite> disponíveis.
                                </figcaption>
                                <h2 class="lead text-right mt-4" style="font-size: 30px !important;" ><?php echo $video; ?></h2>
                                <?php
                            }
                            ?>
                        </div>
                    </a>
                </div>
            </div>
            <!-- Final Cards Treinamentos-->

            <!-- Inicio Cards Colaboradores-->
            <?php
            if ($_SESSION['adms_niveis_acesso_id'] != 13) {
                ?>
                <div class="col-lg-6 col-sm-6 mb-3">
                    <div class="card bg-danger text-white anima-left">
                        <div class="text-white text-decoration-none">
                            <div class="card-body">
                                <i class="fa-solid fa-users fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['col'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title blockquote">Colaboradores</h6>
                                    <figcaption class="blockquote-footer text-white">
                                        Total de <cite title="Colaboradores">colaboradores</cite> cadastrados.
                                    </figcaption>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php echo $colab; ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                <!-- Final Cards Colaboradores-->
            </div>
        </div>
    </div>
</div>