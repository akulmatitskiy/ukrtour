<?php
/* @var $this yii\web\View */

// Meta title
$metaTitle = $category->descr->meta_title;
if(empty($metaTitle)) {
    $metaTitle = $category->descr->title;
}
$this->title = $metaTitle;

// Meta Description
if(!empty($category->descr->meta_description)) {
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $category->descr->meta_description
    ]);
}
?>
<?php echo $this->render('/banners/carousel', ['banners' => $banners]) ?>
<section id="hotels-container" class="row">
    <h1><?php echo Yii::t('app', 'Оберіть один з найкращих готелів') ?></h1>
    <div id="city-hotels">
        <?php echo $this->render('/hotels/list', ['hotels' => $hotels]) ?>
    </div>
    <div class="center-align hide-on-small-only">
        <button id="hotels-show-all" 
                class="button-see-all waves-effect waves-light blue btn">
                    <?php echo Yii::t('app', 'Показати всі міста') ?>
        </button>
    </div>
</section>
<!-- text -->
<div id="text" class="cont text-hotels">
    <?php echo (isset($category->descr->text)) ? $category->descr->text : '' ?>
</div>
<!-- /text -->

