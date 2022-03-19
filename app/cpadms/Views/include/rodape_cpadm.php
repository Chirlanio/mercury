<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
?>
</div>
<footer class="footer mt-auto py-3 bg-dark">
    <div class="container text-center navbar-fixed-bottom">
        <span class="text-muted">&copy; Grupo Meia Sola 2022</span>
    </div>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="<?php echo URLADM . 'assets/js/popper.min.js'; ?>"></script>
<script src="<?php echo URLADM . 'assets/js/bootstrap.min.js'; ?>"></script>
<script src="<?php echo URLADM . 'assets/js/dashboard.js'; ?>"></script>
<script src="<?php echo URLADM . 'app/cpadms/assets/js/dashboard_cpadms.js'; ?>"></script>
</body>
