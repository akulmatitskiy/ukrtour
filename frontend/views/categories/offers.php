<?php
/**
 * Offers template
 * @var $this yii\web\View
 */

// Title
$title       = $category->descr->title;
$this->title = $title;

// Meta Description
if(!empty($category->descr->meta_description)) {
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $category->descr->meta_description
    ]);
}

// H1
if(empty($h1 = $category->descr->h1)) {
   $h1 = $title;
}
?>
<section id="main">
    <?php echo $this->render('/banners/carousel', ['banners' => $banners]) ?>
</section>
<!-- offers -->
<section id="offers-container">
    <h1><?php echo $h1 ?></h1>
	<?php if(!empty($offers)) { ?>
	    <div id="offers" class="row">
	        <?php foreach($offers as $offer) { ?>
	            <div class="offer col s12 m4 l3" onclick="location.href = '<?php echo $offer['url'] ?>'"
	                 style="background-image: url(<?php echo $offer['image'] ?>)">
	                <div class="wrapper">
	                    <div>
	                        <div class="title">
	                            <?php echo $offer['title'] ?>
	                        </div>
	                        <div class="text">
	                            <?php echo $offer['annotation'] ?>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        <?php } ?>
	    </div>
	<?php } ?>
</section>
<!-- proposals -->

<!-- text -->
<div id="text-offers" class="cont text">
    <?php
    if(!empty($category->descr->text)) {
        echo $category->descr->text;
    }
    ?>
</div>