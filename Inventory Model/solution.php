<?php 
include "simulationClass.php";
?>
<!DOCTYPR html>
<html>
    <head>
        
        <meta charset="UTF-8">
		<!--translate html5 in Edge -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!--translate html5 in phone -->
		<meta name="viewport" content="width=device-width, intial-scale=1">
		<title></title>
		<link rel='stylesheet' href='css/bootstrap.css'>
		<link rel='stylesheet' href='css/style.css'>	<!-- your css -->
        <title>Inventory Model</title>
        
    </head>
    <body class="container-fluid" style="padding: 0px;background-image: url(math-background-design-hd-7.jpg);background-size: cover">
        
        <div class="col-lg-6 col-lg-push-3 QUES">
             <h2>Inventory Model</h2>

<?
if(isset($_GET['Demand'],$_GET['D-Freq'],$_GET['D-Prob'],$_GET['D-RN'],$_GET['LeadTime'],$_GET['L-Freq'],$_GET['L-Prob'],$_GET['L-RN'],$_GET['NOD'],$_GET['OQ'],$_GET['RP'])&&$_GET['OQ']>$_GET['RP']){
if(($_GET['D-Prob'] == NULL || $_GET['D-Freq'] == NULL)&&($_GET['L-Prob'] == NULL || $_GET['L-Freq'] == NULL)){
$solve = new simulationClass($_GET['Demand'],$_GET['D-Freq'],$_GET['D-Prob'],$_GET['D-RN'],$_GET['LeadTime'],$_GET['L-Freq'],$_GET['L-Prob'],$_GET['L-RN'],$_GET['NOD'],$_GET['OQ'],$_GET['RP']);
$solve->DemandTable();
$solve->LeadTimeTable();
$solve->InventoryTable();
?>
            <table>
                <tr>
                    <th>Demand</th>
                    <th>Frequence</th>
                    <th>Probability</th>
                    <th>Cumulative</th>
                    <th>Interval RN</th>
                <tr>
<?
		$y;
		for($y = 0 ; $y < $solve->DCounter ; $y++){
			echo 	"<tr>
					<td>".$solve->Demand['Demand'][$y]."</td>
					<td>".(empty($solve->Demand['Frequancy'][$y]) ? ' ' : $solve->Demand['Frequancy'][$y])."</td>
					<td>".$solve->Demand['Probability'][$y]."</td>
					<td>".$solve->Demand['Cumulative'][$y]."</td>
					<td>".($y == 0 ? '01' : ($solve->Demand['Interval'][$y-1]+1))." to ".$solve->Demand['Interval'][$y]."</td>
				</tr>";
		}

?>
            </table>
            <table >
                <tr>
                    <th>LeadTime</th>
                    <th>Frequence</th>
                    <th>Probability</th>
                    <th>Cumulative</th>
                    <th>Interval RN</th>
                <tr>
<?
		$y;
		for($y = 0 ; $y < $solve->LCounter ; $y++){
			
			echo 	"<tr>
					<td>".$solve->LeadTime['LeadTime'][$y]."</td>
					<td>".(empty($solve->LeadTime['Frequancy'][$y]) ? ' ' : $solve->LeadTime['Frequancy'][$y])."</td>
					<td>".$solve->LeadTime['Probability'][$y]."</td>
					<td>".$solve->LeadTime['Cumulative'][$y]."</td>
					<td>".($y == 0 ? '01' : ($solve->LeadTime['Interval'][$y-1]+1))." to ".$solve->LeadTime['Interval'][$y]."</td>
				</tr>";
		}

?>
            </table>
            <table>
                <caption>Order Quantity= <?echo $solve->OrderQuantity;?> Reoder Point = <?echo $solve->ReorderPoint;?></caption>
                <tr>
                    <th>Day</th>
                    <th>Units<br>Received</th>
                    <th>Beginning<br>Inventory</th>
                    <th>Random<br>Number</th>
		    <th>Demand</th>
                    <th>Ending<br>Inventory</th>
                    <th>Lost<br>Sales</th>
                    <th>Order</th>
                    <th>Random<br>Number</th>
                    <th>Lead<br>Time</th>
                <tr>
<?
		
		$x = $solve->Inventory['Days'];
		$y;
		for($y = 0 ; $y < $x ; $y++){
			if(isset($solve->Inventory['UnitRecived'][$y],$solve->Inventory['BeginnigIventory'][$y],$solve->Inventory['DRandomNumbers'][$y],$solve->Inventory['IDemand'][$y])){

			echo 	"<tr>
					<td>".($y+1)."</td>
					<td>".$solve->Inventory['UnitRecived'][$y]."</td>
					<td>".$solve->Inventory['BeginnigIventory'][$y]."</td>
					<td>".$solve->Inventory['DRandomNumbers'][$y]."</td>
					<td>".$solve->Inventory['IDemand'][$y]."</td>
					<td>".$solve->Inventory['EndingInventory'][$y]."</td>
					<td>".$solve->Inventory['LostSales'][$y]."</td>
					<td>".($solve->Inventory['Order'][$y] == 1 ? 'yes' : 'no')."</td>
					<td>".$solve->Inventory['LRandomNumbers'][$y]."</td>
					<td>".(isset($solve->Inventory['ILeadTime'][$y]) ? $solve->Inventory['ILeadTime'][$y] : NULL)."</td>
				</tr>";
			}
		}

?>
            </table>
		
		<div class ='col-lg-4' style="font-style: family;font-size: 15px; font-weight:bold"> Average ending inventory = <?count($solve->Inventory['EndingInventory']) > 0 ?  print_r(array_sum($solve->Inventory['EndingInventory'])/count($solve->Inventory['EndingInventory'])) :  '0'; ?></div>
		<div class ='col-lg-4' style="font-style: family;font-size: 15px; font-weight:bold"> Average lost sales = <?count($solve->Inventory['LostSales']) > 0 ?  print_r(array_sum($solve->Inventory['LostSales'])/count($solve->Inventory['LostSales'])) :  '0'; ?></div>
		<div class ='col-lg-4' style="font-style: family;font-size: 15px; font-weight:bold"> Average number of orders = <?count($solve->Inventory['Order']) > 0 ?  print_r(array_sum($solve->Inventory['Order'])/count($solve->Inventory['Order'])) :  '0'; ?></div>

<?}}?>
            <div class ="col-lg-12"style="text-align: center; padding: 20px;font-size: 17px;">
                <a href="index.php"> >>>>> Back To Home</a>
            </div>

        </div>

    </body>
</html>
