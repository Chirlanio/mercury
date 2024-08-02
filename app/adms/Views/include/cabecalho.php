<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">        
        <title>Mercury - Grupo Meia Sola</title>
        <link rel="icon" href="<?php echo URLADM . 'assets/imagens/icone/favicon.ico'; ?>">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
        <link rel="stylesheet" href="<?php echo URLADM . 'assets/css/floating-labels.css'; ?>">
        <link rel="stylesheet" href="<?php echo URLADM . 'assets/css/dashboard.css'; ?>">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    </head>
    <body>