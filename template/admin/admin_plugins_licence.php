<?php
if (!defined('IN_TEMPLATE')) {
    exit('Access denied');
}
?>
<div class="container">
    <div class="row">
        <div class="col-lg-offset-3 col-lg-6 login_form">
            <center>
                <h3><?=htmlentities($tmpl['class']::NAME)?><br>
                    <small class="login_sub_title">Terms & Conditions<br>
                    <?=htmlentities($tmpl['class']::COPYRIGHT)?>
                    </small>
                </h3>
                <div class="container-fluid">
                    <div>
                        <div id="license">
                            <?php Render::renderSingleTemplate($tmpl['licence'][0], $tmpl['licence'][1]); ?>
                        </div>
                    </div>
                    <div style = "text-align: right">
                        <a class="btn btn-danger" href="#" tmpl="plugins/list/?folder=<?=urlencode($tmpl['folder'])?>">返回列表</a>
                        <a class="btn btn-success" href="#" tmpl="plugins/install/<?=base64_encode($tmpl['folder'])?>/<?=base64_encode($tmpl['class'])?>?key=<?=$tmpl['key']?>">I accept these terms</a>
                    </div>
                    <br><br>
                </div>
            </center>
        </div>
    </div>
</div>
