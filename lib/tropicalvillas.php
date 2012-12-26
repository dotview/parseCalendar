<?php


class tropicalvillas{
	private $url;

    function __construct() 
	{
		//..
    }
	public function getinfo($url)
	{
		// Create DOM from URL or file
		$html = file_get_html($url);
		foreach($html->find('div[class=calmonth-wrapper]') as $row) {
			$mon_name = $row->find('div[class=month_title]',0)->plaintext; 
			if($mon_name=="Key"){continue;}
			foreach($row->find('table[id=calendar_available] td') as $calMonthTD) {
				$status = "close";
				if(isset($calMonthTD->class) && $calMonthTD->class == "calavailable"){
					$status = "open";
				}
				$day = $calMonthTD->plaintext;
				if($day>0){
					$this->savetodb($mon_name,$day, $status);
				}
			}
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