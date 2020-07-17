<?php 

if( have_rows('page_blocks') )
{
	while( have_rows('page_blocks') ): the_row(); 
	
    //   echo '<h1>' . get_sub_field('block_type') . '</h1>';

    	switch(get_sub_field('block_type'))
		{


            case 'Related Articles Panel':

                include '_content-more-articles.php';
                break;

            case 'Two Col Panel':

                include '_content-two-col-panel.php';
                break;

            case 'Two Col 60-40 Panel':

                include '_content-two-col-60-40-panel.php';
                break;



			case 'Three Col Panel':

				include '_content-three-col-panel.php';
    			break;


            case 'Four Col Panel':

                include '_content-four-col-panel.php';
                break;

    		case 'Wobbly Col Panel':

				include '_content-wobbly-col-panel.php';
    			break;


    		case 'Wobbly Col Panel':

				include '_content-case-studies-promo-panel.php';
    			break;

    		case 'Image Content Slider':
    			include '_content-image-content-slider-panel.php';
    			break;

    		case 'Sliding Disc Panel':
    			include '_content-discs-col-panel.php';
    			break;

            case 'Sliding Block Panel':
                include '_content-block-slider-panel.php';
                break;


    		case 'Multi Col Panel':
    			include '_content-multi-col-panel.php';
    			break;

			case 'Image Panel':
    			include '_content-image-panel.php';
    			break;


            case 'Stats Panel':
                include '_content-stats-panel.php';
                break;


            case 'Sliding Quote Panel':
                include '_content-quote-slider-panel.php';
                break;


            case 'Team Col Panel':
                include '_content-team-col-panel.php';
                break;


            case 'CTA Panel':
                include '_content-cta-panel.php';
                break;

            case 'Content Panel':
                include '_content-content-panel.php';
                break;  

            case 'Search Jobs Dialog':
                include '_content-job-search-dialog.php';
                break;    

            case 'Two Col Icon Panel':
                include '_content-two-col-icon-panel.php';
                break;    

            case 'Accordion Panel':
                include '_content-accordion-panel.php';
                break;    

             case 'Form Panel':
                include '_content-form-panel.php';
                break;    


            case 'Content Sections Panel':
                include '_content-sections-panel.php';
                break;    

            
            case 'Two Col Background Panel':
                include '_content-two-col-background-panel.php';
                break;    


            case 'Three Circle Image Panel':
                include '_content-three-circle-image-panel.php';
                break; 

            case 'Site Wide Message Panel':
                include '_content_site_wide_message_panel.php';
                break;    

                


		}


	endwhile; 

}

?>