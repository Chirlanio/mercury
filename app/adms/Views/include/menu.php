<header class="d-print-none">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
        <div class="container-fluid">

            <a class="navbar-brand" href="<?php echo URLADM; ?>">
                <img src="<?php echo URLADM; ?>assets/imagens/logo/logo_transp.png" width="110" height="45" class="d-inline-block align-top" alt="" loading="lazy">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <?php
                    foreach ($this->Dados['menu'] as $menu) {
                        extract($menu);
                        ?>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo URLADM . $link; ?>"><?php echo $nome_pagina; ?></a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <ul class="navbar-nav mr-sm-4">
                    <li class="nav-item"><a href="logout.php" class="nav-item nav-link" id="navbar" role="button">
                            Sair <img src="imagem/icons/ion-log-out.svg" class="ion-log-out" alt=""></span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
