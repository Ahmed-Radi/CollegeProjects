<?php

class simulationClass {

	public $Demand = [];
	public $LeadTime = [];
	public $Inventory = [];
	public $OrderQuantity;
	public $ReorderPoint;
	public $DCounter;
	public $LCounter;
	

	public function __construct($D,$DF,$DP,$DRN,$LT,$LF,$LP,$LRN,$NOD,$OQ,$RP) {
		
		$D = array_map('intval',explode('-',trim(preg_replace('/\s\s+/', '-', $D))));
		$DF = array_map('intval',explode('-',trim(preg_replace('/\s\s+/', '-', $DF))));
		$DP = array_map('floatval',explode('-',trim(preg_replace('/\s\s+/', '-', $DP))));
		$DRN = array_map('intval',explode('-',trim(preg_replace('/\s\s+/', '-', $DRN))));
		$LT = array_map('intval',explode('-',trim(preg_replace('/\s\s+/', '-', $LT))));
		$LF = array_map('intval',explode('-',trim(preg_replace('/\s\s+/', '-', $LF))));
		$LP = array_map('floatval',explode('-',trim(preg_replace('/\s\s+/', '-', $LP))));
		$LRN = array_map('intval',explode('-',trim(preg_replace('/\s\s+/', '-', $LRN))));
		$NOD = preg_replace('/[^0-9]/','',$NOD);

		$this->OrderQuantity = preg_replace('/[^0-9]/','',$OQ);
		$this->ReorderPoint = preg_replace('/[^0-9]/','',$RP);
		$this->Demand = array("Demand" => $D, "Frequancy" => $DF , "Probability" => $DP , "Cumulative" => array() , "Interval" => array() );
		$this->LeadTime = array("LeadTime" => $LT, "Frequancy" => $LF , "Probability" => $LP , "Cumulative" => array() , "Interval" => array() , "RandomNumbers" => $LRN);
		$this->Inventory = array("Days" => $NOD, "UnitRecived" => array() , "BeginnigIventory" => array() , "DRandomNumbers" => $DRN , "IDemand" => array() , "EndingInventory" => array() , "LostSales" => array() , "Order" => array() , "LRandomNumbers" => array() , "ILeadTime" => array());
		
		if(count($this->Demand["Probability"]) <=1)
			count($this->Demand["Frequancy"]) > count($this->Demand["Demand"]) ? $this->DCounter = count($this->Demand["Demand"]) : $this->DCounter = count($this->Demand["Frequancy"]);
		else
			count($this->Demand["Probability"]) > count($this->Demand["Demand"]) ? $this->DCounter = count($this->Demand["Demand"]) : $this->DCounter = count($this->Demand["Probability"]);

		if(count($this->LeadTime["Probability"]) <=1){
			count($this->LeadTime["Frequancy"]) > count($this->LeadTime["LeadTime"]) ? $this->LCounter = count($this->LeadTime["LeadTime"]) : $this->LCounter = count($this->LeadTime["Frequancy"]);}
		else{
			count($this->LeadTime["Probability"]) > count($this->LeadTime["LeadTime"]) ? $this->LCounter = count($this->LeadTime["LeadTime"]) : $this->LCounter = count($this->LeadTime["Probability"]);}

	}

	public function DemandTable() {
		$sum= array_sum($this->Demand["Frequancy"]);
		$sum == 0 ? $sum = 1 : $sum;
		if(count($this->Demand["Probability"]) <= 1){
		for($y = 0 ; $y < $this->DCounter ; $y++){
			$this->Demand["Probability"][$y] = round($this->Demand["Frequancy"][$y]/$sum,2);
		}}

		for($y = 0 ; $y < $this->DCounter ; $y++){
			
			if($y==0)
				$this->Demand["Cumulative"][$y] = round($this->Demand["Probability"][$y],2);
			else
				$this->Demand["Cumulative"][$y] = round($this->Demand["Probability"][$y]+$this->Demand["Cumulative"][$y-1],2);

			$this->Demand["Interval"][$y] = round($this->Demand["Cumulative"][$y]*100,0);
		}
		
	}

