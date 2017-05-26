<?php
/**
 * Pages
 * @var $this yii\web\View 
 */
// title
$title       = $model->descr->title;
$this->title = $title;

// Meta Description
if(!empty($model->descr->meta_description)) {
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $model->descr->meta_description
    ]);
}

// H1
if(empty($h1 = $model->descr->h1)) {
    $h1 = $title;
}
?>
<section id="main">
    <h1><?php echo $h1 ?></h1>
    <div class="text">
        <?php
        if(!empty($model->descr->text)) {
            echo $model->descr->text;
        }
        ?>
    </div>
</section>