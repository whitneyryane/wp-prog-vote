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
 * @subpackage Prog_Vote/public/partials
 */
?>

<style>

	.doubleTable{
		float:left;
		min-width:50%;
	}

	.candidate {
		float:left;
		padding:8px;
		margin:5px;
		background:#E8E8E8;
		border-radius:6px;
	}

	.rank {
		background:#CCC;
		border:#fff thin solid;	
		text-align:center;
		font-weight:bold;
		color:#000;
		display:block;
		float:left;	
	}

	.rank:hover {
		background:#fff;
		border:#4caf50 thin solid;
	}

	.rankhover {
		background: #fff;
		border:#4caf50 thin solid;
	}

	#verifyContain {
		position:fixed;
		overflow:auto;
		z-index:1000;
		width:100%;
		top:0px;
		left:0px;
		height:100%;
		background:#FFF;
		display:none;
	}

	#verifyPack {
		margin:auto 0px;
		padding:30px;
		background:#FFFFFF;
	}

	#verifyBox {
		margin:80px 15px;
	}

	#verifyButtons {
		margin:15px;
	}

	@media only screen and (max-width: 600px) {

		.doubleTable {
			min-width:100%;
		}

	}	

</style>

<?php 

$max_select = get_post_meta( $atts['id'], 'pv_election_max_select', true );
$es = get_post_meta( $atts['id'], 'pv_election_system', true );
if ($es == 'RCV'){$election_system = 'Ranked Choice Voting';} else
if ($es == 'AV'){$election_system = 'Approval Voting';} else
if ($es == 'RV'){$election_system = 'Range Voting';} else
if ($es == 'PV'){$election_system = 'Plurality Voting';} ?>

<div id="ballot">

	<h2><?php echo get_the_title( $atts['id'] ); ?></h2>
		
		<?php 
		
		if ($es){ echo $election_system;
			
			if($es != 'PV'){echo ' ('.$max_select.' rank maximum)';}
		
		}?>

	<br />
	<?php if($atts['id']){?>
    
	<div id="description">
		
        <table>
			<tr>
            
				<th>ELECTION DESCRIPTION</th>
			
            </tr>
			<tr>
			
            	<td><?php echo get_post_field('post_content', $atts['id']); ?></td>

			</tr>
		</table>
        
	</div>

	<br />
	<?php }?>

	<div id="instructions">
		
        <table>
			<tr>

				<th>VOTING INSTRUCTIONS</th>

			</tr>
			<tr>
				
                <td><?php echo 'instructions go here'; ?></td>

			</tr>
		</table>
        
	</div>

	<div>
	
	<?php
 
	$args = array(
		'post_type'  => 'pv_race',
		'orderby'    => 'title',
		'order'      => 'ASC',
		'meta_query' => array(
			array(
				'key'     => 'pv_race_election',
				'value'   => $atts['id'],
				'compare' => '=',
			),
		),
	);
	
	$query = new WP_Query( $args );
	
	$race = array(); $candidate = array();
	
	if($query->have_posts()){
		
		while($query->have_posts()){
		
			$query->the_post();
		
			$race[get_the_ID()] = array(
				get_the_title(),
				get_post_meta(get_the_ID(), 'pv_race_voting', true),
				get_post_meta(get_the_ID(), 'pv_race_multi_winner', true),
				get_post_meta(get_the_ID(), 'pv_race_winners_count', true)
			);
		}
		  
		wp_reset_postdata();
	} else { ?>
	
    	<br />
    
		<table>
        	<tr>
            
            	<td>No races are assigned to this election. Please go to the <a href="edit.php?post_type=pv_race">RACE TAB</a> and assign an election to each relevant race.</td>
                
           	</tr>
      	</table>
		
		<?php 
		
		}

		foreach($race as $key => $value){
			
			$args = array(
				'post_type' 	=> 'pv_candidate',
				'orderby' 		=> 'title',
				'posts_per_page'=>'50',
				'order'      	=> 'ASC',
				'meta_query' 	=> array(
					array(
						'key'     => 'pv_candidate_race',
						'value'   => $key,
						'compare' => '=',
					),
				),
			);

			$query = new WP_Query( $args );?>
			
        <br />
		
        <table>	        
			<tr>

				<th>
					<?php 

					echo $value[0].' <small style="float:right;">|';
					
					if($query->post_count > 2){
					
						if(!$value[1]){$vm = $election_system;} else
						if($value[1]=='SAE'){$vm = $election_system;} else
						if($value[1]=='RCV'){$vm = 'Ranked Choice Voting';} else
						if(!$value[1]=='AV'){$vm = 'Approval Voting';} else
						if(!$value[1]=='RV'){$vm = 'Range Voting';} else
						if(!$value[1]=='PV'){$vm = 'Plurality Voting';}
						
					} else { $vm = 'Plurality Voting'; }
					
					echo $vm;

					if($vm=='Ranked Choice Voting'){
						
						if($value[2]=='yes'){
						
							if((int)$value[3]>1){
						
								echo '|Multi-Winner ('.$value[3].')';
						
							}
						}
					}

					echo '|</small>';
					
					?>
				</th>

			</tr>
			<tr>

				<td>
					<table data-race="<?php echo $value[0]; ?>">	    
						<tr>
                        
                        	<td><em>Candidate Name</em></td>
							
							<?php
                            if($vm != 'Plurality Voting'){ ?>
                            
                            <td><em>Rank Order</em></td>
                            
							<?php
                            } else {?>
                            
                            <td><em>Vote</em></td>
                            
                            <?php 
							} ?>
                            
                      	</tr>
                        
						<?php
                       	
						if($query->have_posts()){
						
							while($query->have_posts()){
						
								$query->the_post();
								$theID = get_the_ID();?>
						
                    		    <tr>

									<td id="<?php echo $theID; ?>" style="width:33%;">
                            
										<a href="<?php echo get_the_guid( $theID ); ?>" target="_blank">
											<div><?php echo get_the_title();?></div>
										</a>
							
                            		</td>

									<td>
							
										<?php 
										
										if($vm != 'Plurality Voting') {
							
											for($i = 0; $i < $max_select; $i++){ ?>
	
											<label for="<?php echo $theID.'-'.($i+1);?>" class="rank label<?php echo $theID; ?> name<?php echo $key.'-'.($i+1); ?>" style="width:<?php echo 1/$max_select*100;?>%;">
	
												<input type="radio" id="<?php echo $theID.'-'.($i+1);?>" data-candidate="<?php echo get_the_title();?>" data-rank="<?php echo $i+1; ?>" name="<?php echo $key.'-'.($i+1); ?>" value="<?php echo $theID; ?>" class="<?php echo 'can-'.$theID.' rank-'.($i+1);?>" />
										
												<?php echo $i+1; ?>
								  
											</label>
	
											<?php 
								
											}
											
										}else{?>
                                        
                                        <label for="<?php echo $theID.'-yes';?>" class="rank label<?php echo $theID; ?> name<?php echo $key.'-yes'; ?>" style="width:<?php echo 1/$query->post_count*100;?>%;">
	
											<input type="radio" id="<?php echo $theID;?>" data-candidate="<?php echo get_the_title();?>" data-rank="yes" name="<?php echo $key.'-yes'; ?>" value="<?php echo $theID; ?>" class="<?php echo 'can-'.$theID.' yes';?>" />
										
											YES
								  
										</label>

										<?php 
										}?>

									</td>

								</tr>

							<?php 
							
							}
						
						}?>

					</table>
				</td>

			</tr>
			<tr>
				
                <td>
					<?php echo get_post_field('post_content', $key);?>
				</td>

			</tr>
		</table>

	<?php
    
	}?>
    
	<br />
	
    <button id="process">SUBMIT</button><button id="clear" style="background: #CCC;">CLEAR</button>

	</div>