	public function LeadTimeTable() {
		$sum= array_sum($this->LeadTime["Frequancy"]);
		$sum == 0 ? $sum = 1 : $sum;

		if(count($this->LeadTime["Probability"]) <=1){

		for($y = 0 ; $y < $this->LCounter ; $y++){
			$this->LeadTime["Probability"][$y] = round($this->LeadTime["Frequancy"][$y]/$sum,2);
		}}
		
		for($y = 0 ; $y < $this->LCounter ; $y++){

			if($y==0)
				$this->LeadTime["Cumulative"][$y] = round($this->LeadTime["Probability"][$y],2);
			else
				$this->LeadTime["Cumulative"][$y] = round($this->LeadTime["Probability"][$y]+$this->LeadTime["Cumulative"][$y-1],2);

			$this->LeadTime["Interval"][$y] = round($this->LeadTime["Cumulative"][$y]*100,0);
		}
		
	}

	public function InventoryTable() {
		$x = $this->Inventory["Days"];
		$z=0;
		$A=0;
		$i=-1;
		
		for($y = 0 ; $y < $x ; $y++){
			if(!isset($this->Inventory["DRandomNumbers"][$y])){
				$this->Inventory["DRandomNumbers"][$y] = 0;
			}
			if(!isset($this->LeadTime["RandomNumbers"][$y])){
				$this->LeadTime["RandomNumbers"][$y] = 0;
			}
			

			if($y == 0){ 
				$this->Inventory["UnitRecived"][$y] = '...';
				$this->Inventory["BeginnigIventory"][$y] = $this->OrderQuantity;
			} 
			else{if($i == $y && $z == 1){
				$this->Inventory["UnitRecived"][$y] = $this->OrderQuantity ;
				$this->Inventory["BeginnigIventory"][$y] = $this->OrderQuantity;
				$z=0;
				}
				else{ $this->Inventory["UnitRecived"][$y] = 0;
					$this->Inventory["BeginnigIventory"][$y] = $this->Inventory["EndingInventory"][$y-1];}
			}

			for($A = 0 ; $A < $this->DCounter ; $A++){
				if( $this->Inventory["DRandomNumbers"][$y] > $this->Demand["Interval"][$A])	
					isset($this->Demand["Demand"][$A+1]) ? $this->Inventory["IDemand"][$y] = $this->Demand["Demand"][$A+1] : $this->Inventory["IDemand"][$y] = 0;
				else {if($this->Inventory["DRandomNumbers"][$y] < 1){$this->Inventory["IDemand"][$y] = 0;break;}
				      else {$this->Inventory["IDemand"][$y] = $this->Demand["Demand"][$A];break;}}
			}

			if($this->Inventory["BeginnigIventory"][$y] - $this->Inventory["IDemand"][$y] > 0)
				$this->Inventory["EndingInventory"][$y] = $this->Inventory["BeginnigIventory"][$y] - $this->Inventory["IDemand"][$y];
			else
				$this->Inventory["EndingInventory"][$y] = 0;

			
			if($this->Inventory["BeginnigIventory"][$y] - $this->Inventory["IDemand"][$y] > -1)
				$this->Inventory["LostSales"][$y] =0;
			else
				$this->Inventory["LostSales"][$y] = $this->Inventory["IDemand"][$y] - $this->Inventory["BeginnigIventory"][$y];
			

			if($this->Inventory["EndingInventory"][$y] < $this->ReorderPoint+1 && $z==0){
				$this->Inventory["Order"][$y] = 1;
				$this->Inventory["LRandomNumbers"][$y] = $this->LeadTime["RandomNumbers"][$y];

				for($A = 0 ; $A < $this->LCounter ; $A++){
					if($this->LeadTime["RandomNumbers"][$y] > $this->LeadTime["Interval"][$A]){
						isset($this->LeadTime["LeadTime"][$A+1]) ? $i = $this->Inventory["ILeadTime"][$y] = $this->LeadTime["LeadTime"][$A+1] : $i = $this->Inventory["ILeadTime"][$y] = 0;}
					else {if($this->LeadTime["RandomNumbers"][$y] < 1){$i = $this->Inventory["ILeadTime"][$y] = 0;break;}
					      else{$i = $this->Inventory["ILeadTime"][$y] = $this->LeadTime["LeadTime"][$A];break;}}
				}
				$z=1;
				$i+=$y+1;

			}
			else{$this->Inventory["Order"][$y] = '0';
			$this->Inventory["LRandomNumbers"][$y] = NULL;
			$this->Inventory["ILeadTime"][$y] = NULL;}
			
			

			
			
		}
		
	}

	
}
?>		
