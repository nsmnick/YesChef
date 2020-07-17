<?php

    /**
    * Template Name: Search Additional Items
    */

	get_header();
?>
	
	
	<section class="panel content content__panel no-bottom">
		<div class="container">
			<h2>Browse our recipes & meals</h2>

			<p>Aenean non mauris sapien. Praesent orci dolor, porta ut justo non, commodo dignissim ligula. Integer dui arcu, sollicitudin ut eros non, dignissim molestie urna. Aliquam erat volutpat.</p>

		</div>
	</section>

	<div id="additionalitem-search">
	</div>


	 <script id="additionalitem-json" type="application/json">{"50":{"title":"Child\u2019s baking pack","content":"Etiam id tincidunt magna. Praesent nec nunc lectus. Donec mauris augue, ornare sed mi quis, eleifend dapibus nisl. Nunc dictum, lorem blandit molestie viverra, mauris mauris dapibus felis.\r\nVivamus nec nisi porta, accumsan neque vel, elementum purus. Nulla euismod nisi sit amet eleifend tempus. Aenean sed nibh porttitor, ultricies augue varius, dictum nunc. Morbi semper odio vitae mauris convallis, eu lacinia augue mattis. "},"54":{"title":"Cake-making kit","content":"Etiam id tincidunt magna. Praesent nec nunc lectus. Donec mauris augue, ornare sed mi quis, eleifend dapibus nisl. Nunc dictum, lorem blandit molestie viverra, mauris mauris dapibus felis.\r\nVivamus nec nisi porta, accumsan neque vel, elementum purus. Nulla euismod nisi sit amet eleifend tempus. Aenean sed nibh porttitor, ultricies augue varius, dictum nunc. Morbi semper odio vitae mauris convallis, eu lacinia augue mattis. "},"55":{"title":"Cheese Selection","content":"Etiam id tincidunt magna. Praesent nec nunc lectus. Donec mauris augue, ornare sed mi quis, eleifend dapibus nisl. Nunc dictum, lorem blandit molestie viverra, mauris mauris dapibus felis.\r\nVivamus nec nisi porta, accumsan neque vel, elementum purus. Nulla euismod nisi sit amet eleifend tempus. Aenean sed nibh porttitor, ultricies augue varius, dictum nunc. Morbi semper odio vitae mauris convallis, eu lacinia augue mattis. "}}</script>
	 
	<div id="additionalitem-modal"></div>;


	<?php include_once 'partials/_content-order-first.php'; ?>

	<?php 
	$top='purple';
	$bottom='blue';
	include_once 'partials/_content-how-it-works.php'; 
	?>



<?php
	get_footer();
?>



