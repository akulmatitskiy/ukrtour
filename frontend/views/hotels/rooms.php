<?php
/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;
use mp\bmicrodata\BreadcrumbsUtility;
use common\models\Languages;

// Title
if(empty($hotel->descr->title)) {
    $title = 'Hotel';
} else {
    $title = $hotel->descr->title;
}

// City  name
if(!empty($hotel->servioCity->name)) {
    $this->params['breadcrumbs'][] = [
        'label' => $hotel->servioCity->name,
        'url' => null
    ];
}

// Breadcrumbs
$this->title                   = $title;
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => ['hotels/view', 'slug' => $hotel->descr->slug]
];

// Meta title
$this->title = $title;

// h1
$h1 = $title;

// Meta Description
if(!empty($hotel->descr->meta_description)) {
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $hotel->descr->meta_description
    ]);
}

$roomsJs = 'getRooms("'. $hotel->id . '", "'
    . Languages::getIsoCode(). '", "'. $params. '");';


$this->registerJs($roomsJs, $this::POS_END);
?>
<?php
echo Breadcrumbs::widget([
    'homeLink' => BreadcrumbsUtility::getHome(Yii::t('app', 'Головна'), Yii::$app->getHomeUrl()), // Link home page with microdata
    'links' => isset($this->params['breadcrumbs']) ? BreadcrumbsUtility::UseMicroData($this->params['breadcrumbs']) : [], // Get other links with microdata    
    'options' => [ // Set microdata for container BreadcrumbList     
        'id' => 'breadcrumbs',
        'class' => 'breadcrumb',
        'itemscope itemtype' => 'http://schema.org/BreadcrumbList'
    ],
]);
?>
<section id="main" class="valign-wrapper">
    <h1><?php echo $h1 ?></h1>
    <div class="preloader-wrapper active valign center-align">
        <div class="spinner-layer spinner-blue-only">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div><div class="gap-patch">
                <div class="circle"></div>
            </div><div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>
    </div>
</section>
<section id="rooms-container">
</section>

