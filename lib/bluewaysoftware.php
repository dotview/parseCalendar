<?php


class bluewaysoftware{
	private $url;

    function __construct() 
	{
		//..
    }
	public function getinfo($url)
	{
		// Create DOM from URL or file
		$html = file_get_html($url);
		$html =  $html->find('div[id=calendar]',0);
		$index = 0;
		$months = array();
		foreach($html->find('tr[class=months] td') as $row) {
			$months[] = $row->plaintext;
		}

		foreach($html->find('div[class=calendar-container]') as $row) {
			$mon_name = $months[$index];

			foreach($row->find('div[class!=weekDay]') as $calMonthTD) {
				$status = "close";
				if(isset($calMonthTD->class) && $calMonthTD->class == "dayNull"){
					$status = "open";
				}
				$day = $calMonthTD->plaintext;
				if($day>0){
					$this->savetodb($mon_name,$day, $status);
				}
			}
			$index++;
		}
	}
	function savetodb($mon_name,$day,$status){ 
		//format date
		
		//savetodb
		$daytime =  strftime("%d %b %Y",strtotime($day."-".$mon_name));
		echo $daytime.$status."<br>";
	}
}


?>