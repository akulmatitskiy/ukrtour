<?php

use yii\helpers\Url;
use common\models\Languages;
use yii\widgets\Breadcrumbs;
use mp\bmicrodata\BreadcrumbsUtility;

/**
 * @link https://github.com/himiklab/yii2-search-component-v2
 * @copyright Copyright (c) 2014 HimikLab
 * @license http://opensource.org/licenses/MIT MIT
 */
/** @var yii\web\View $this */
/** @var ZendSearch\Lucene\Search\QueryHit[] $hits */
/** @var string $query */
/** @var yii\data\Pagination $pagination */
$query = yii\helpers\Html::encode($query);

$this->title = Yii::t('app', 'Результати пошуку для ') . '"' . $query . '"';

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Пошук'),
    'url' => null
];

$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => ['search/index', 'q' => $query]
];

// Current lang ID
$langId = Languages::getCurrentLangId();

// Css
$css = '.search-results a {color: #2196f3;}'
    . 'h3 {margin: 2rem 0 0;}'
    . 'p {margin: 0.5rem 0 1rem;}';
$this->registerCss($css);
?>
<?php
echo Breadcrumbs::widget([
    'homeLink' => BreadcrumbsUtility::getHome(Yii::t('app', 'Головна'), Yii::$app->getHomeUrl()), // Link home page with microdata
    'links' => isset($this->params['breadcrumbs']) ? BreadcrumbsUtility::UseMicroData($this->params['breadcrumbs']) : [], // Get other links with microdata    
    'options' => [ // Set microdata for container BreadcrumbList     
        'id' => 'breadcrumbs',
        'itemscope itemtype' => 'http://schema.org/BreadcrumbList'
    ],
]);
?>
<section id="main" class="search-results">
    <h1><?php echo Yii::t('app', 'Пошук') ?></h1>
    <form action="<?php echo Url::to(['search/index']) ?>" class="hide-on-small-only">
        <div class="row">
            <div class="input-field col">
                <input id="search-query" name="q" type="text">
                <label for="search-query">
                    <?php echo Yii::t('app', 'Пошук') ?>
                </label>
            </div>
        </div>
    </form>
    <?php
    if(!empty($hits)) {
        foreach($hits as $hit) {
            // Position query
            $position = mb_stripos($hit->description, $query);

            if($position && mb_strlen($hit->description) > 500) {
                // Offset
                $start = $position - 200;
                if($start < 0) {
                    $start = 0;
                }
                // trim description
                $description = '...' . mb_substr($hit->description, $start, $position + 200) . '...';
            } else {
                // full description
                $description = $hit->description;
            }

            // Highlight
            $teaser = preg_replace('#(' . $query . ')#ius', '<strong>$1</strong>', $description);
            ?>
            <h3>
                <a href="<?php echo Url::to([$hit->model . '/view', 'slug' => $hit->url]) ?>">
                    <?php echo $hit->title ?>
                </a>
            </h3>
            <p class="search">
                <?php echo $teaser ?>
            </p>
        <?php } ?>

    <?php } else { ?>
        <div class="row">
            <h3 class="col">
                <?php printf(Yii::t('app', 'По запиту "%s" нічого не знайдено!'), $query) ?>
            </h3>
        </div>
    <?php } ?>
</section>
<?php
echo yii\widgets\LinkPager::widget([
    'pagination' => $pagination,
]);
