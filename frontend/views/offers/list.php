<?php
/**
 * Offers
 */
?>
<?php if(!empty($offers)) { ?>
	<?php foreach($offers as $offer) { ?>
	    <div onclick="location.href = '<?php echo $offer['url'] ?>'" 
	         class="offer" style="background-image: url(<?php echo $offer['image'] ?>)">
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
<?php } ?>