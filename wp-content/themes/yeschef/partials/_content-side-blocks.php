<?php 

//echo 'here'; 

if( have_rows('page_side_blocks') )
{
	while( have_rows('page_side_blocks') ): the_row(); 
	
       //echo '<h1>' . get_sub_field('side_block_type') . '</h1>';

    	switch(get_sub_field('side_block_type'))
		{


			case 'Image':

				include '_content-sidebar-images.php';
    			break;


            case 'Bullets':

                include '_content-sidebar-bullets.php';
                break;

    		case 'Quote':

				include '_content-sidebar-quote.php';
    			break;


		}


	endwhile; 

}

?>