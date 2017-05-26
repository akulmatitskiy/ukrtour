<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use frontend\models\MenuItems;
use common\models\Languages;

$this->registerJsFile('/booking/static/js/jquery.min.js', [
    'position' => \yii\web\View::POS_HEAD
]);

// modals init
$modalJs = '$(".modal").modal();';
$this->registerJs($modalJs, $this::POS_READY);

AppAsset::register($this);

// Body id
if(!empty($this->context->bodyId)) {
    $bodyId = 'id="' . $this->context->bodyId . '"';
} else {
    $bodyId = '';
}
// Menu items
$menuItems = MenuItems::getMainMenu();

// Datepicker locale
if(Yii::$app->language != Languages::LANG_EN) {
    $this->registerJsFile('/theme/js/pickadate_' . Yii::$app->language . '.js');
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Languages::getIsoCode() ?>">
    <head>
        <meta charset="<?php echo Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?php echo Html::csrfMetaTags() ?>
        <title><?php echo Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <script>
             (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
             (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
             m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
             })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

             ga('create', 'UA-90808900-1', 'auto');
             ga('send', 'pageview');
        </script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter42310869 = new Ya.Metrika({
                    id:42310869,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/42310869" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
    </head>
    <body <?php echo $bodyId ?>>
        <?php $this->beginBody() ?>
        <div id="main-wrapper">
            <?php echo $this->render('_header', ['menuItems' => $menuItems]) ?>
            <?php echo $content ?>
        </div>
        <footer id="footer">
            <?php echo $this->render('_footer', ['menuItems' => $menuItems]) ?>
        </footer>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