</div>

<div id="verifyContain">
	
    <div id="verifyPack">
		
        <div id="verifyBox">
		
        </div>

		<div id="verifyButtons">
		<button id="confirm">CONFIRM</button>
        <button id="edit" style="background:#F00;">EDIT</button>
		</div>
	
    </div>
</div>
<script type="text/javascript">
(function( $ ) {
	
	$('input[type="radio"]').on('click', function () {	

		var id = $(this).attr('id');
		var name = $(this).attr('name');
		var val = $(this).val();
		var checked = $('input[value="'+val+'"]:checked');
		var input = $('input[value="'+val+'"]');
		
		if(checked.length > 1){
		
			$(this).removeAttr('checked');
		
			input.attr('checked', false);
		
			$(this).attr('checked','checked');
		
		}

		$('.label'+val+'').removeClass('rankhover');

		$('.name'+name+'').removeClass('rankhover');

		$('label[for="'+id+'"]').addClass('rankhover');

	}); // click on raido

	$('#process').on('click', function(){

		var container = $('#verifyContain');
		var box = $('#verifyBox');
		var input = $('input:checked');
		var a = Array();

		input.each(function(index) {

			a[index] = [
				[$(this).parents('table').data('race')+$(this).data('rank')],
				[$(this).parents('table').data('race')],
				[$(this).data('rank')],
				[$(this).data('candidate')]
			];
			
		});

		a.sort(compareFirstColumn);

		function compareFirstColumn(a, b) {

			if (a[0] === b[0]) {
				
				return 0;

			} else {
				
				return (a[0] < b[0]) ? -1 : 1;

			}

		}

		box.append(verifyData(a));

		$('#verifyContain').show();

		$('#ballot').hide();

		$('footer').hide();

		$('header').hide();

	}); // end process

	$('#edit').on('click',function(){

		$('#ballot').show();

		$('footer').show();

		$('header').show();

		$('#verifyContain').hide();

		$('#confirm').show();

		$('#verifyBox').empty();

	}); // click on #edit

	$('#clear').on('click',function(){

		$('input').removeAttr('checked');

		$('input').attr('checked', false);

		$('label').removeClass('rankhover');

	}); // click on #clear

	$('#confirm').on('click',function(){

	}); // click on #confirm

	function verifyData(a){
		
		var html = '<h3>Please verify your vote.</h3>';
		html +=	'<p>If there are any errors in your vote, click <strong>EDIT</strong>, otherwise click <strong>CONFIRM</strong>.</p>';
		html += '<table>';

		if(a.length > 0){

			var race = [];

			$.each(a, function(index, value){

				if($.inArray(value[1].toString(), race) === -1){
					
					html += '<tr><th colspan="2">'+value[1]+'</th></tr><tr><td><em>Rank</em></td><td><em>Candidate</em></td></tr>';
				
					race.push(value[1].toString());
					
				}
				
				html += '<tr><td><strong>'+value[2]+'</strong></td><td>'+value[3]+'</td></tr>';	
			
			});
		
		} else {
			
			html += '<tr><td>NO DATA HAS BEEN SUBMITTED</td></tr>';

			$('#confirm').hide();
		
		}

		html += '</table>';

		return html;
	} // end verifyData

})( jQuery );

</script>