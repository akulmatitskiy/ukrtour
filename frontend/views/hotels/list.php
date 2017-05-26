<?php
/**
 * Hotels list
 */
$i = 0;
?>
<?php foreach($hotels as $hotel) { ?>
    <div id="hotel<?php echo $i++ ?>" class="city-hotel" 
         style="background-image: url(<?php echo $hotel['image'] ?>)"
         onclick="location.href = '<?php echo $hotel['url'] ?>'">
        <div class="wrapper color-overlay">
            <div>
                <div class="name">
                    <a href="<?php echo $hotel['url'] ?>" title="<?php echo $hotel['name'] ?>">
                        <?php echo $hotel['name'] ?>
                    </a>
                </div>
                <?php for($stars = 0; $stars < $hotel['rating']; $stars++) { ?>
                    <div class="stars">
                        <i class="material-icons">star</i>
                    </div>
                <?php } ?>
                <div class="city">
                    <?php echo $hotel['city'] ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>