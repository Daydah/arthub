<?php
session_start();
function searchforcode($sentcode,$thearray){
  $key = array_search($sentcode, array_column($thearray, 'code'));
  return $key;
}
$nairasign = "₦"; $ipath = "product-images/";
$delivery = '1000.00'; $vat = '7.5'; $vata = 0; $fintotal = 0; $returnmsg = "";
  $prods = array(
    /* array(
      "pname" => "Clocks",
      "pimage" => "img-03.jpg",
      "pviews" => "9,906",
      "pprice" => 1560,
      "code" => "0"
    ),
    array(
      "pname" => "Plants",
      "pimage" => "img-04.jpg",
      "pviews" => "16,100",
      "pprice" => 2450,
      "code" => "1",
    ),
    array(
      "pname" => "Morning",
      "pimage" => "img-05.jpg",
      "pviews" => "12,460",
      "pprice" => 3645,
      "code" => "2"
    ),
    array(
      "pname" => "Pinky",
      "pimage" => "img-06.jpg",
      "pviews" => "11,402",
      "pprice" => 2800, "code" => "3"
    ),
    array(
      "pname" => "Hangers",
      "pimage" => "img-01.jpg",
      "pviews" => "16,008",
      "pprice" => 3460, "code" => "4"
    ),
    array(
      "pname" => "Perfumes",
      "pimage" => "img-02.jpg",
      "pviews" => "12,860",
      "pprice" => 8950, "code" => "5"
    ),
    array(
      "pname" => "Bus",
      "pimage" => "img-07.jpg",
      "pviews" => "10,900",
      "pprice" => 4680, "code" => "6"
    ),
    array(
      "pname" => "New York",
      "pimage" => "img-08.jpg",
      "pviews" => "11,300",
      "pprice" => 5000, "code" => "7"
    )*/
    array(
      "id" => 1,
          "name" => 'FinePix Pro2 3D Camera',
          "creator" => 'Opeyemi',
          "code" => '3DcAM01',
          "image" => 'camera.jpg',
          "price" => 1500.00
         ),
    array(
      "id" => 2,
          "name" => 'EXP Portable Hard Drive',
          "creator" => 'Edalolo',
          "code" => 'USB02',
      "image" => 'external-hard-drive.jpg',
          "price" => 800.00
         ),
    array(
      "id" => 3,
      "name" => 'Luxury Ultra thin Wrist Watch',
      "creator" => 'Opeyemi',
      "code" => 'wristWear03',
      "image" =>'watch.jpg',
      "price" => 300.00
         ),
    array(
      "id" => 4,
          "name" => 'XP 1155 Intel Core Laptop',
          "creator" => 'Edalolo',
          "code" => 'LPN45',
        "image" => 'laptop.jpg',
          "price" => 800.00
         ),
    array(
      "id" => 5,
          "name" => 'New York',
          "creator" => 'Daydah',
          "code" => 'APL45',
        "image" => 'laptop.jpg',
          "price" => 11300.00
         )
    );

if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!empty($_POST["quantity"])) {

      //search the array for the sent code{}
      $pbc =searchforcode($_GET["code"],$prods);//print_r($pbc);
      $productByCode = $prods; //print_r($productByCode[$pbc]);

			$itemArray = array($productByCode[$pbc]["code"]=>array('name'=>$productByCode[$pbc]["name"], 'code'=>$productByCode[$pbc]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[$pbc]["price"], 'image'=>$productByCode[$pbc]["image"], 'creator'=>$productByCode[$pbc]["creator"]));

			if(!empty($_SESSION["cart_item"])) {
				if(in_array($productByCode[$pbc]["code"],array_keys($_SESSION["cart_item"]))) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[$pbc]["code"] == $k) {
								if(empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}
								$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
							}
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		}
	break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["code"] == $k)
						unset($_SESSION["cart_item"][$k]);
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
	break;
}
}
if(!empty($_GET["email"])){
  $returnmsg = "A bill of ".$_SESSION["fintotal"] ." has been charged to ".$_GET["email"];
  unset($_SESSION["cart_item"]);
}
?>
<HTML>
	<HEAD>
		<TITLE>ArtHub</TITLE>
		<link href="style.css" type="text/css" rel="stylesheet" />
	</HEAD>
	<BODY>
		<div id="shopping-cart">
		<div class="txt-heading">Shopping Cart</div>

