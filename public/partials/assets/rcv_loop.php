<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://www.ryanwhitney.us
 * @since      1.0.0
 *
 * @package    Prog_Vote
 * @subpackage Prog_Vote/public/partials/assets
 */
?>	
	
<label for="<?php echo $theID.'-'.( $i + 1 );?>" class="rank label<?php echo $theID; ?> name<?php echo $key.'-'.( $i + 1 ); ?>" style="width:<?php echo 1 / $rank_num * 100;?>%;">

    <input type="radio" id="<?php echo $theID.'-'.( $i + 1 );?>" data-candidate="<?php echo get_the_title();?>" data-rank="<?php echo $i+1; ?>" data-voting="<?php echo $vm;?>" name="<?php echo $key.'-'.( $i + 1 ); ?>" value="<?php echo $theID; ?>" class="<?php echo 'can-'.$theID.' rank-'.( $i + 1 );?>" style="position:inherit; left:auto; opacity:1;" />

    <?php echo $i + 1; if( ( $i + 1 ) == 1 ) { echo '<sup>st</sup>'; } else if ( ( $i + 1 ) == 2 ) { echo '<sup>nd</sup>'; } else if ( ( $i + 1 ) == 3 ) { echo '<sup>rd</sup>'; } else { echo '<sup>th</sup>'; } ?>

</label>