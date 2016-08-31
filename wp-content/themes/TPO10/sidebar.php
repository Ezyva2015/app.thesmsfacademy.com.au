<!-- sidebar -->
<?php $url = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>
<aside class="sidebar" role="complementary">

	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<?php
				wp_nav_menu(
					array(
							'theme_location' => 'sidebar-menu',
							'items_wrap' => '
											<ul
												id="%1$s"
												class="%2$s page-sidebar-menu"
												data-auto-scroll="true"
												data-slide-speed="200">
												<li class="sidebar-toggler-wrapper">
												<div class="sidebar-toggler"></div>
												</li>%3$s
											</ul>'
					)
				); 
			?>


			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->

</aside>
<!-- /sidebar -->