<a id="btnEmpty" href="index.php?action=empty">Empty Cart</a> &nbsp;
<div><?php echo $returnmsg; ?> </div>
<?php
if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;
?>
<table class="tbl-cart" cellpadding="10" cellspacing="1">
<tbody>
<tr>
<th style="text-align:left;">Name</th>
<th style="text-align:left;">Code</th>
<th style="text-align:left;">Creator</th>
<th style="text-align:right;" width="5%">Quantity</th>
<th style="text-align:right;" width="10%">Unit Price</th>
<th style="text-align:right;" width="10%">Price</th>
<th style="text-align:center;" width="5%">Remove</th>
</tr>
<?php
    foreach ($_SESSION["cart_item"] as $item){
        $item_price = $item["quantity"]*$item["price"];
		?>
				<tr>
				<td><img src="<?php echo $ipath.$item["image"]; ?>" class="cart-item-image" /><?php echo $item["name"]; ?></td>
        <td><?php echo $item["code"]; ?></td>
				<td><?php echo $item["creator"]; ?></td>
				<td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
				<td  style="text-align:right;"><?php echo $nairasign.$item["price"]; ?></td>
				<td  style="text-align:right;"><?php echo $nairasign. number_format($item_price,2); ?></td>
				<td style="text-align:center;"><a href="index.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
				</tr>
				<?php
				$total_quantity += $item["quantity"];
				$total_price += ($item["price"]*$item["quantity"]);
		}
		?>

<tr>
<td colspan="3" align="right">SubTotal:</td>
<td align="right"><?php echo $total_quantity; ?></td>
<td align="right" colspan="2"><strong><?php echo $nairasign.number_format($total_price, 2); ?></strong></td>
<td></td>
</tr>
<tr>
  <td colspan="4" align="right">Delivery fees:</td>
  <td colspan="2" align="right"><?php echo $nairasign.number_format($delivery, 2); ?></td>
  <td></td>
</tr>
<tr>
  <td colspan="4" align="right">VAT(7.5%):</td>
  <td colspan="2" align="right"><?php $vata = (7.5/100)*$total_price; echo $nairasign.number_format($vata, 2); ?></td>
  <td></td>
</tr>
<tr>
  <td colspan="4" align="right">Total:</td>
  <td colspan="2" align="right"><?php $fintotal = $total_price+$delivery+$vata; echo '<strong>'.$nairasign.number_format($fintotal, 2).'</strong>'; ?></td>
  <td></td>
</tr>
</tbody>
</table>
<?php /* add the other cart elements to the session */
  $_SESSION["fintotal"] = $fintotal;
  //$_SESSION[""]
  ?>
<a id="btnEmpty" href="checkout.php">Check Out</a> &nbsp;
  <?php
} else {
?>
<div class="no-records">Your Cart is Empty</div>
<?php
}
?>
</div>

<div id="product-grid">
	<div class="txt-heading">Products</div>
	<?php
	$product_array = $prods;
	if (!empty($product_array)) {
		foreach($product_array as $key=>$value){
	?>
		<div class="product-item">
			<form method="post" action="index.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
			<div class="product-image"><img src="<?php echo $ipath.$product_array[$key]["image"]; ?>"></div>
			<div class="product-tile-footer">
			<div class="product-title"><?php echo '<strong>'.$product_array[$key]["name"].'</strong><br/>By '.$product_array[$key]["creator"]; ?></div>
			<div class="product-price"><?php echo $nairasign.$product_array[$key]["price"]; ?></div>
			<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
			</div>
			</form>
		</div>
	<?php
		}
	}
	?>
</div>
</BODY>
</HTML>
