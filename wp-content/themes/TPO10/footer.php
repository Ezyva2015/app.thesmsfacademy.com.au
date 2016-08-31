<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->

<!--[if lt IE 9]>
<script src="/assets/global/plugins/respond.min.js"></script>
<script src="/assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script>
$.noConflict();
// Code that uses other library's $ can follow here.
</script>
<script src="/assets/global/plugins/tickets.js" type="text/javascript"></script>

<!-- Dropbox, OneDrive and Google Drive buttons scripts -->
<script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="r1ntng3748076ik"></script>
<script src="https://apis.google.com/js/plusone.js"></script>
<script type="text/javascript" src="https://js.live.net/v5.0/OneDrive.js" id="onedrive-js" client-id="000000004815500D"></script>

<script src="/assets/global/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>

<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>

<script src="/assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.bootstrap.newsbox.min.js" type="text/javascript"></script>


<script src="/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>

<script src="/assets/admin/pages/scripts/index.js" type="text/javascript"></script>


<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery.noConflict();
jQuery(document).ready(function() {  
	  
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   Tasks.initDashboardWidget();
      Demo.init(); // init demo features 

   Index.init();   
   Index.initDashboardDaterange();
   
   Index.initCalendar(); // init index page's custom scripts
   Index.initCharts(); // init index page's custom scripts
   Index.initChat();
   Index.initMiniCharts();


});
</script>
<script type="text/javascript">
    jQuery('#search-text').autocomplete({
        source: function( request, response ) {
            jQuery.ajax({
                url : '<?php echo get_template_directory_uri(); ?>/autocomplete.php',
                dataType: "json",
                data: {
                   name_startsWith: request.term,
                   type: 'document'
                },
                 success: function( data ) {
                     response( jQuery.map( data, function( item ) {
                         $id = item[0].toLowerCase().replace(/\s/g,'-');
                         jQuery('#search-text').after('<input type="hidden" class="search-url" id="'+$id+'" value="'+item[1]+'">');
                        return {
                            label: item[0],
                            value: item[0]
                        }
                    }));
                }
            });
        },
        select: function(event, ui){
            $id = ui.item.label.toLowerCase().replace(/\s/g,'-');
            $url = jQuery("#"+$id).val();
            window.location.href = $url;
        },
        autoFocus: false,
        minLength: 0
    });
</script>

<!-- END JAVASCRIPTS -->
		</div><!-- #main -->

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="page-footer">
			<div class="page-footer-inner">
						 2015 &copy; The SMSF Academy Pty Ltd
			</div>
			<div class="scroll-to-top">
				<i class="icon-arrow-up"></i>
			</div>
		</div>
			

			<div class="site-info">
				
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page -->


 
	<?php wp_footer(); ?>
	<?php if(is_page(69)){ ?>
   <script type="text/javascript">
 
jQuery(document).ready(function() {

	// Instance the tour
var tour = new Tour({
name: "tour",
  steps: [],
  container: "body",
  keyboard: true,
  storage: window.localStorage,
  debug: true,
  backdrop: false,
  backdropPadding: 0,
  redirect: true,
  orphan: false,
  duration: false,
  delay: false,
  basePath: "",
  afterGetState: function (key, value) {},
  afterSetState: function (key, value) {},
  afterRemoveState: function (key, value) {},
  onStart: function (tour) {},
  onEnd: function (tour) {},
  onShow: function (tour) {},
  onShown: function (tour) {},
  onHide: function (tour) {},
  onHidden: function (tour) {},
  onNext: function (tour) {},
  onPrev: function (tour) {},
  onPause: function (tour, duration) {},
  onResume: function (tour, duration) {}
});

tour.addStep({
  element: "#input_15_289",
  title: "Step 1",
  content: "Content for step 1"
});

tour.addStep({
  element: "#input_15_1",
  title: "Step 2",
  content: "Content for step 2"
});

//$( "#input_15_289" ).click(function() {
//  tour.restart();
//});



});

</script>
<?php
 }
?>
<?php 
$current_user = wp_get_current_user();
?>
<script>
  window.intercomSettings = {
    app_id: "w6bhrhbw",
    name: "<?php echo $current_user->display_name; ?>", // Full name
    email: "<?php echo $current_user->user_email; ?>", // Email address
    created_at: 1312182000 // Signup date as a Unix timestamp
  };
</script>


<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/w6bhrhbw';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>

</body>
</html>