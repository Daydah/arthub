<?php
session_start();

  //customer details to check out
if(!empty($_POST["client_email"])) { $email = $_POST["client_email"];
  $return_url = "checkout.php";
  $package_price = $_SESSION["fintotal"];
  $public_key = 'pk_test_a4640295cdec13beeeb8b4b200cdb9f6e2280746';

  $tranx_id = 'arthub002';
  //build the html and javascript form to send out
  	$tosend = '<p>Your order is being processed. Please wait...</p>
	<form id="paystack-pay-form" action="' . $return_url . '" method="post">
  <script src="https://js.paystack.co/v1/inline.js"></script>
   <button id="paystack-pay-btn" style="display:none" type="button" onclick="payWithPaystack()"> Click here </button>

        </form>

<script>
        function formatAmount(amount) {
            var strAmount = amount.toString().split(".");
            var decimalPlaces = strAmount[1] === undefined ? 0: strAmount[1].length;
            var formattedAmount = strAmount[0];

            if (decimalPlaces === 0) {
                formattedAmount += \'00\';

            } else if (decimalPlaces === 1) {
                formattedAmount += strAmount[1] + \'0\';

            } else if (decimalPlaces === 2) {
                formattedAmount += strAmount[1];
            }

            return formattedAmount;
        }

        var amount = formatAmount("' . $package_price . '");

	function payWithPaystack(){
			var handler = PaystackPop.setup({
			  key: \'' . $public_key . '\',
              email: \'' . $email . '\',
			  amount: amount,
			  ref: \'' . $tranx_id . '\',
			  callback: function(response){
                  document.getElementById(\'paystack-pay-form\').submit();
              },
              onClose: function(){
                  document.getElementById(\'paystack-pay-form\').submit();
              }
            });
            handler.openIframe();
          }
          payWithPaystack();

        </script>';

        echo $tosend;
    }
  ?>

<HTML>
	<HEAD>
		<TITLE>Check out - ArtHub</TITLE>
		<link href="style.css" type="text/css" rel="stylesheet" />
	</HEAD>
	<BODY>
		<div id="shopping-cart">
		  <div class="txt-heading">Check Out</div>
      <?php //print_r($_SESSION["cart_item"]);
?>
    <br/>
    <form method="post" action="checkout.php"><br/>
      <label for="client_email">Email: </label>
      <input type="email" name="client_email"/><br/><br/>
      <label for="">Address:</label><br/>

      <textarea id="client_address" name="client_address" rows="4" cols="50">
</textarea><br/><br/>
      <input type="submit" value="Submit" />
    </form>
  </div>
  </BODY>
</HTML>
