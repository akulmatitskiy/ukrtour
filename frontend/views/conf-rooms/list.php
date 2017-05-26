<?php
/**
 * List of conference rooms
 */
?>
<?php foreach($rooms as $room) { ?>
    <div class="city-hotel col s4" 
         style="background-image: url(<?php echo $room['image'] ?>)"
         onclick="location.href = '<?php echo $room['url'] ?>'">
        <div class="wrapper color-overlay">
            <div>
                <div class="name">
                    <a href="<?php echo $room['url'] ?>" title="<?php echo $room['name'] ?>">
                        <?php echo $room['name'] ?>
                    </a>
                </div>
                <?php for($stars = 0; $stars < $room['rating']; $stars++) { ?>
                    <div class="stars" hide-xs>
                        <i class="material-icons">star</i>
                    </div>
                <?php } ?>
                <div class="city">
                    <?php echo $room['city'] ?>
                </div>
                <div class="descr">
                    <?php echo $room['descr'] ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>