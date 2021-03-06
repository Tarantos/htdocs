<html>
<head>
	<title>Tarantos Inventory Tracking System - Front Inventory Count</title>
	<link rel="stylesheet" type="text/css" href="tstyle.css" />



	<script type="text/javascript"> 

	function stopRKey(evt) { 
 		var evt = (evt) ? evt : ((event) ? event : null); 
  		var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  		if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
	} 

	document.onkeypress = stopRKey; 

	</script>

</head>
	
<body>


	<!-- MENU SYSTEM -->
	<div id="menuLayout">
	<h4>Taranto's Inventory Tracking System</h4>
	<ul id="menuLinks">
	<li>
		<a href="./index.php">Home</a>
	</li>
	<li>
		<a href="./AddItem.php">Manage Items</a>
	</li>
	<li>
		<a href="NewInv.php">New Inventory Count</a>
	</li>
	</div>
	<!-- MENU SYSTEM -->


<div id="container">
<h4>Front Inventory</h4>
<?php

	$db = new PDO('sqlite:inventory.db');


		$product = $db->query("SELECT * FROM sqlite_master WHERE name != 'items' AND name NOT LIKE 'loc%' ORDER BY name");
		$prodTables = $product->fetchAll();
		foreach($prodTables as $prod){
			$prodTableName = $prod['name'];

			//Get items in location sorted by product
			$itemObj = $db->query("SELECT * FROM items 
						JOIN $prodTableName ON $prodTableName.ItemID = items.itemIDNum
						JOIN locKitchen ON locKitchen.ItemID = items.itemIDNum ORDER BY descrip");
			$items = $itemObj->fetchAll();
			
			$size = sizeof($items);
			if($size > 0){
				print "<h4>$prodTableName</h4>";
			}
			print "<div id='itemInput'>";
			print "<ul style='inline'>";
			foreach($items as $item){
				$itemNum = $item['itemIDNum'];
				$itemName = $item['descrip'];

				print "<form action=\"count.php?table=$locName&item=$itemNum\" method=\"POST\" >";
				print "<li><ul>";
				print "<li>$itemName:</li>";
				print "<li>Case Count";
				print "<input type='text' name='cases' value='' size='3' />";
				print "</li><li>Item Count";
				print "<input type='text' name='singles' value='' size='3' />";
				print "</li></ul>";
				print "<input type='submit' value='Add count' />";
				print '</form>';
			}//end foreach($items...)
			print "</ul>";
			print "</div>";
		}//end foreach($prodTables...)


	$db = NULL;
	
	print '<div id="footer">';
		print '<b>Tarantos Inventory Tracking System</b>';
	print '</div>';
	
	print '</div>'; // end Container
	print '</body>';
	print '</html>';
?>
