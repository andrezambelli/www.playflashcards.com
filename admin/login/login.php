<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_ADMIN . '/config.inc' ?>
<?php include_once CAR_ROOT_ADMIN . '/containers/header.inc' ?>
<?php
    $redirect_url = '';
    if (isset($_GET['redirect_url'])) $redirect_url = trim($_GET['redirect_url']);
?>
<div class="container-lg py-5">
    <div class="row justify-content-center">
        <div class="col-sm-8 col-md-5 col-lg-4">
            <?php include_once CAR_ROOT_ADMIN . '/containers/message.inc' ?>
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4">Login</h5>
                    <form action="login-act.php" method="post">
                        <input type="hidden" name="redirect_url" value="<?= car_htmlspecialchars($redirect_url); ?>">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" maxlength="100" class="form-control">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once CAR_ROOT_ADMIN . '/containers/footer.inc' ?>
