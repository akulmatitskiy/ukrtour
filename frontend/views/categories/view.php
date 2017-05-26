<?php
/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = Yii::t('app', 'Hotels');

// Meta Description
if(!empty($category->descr->meta_description)) {
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $category->descr->meta_description
    ]);
}

//var_dump($hotels);
//exit;
?>
<?php echo $this->render('/banners/carousel', ['banners' => $banners]) ?>
