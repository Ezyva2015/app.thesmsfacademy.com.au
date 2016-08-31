<?php
// Report all PHP errors
//error_reporting(-1);
header("HTTP/1.1 200 OK");

require_once '../../Services/Infusionsoft/isdk.enhanced.php';
require_once '../../Services/Logger/Logger.php';

Logger::$path = dirname(__FILE__) . '/log.txt';

require_once('../stripe-php/init.php');

?>

<head>

</head>
<?php if(is_null($background_colour)){ 
				$background_colour = "#ffffff";
			}
			
			?>

<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src='https://checkout.stripe.com/checkout.js'></script>




<script type='text/javascript'>$(document).ready(function(){ 

  });
  


</script>
	

			<button id='customButton' class='stripe-button-el'><span id='spanButton'>Add/Update Credit Card</span></button>
			
			
			<script>
				var current_effect = 'bounce';  
				function run_waitMe(effect){
				$('#container').waitMe({

				//none, rotateplane, stretch, orbit, roundBounce, win8, 
				//win8_linear, ios, facebook, rotation, timer, pulse, 
				//progressBar, bouncePulse or img
				effect: 'bounce',

				//place text under the effect (string).
				text: '',

				//background for container (string).
				bg: 'rgba(255,255,255,0.7)',

				//color for background animation and text (string).
				color: '#000',

				//change width for elem animation (string).
				sizeW: '',

				//change height for elem animation (string).
				sizeH: '',

				// url to image
				source: ''

				});
				}

			  $('#customButton').on('click', function(e) {
						  

		
			var pkey = '<?php echo $stripe_pk; ?>';
			
			var description = '<?php echo $product_name; ?>';
			
			
				// Open Checkout with further options
				StripeCheckout.open({
				  name: '<?php echo $company; ?>',
				  description: '<?php echo $product_name; ?>',
				  currency: 'aud',
				  email: emailAddress,
				  amount: amt,
				  key: pkey,
					token: function(token, args) {
					  // Use the token to create the charge with a server-side script.
					  // You can access the token ID with `token.id`
					  //console.log(token);
					  //console.log(args);
					  //console.log(amt);	  
					   $.ajax({
						  url: 'https://automationlab.com.au/scripts/da/stripe-php/index.php',
						  type: 'post',
						  data: {tokenid: token.id, email: token.email, amount:amt, fwd:fwd, desc:description, frameId:frameId },
						  success: function(data) {
							if (data == 'success') {
								console.log("Card successfully saved!");
								
							}
							else {
								console.log("Success Error! ");
								console.log(data);
							}

						  },
						  error: function(data) {
							console.log("Ajax Error!");
							console.log(data);
						  }
						}); // end ajax call
					}
				});
				e.preventDefault();
			  });

			  // Close Checkout on page navigation
			  $(window).on('popstate', function() {
				handler.close();
			  });
			</script> -->
<!-- Stripe Gateway End -->

</body>
<?php
}
?>
