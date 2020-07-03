<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.ryanwhitney.us
 * @since      1.0.0
 *
 * @package    Prog_Vote
 * @subpackage Prog_Vote/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="pv_container">

	<h2 style="font-size:20px; font-weight: normal;">

    	<?php _e( 'Prog Vote Dashboard', $this->plugin_name ); ?>

   	</h2>
    
	<div class="tabs">
		
        <ul class="tab-links">
	    	
            <li class="active">
            	
                <a href="#tab1" class="tab_link">
                
                	<?php _e( 'Welcome', $this->plugin_name ); ?>
                    
               	</a>
           	
            </li>
	    	
            <li>
            
            	<a href="#tab2" class="tab_link">
                	
					<?php _e( 'Create Elections', $this->plugin_name ); ?>
                    
               	</a>
           	
            </li>
            
            <li>
            
            	<a href="#tab3" class="tab_link">
                	
					<?php _e( 'Display Elections', $this->plugin_name ); ?>
                    
               	</a>
           	
            </li>
            
            <li>
            
            	<a href="#tab4" class="tab_link">
                	
					<?php _e( 'Tabulate Elections', $this->plugin_name ); ?>
                    
               	</a>
           	
            </li>
	  	
        </ul>

	</div>

	<div class="tab-content" style="min-height: 930px;">
			
    	<div id="tab2" class="tab active"> 
				
        	<h2>
        
               	<?php _e( 'Welcome to Prog Vote by Ryan Whitney', $this->plugin_name ); ?>
        
            </h2>
				
            <p>
               	
				<?php _e( 'Thank you for choosing the Prog Vote plugin and welcome to the community. Find some useful information below and learn how to administer powerful elections in minutes.', $this->plugin_name ); ?>
            
            </p>
            
            <hr />
				
            <h2>
			
				<strong><?php _e( 'CREATE AN ELECTION', $this->plugin_name );?></strong>
                
          	</h2>
            
            <p>
                
				<?php _e( 'The first thing you need to do is create an election. You will want to give it a unique name and setup the details about the election. You will need to create races in the election and candidates in the races. Below you will see step by step directions for accomplishing this.', $this->plugin_name ); ?>
               	
          	</p>
        
            <h3 id="step1">
			
				<?php _e( 'STEP 1 of 3', $this->plugin_name ); ?>
                
          	</h3>
            
            <div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
                <span style="font-size:14px; font-weight: bold;">
            
                	<?php _e( '1(A).', $this->plugin_name ); ?> 
            
                </span>
                
                <a href="<?php echo get_site_url(); ?>/wp-admin/edit.php?post_type=pv_election" target="_blank" style="font-size:14px; font-weight: bold;">
                    
					<?php _e( 'Elections - To Elections Table', $this->plugin_name ); ?>
                    
                </a>
            
                <p>
                	
					<?php _e( 'Ready to start a new election? Start by clicking on "Elections" link under the Elections menu.', $this->plugin_name ); ?>
               	
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_1.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
            
            <br />
            
            <div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
                <span style="font-size:14px; font-weight: bold;">
                
                	<?php _e( '1(B).', $this->plugin_name ); ?>
                     
                </span>
                
                <a href="<?php echo get_site_url(); ?>/wp-admin/post-new.php?post_type=pv_election" target="_blank" style="font-size:14px; font-weight: bold;">
                    
					<?php _e( 'Elections - Add New Election', $this->plugin_name ); ?>
                    
                </a>
            
                <p>
                
                	<?php _e( 'Then click on the "Add New" botton at the top of the page to start working on your new election.', $this->plugin_name ); ?>
                    
               	</p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_2.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
            
            <br />
            
            <div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
                <span style="font-size:14px; font-weight: bold;">
                	
					<?php _e( '1(C). Elections - Enter Title/Details', $this->plugin_name ); ?>
                    
                </span>
                            
                <p>
                
                	<?php _e( 'Write a title for the election that will distinguish it from other elections. You may also want to include details about the election.', $this->plugin_name ); ?>
                    
               	</p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_3.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
            
            <br />
            
            <div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
                <span style="font-size:14px; font-weight: bold;">
                	
					<?php _e( '1(D). Elections - Privilages', $this->plugin_name ); ?>
                    
                </span>
            
                <p>
                	
					<?php _e( 'Select the check boxes for the restrictions you would like to place on the election information (details, results, and data).  NOTE: If the option to use IP address for voting is selected, all other privilages will be overridden as unselected (publically available).', $this->plugin_name ); ?>
                  
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_4.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
            
            <br />
         
            <div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
                <span style="font-size:14px; font-weight: bold;">
                	
					<?php _e( '1(E). Elections - Open/Close Datetime', $this->plugin_name ); ?>
                    
                </span>
            
                <p>
                	
					<?php _e( 'Select the <em>date</em> and <em>time</em> when people may start voting (<strong>Voting Opens</strong>). Then select the <em>date</em> and <em>time</em> when the voting period ends (<strong>Voting Close</strong>). The <strong>Voting Close</strong> <em>date</em> and <em>time</em> needs to be after the <strong>Voting Open</strong> <em>date</em> and <em>time</em>. NOTE: For an race to be asigned to an election, the election date must be in the future.', $this->plugin_name ); ?>
                    
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_5.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
            
            <br />
         
            <div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
                <span style="font-size:14px; font-weight: bold;">
                	
					<?php _e( '1(F). Elections - Election System', $this->plugin_name ); ?>
                    
                </span>
            
                <p>
                	
					<?php _e( 'Select the default <strong>Election System</strong>: <em>Ranked-Choice</em>, <em>Approval</em>, <em>Range</em>, or <em>Plurality</em>. If your <strong>Election System</strong> selection is one which allows multiple choices (not <em>Plurality</em>), then you should enter the maximum number of candidates that a voter may select in the <strong>Max Selection</strong> feild.', $this->plugin_name ); ?>
               	
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_6.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
                <br />
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_7.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
            
            <br />
         
            <div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
                <span style="font-size:14px; font-weight: bold;">
                	
					<?php _e( '1(G). Elections - Vote Groups', $this->plugin_name ); ?>
                    
                </span>
            
                <p>
                	
					<?php _e( 'With Prog Vote, you can add users to vote groups which will restrict the races and elections users can participate in. Enter eligible groups separated by commas to restrict the election. If the field is left blank, all voters will be eligible to vote in the election. The groups must first be establish in the', $this->plugin_name ); ?> <a href="<?php echo get_site_url().'/wp-admin/admin.php?page=prog_vote_settings'; ?>" target="_blank"><strong><?php _e( 'settings page', $this->plugin_name ); ?></strong></a>.
               	
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_8.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
            
            <br />
            
            <div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
                <span style="font-size:14px; font-weight: bold;">
                
                	<?php _e( '1(H). Elections - Publish', $this->plugin_name ); ?> 
                
                </span>
            
                <p>
                
                	<?php _e( 'Publish the election. An election must be published for races to be assigned to the election.', $this->plugin_name ); ?>
               	
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_9.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
            
            <br />
        		
            <h3 id="step2">
			
				<?php _e( 'STEP 2 of 3', $this->plugin_name ); ?>
                
          	</h3>
            
            <div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
                <span style="font-size:14px; font-weight: bold;">
            
                	<?php _e( '2(A).', $this->plugin_name ); ?> 
            
                </span>
                
                <a href="<?php echo get_site_url(); ?>/wp-admin/edit.php?post_type=pv_race" target="_blank" style="font-size:14px; font-weight: bold;">
                    
					<?php _e( 'Races - To Races Table', $this->plugin_name ); ?>
                
                </a>
            
                <p>
                
                	<?php _e( 'Ready to start a new race? Start by clicking on "Races" link under the Elections menu.', $this->plugin_name ); ?>
               	
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_10.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
            
            <br />
            
            <div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
                <span style="font-size:14px; font-weight: bold;">
                
                	<?php _e( '2(B).', $this->plugin_name ); ?> 
                
                </span>
                
                <a href="<?php echo get_site_url(); ?>/wp-admin/post-new.php?post_type=pv_race" target="_blank" style="font-size:14px; font-weight: bold;">
                    
					<?php _e( 'Races - Add New Race', $this->plugin_name ); ?>
                
                </a>
            
                <p>
                
                	<?php _e( 'Then click on the "Add New" botton at the top of the page to start working on your new race.', $this->plugin_name ); ?>
               	
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_11.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
            
            <br />
            
            <div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
                <span style="font-size:14px; font-weight: bold;">
                
                	<?php _e( '2(C). Races - Enter Title/Details', $this->plugin_name ); ?>
                
                </span>
                            
                <p>
                
                	<?php _e( 'Make a title for the race that will distinguish it from other races in the election. You may also want to include details about the race.', $this->plugin_name ); ?>
               	
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_12.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
            
            <br />
            
            <div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
                <span style="font-size:14px; font-weight: bold;">
                
                	<?php _e( '2(D). Races - Select Election', $this->plugin_name ); ?>
                    
                </span>
            
                <p>
                	
					<?php _e( 'Select the election to which you would like the race to be assigned. If you do not see the election that you want available, it may be that the election start date and time has already passed or that the election has not been published.', $this->plugin_name ); ?>
               	
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_13.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
            
            <br />
            
            <div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
                <span style="font-size:14px; font-weight: bold;">
                
                	<?php _e( '2(E). Races - Specify Voting Syetem', $this->plugin_name ); ?>
                     
                </span>
            
                <p>
                	
					<?php _e( 'Specify the voting system that should be used for the particular race. This defaults to "Same as Election" which will cause the race to be run by the default voting system specified in the election to which the race is assigned.', $this->plugin_name ); ?> 
               	
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_14.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
                        
            <br />
            
            <div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
                <span style="font-size:14px; font-weight: bold;">
                
                	<?php _e( '2(F). Races - Multi-Winner', $this->plugin_name ); ?> 
                
                </span>
            
                <p>
                
                	<?php _e( 'If a race is run with <strong>Ranked Choice</strong>, then the race can have multiple winners. If you would like the race in question to have multiple winners, select "YES" and slide the slider to the number of winners in the "Number of Winners" for the race.', $this->plugin_name ); ?>
               	
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_15.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
                        
            <br />
            
            <div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
                <span style="font-size:14px; font-weight: bold;">
                
                	<?php _e( '2(G). Races - Vote Group', $this->plugin_name ); ?> 
                
                </span>
            
                <p>
                
                	<?php _e( 'With Prog Vote, you can add users to vote groups which will restrict the races and elections in which users can participate. Enter eligible groups separated by commas to restrict the race. If the field is left blank, all voters eligible to vote in the election will be able to vote in the race. The groups must first be establish in the', $this->plugin_name ); ?> <a href="<?php echo get_site_url().'/wp-admin/admin.php?page=prog_vote_settings'; ?>" target="_blank"><strong><?php _e( 'settings page', $this->plugin_name ); ?></strong></a>.
                                   	
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_16.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
                        
            <br />
            
          	<div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
                <span style="font-size:14px; font-weight: bold;">
            
                	<?php _e( '2(H). Races - Publish', $this->plugin_name ); ?> 
            
                </span>
            
                <p>
                
                	<?php _e( 'Publish the race. A race must be published for candidates to be added to the race.', $this->plugin_name ); ?>
               	
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_17.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
                        
            <br />
        		
            <h3 id="step3">
			
				<?php _e( 'STEP 3 of 3', $this->plugin_name ); ?>
                
           	</h3>
            
            <div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
                <span style="font-size:14px; font-weight: bold;">
            
                	<?php _e( '3(A).', $this->plugin_name ); ?> 
            
                </span>
                
                <a href="<?php echo get_site_url(); ?>/wp-admin/edit.php?post_type=pv_candidate" target="_blank" style="font-size:14px; font-weight: bold;">

                    <?php _e( 'Candidates - To Candidates Table', $this->plugin_name ); ?>

                </a>
            
                <p>
                
                	<?php _e( 'Ready to register a new candidate? Start by clicking on "Candidates" link under the Elections menu.', $this->plugin_name ); ?>
               	
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_18.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
            
            <br />
            
            <div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
                <span style="font-size:14px; font-weight: bold;">
                
                	<?php _e( '3(B).', $this->plugin_name ); ?> 
                
                </span>
                
                <a href="<?php echo get_site_url(); ?>/wp-admin/post-new.php?post_type=pv_candidate" target="_blank" style="font-size:14px; font-weight: bold;">
                    
					<?php _e( 'Candidates - Add New Candidate', $this->plugin_name ); ?>
                
                </a>
            
                <p>
                
                	<?php _e( 'Then click on the "Add New" botton at the top of the page to start working on your new candidate.', $this->plugin_name ); ?>
               	
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_19.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
            
            <br />
            
            <div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
                <span style="font-size:14px; font-weight: bold;">
                
                	<?php _e( '3(C). Candidates - Enter Title/Details', $this->plugin_name ); ?>
                
                </span>
                            
                <p>
                
                	<?php _e( 'Make a title for the candidate that will distinguish them from other candidates.', $this->plugin_name ); ?>
               	
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_20.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
            
            <br />
            
            <div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
                <span style="font-size:14px; font-weight: bold;">
                
                	<?php _e( '3(D). Candidates - Select Race', $this->plugin_name ); ?>
                
                </span>
            
                <p>
                
                	<?php _e( 'Select the race that you would like the candidate to be assigned to. If you do not see the race that you want available, it may be that the election start date and time has already passed, that the election has not been published, that your race has not been assigned to an election or that your race has not been published.', $this->plugin_name ); ?>
               	
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_21.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
            
            <br />
            
            <div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
                <span style="font-size:14px; font-weight: bold;">
                
                	<?php _e( '3(E). Candidates - Publish', $this->plugin_name ); ?> 
                
                </span>
            
                <p>
                
                	<?php _e( 'Publish the candidate. A candidate must be published to be considered in the election.', $this->plugin_name ); ?>
               	
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_22.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
            
            <br />
            
		</div>
        
        <hr />
        
        <div id="tab3" class="tab active">
        
        	<h2>
			
				<strong><?php _e( 'DISPLAY ELECTION', $this->plugin_name );?></strong>
                
          	</h2>
            
            <p>
            
            	<?php _e( 'After you have created your election people will need to access it so they can participate. You can accomplish this in a couple ways. You can put a shortcode in a page or you can use a weblink to the election.', $this->plugin_name ); ?>
            
            </p>
            
           	<div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
            	<span style="font-size:14px; font-weight: bold;">
                
                	<?php _e( '(Option 1). Shortcode In Page', $this->plugin_name ); ?> 
                
                </span>
            
                <p>
                
                	<?php _e( 'After you have published your election, even before you assign any races or candidates to the election, a shortcode will be displayed at the top of the election edit page. You can copy that shortcode into any existing or new page and it will display one of the following, depending on the shortcode you select: Ballot, Info, Results, or Vote Data. The top, more prominent shortcode is for the Ballot.', $this->plugin_name ); ?>
               		
                    <br />
					
					<em><?php _e( 'NOTE: Do not worry if voting has not yet opened. A message will inform the user how long until voting opens.', $this->plugin_name ); ?></em>
               	
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_23.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
                <br />
                
                <p>
                
                	<?php _e( 'You can add your own content with the shortcode, but you really dont need to if you dont want to. All the needed content for the election will be supplied through the shortcode. Using the shortcode in a page is definitely the more flexible option, but requires a little extra work. Below are images of adding the shortcode to a new page.', $this->plugin_name ); ?>
               	
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_24.jpg" style="width:90%; max-width:500px; border:#333 medium solid;" />
                
                <br />
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_25.jpg" style="width:90%; max-width:500px; border:#333 medium solid;" />
                
            </div>
            
            <br />
        
        	<div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
            	<span style="font-size:14px; font-weight: bold;">
                
                	<?php _e( '(Option 2). Weblink', $this->plugin_name ); ?> 
                
                </span>
            
                <p>
                
                	<?php _e( 'The weblinks can also be used to display the election. Like the shortcodes, these also appear after publishing the election. To get the weblink you will need to right-click (control-click for MAC) and select "Copy link address" as shown in the photo below. There are four different links: Ballot, Info, Results and Vote data. The weblink can then be pasted anywhere you need it to be, ex: email, web page, social media, reddit, ect.', $this->plugin_name ); ?>
               	
                <br />
					
				<em><?php _e( 'NOTE: This option is less flexible since you cannot add your own content to the webpage, but it requires less work.', $this->plugin_name ); ?></em>
                	
                </p>
                               
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_26.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
            </div>
        
        </div>
        
        <hr />
        
        <div id="tab4" class="tab active">
        
        	<h2>
			
				<strong><?php _e( 'TABULATE ELECTION', $this->plugin_name );?></strong>
                
          	</h2>
        
  		    <p>
            
            	<?php _e( 'Tabulating the election is very simple. It is literally the click of a button.', $this->plugin_name ); ?>
            
            </p>
            
           	<div style="width: 95%; padding: 8px; border-radius:8px; background-color:white;">
            	
            	<span style="font-size:14px; font-weight: bold;">
                
                	<?php _e( 'Click Tabulate', $this->plugin_name ); ?> 
                
                </span>
            
                <p>
                
                	<?php _e( 'After voting closes for the election the "TABULATE" button will become available on the election edit page. All you have to do is click the button and the election will be tabulated. A link to view the results will appear in the tabulate box.', $this->plugin_name ); ?>
               		
                    <br />
					
					<em><?php _e( 'NOTE: The election will not be able to be tabulated until voting has closed and it will only be able to be tabulated once.', $this->plugin_name ); ?></em>
               	
                </p>
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_27.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
                
                <br />
                
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/assets/Img/Step_28.jpg" style="width:90%; max-width:500px; border:#333 medium solid;">
            
            </div>
        
        </div>

	</div>

</div>