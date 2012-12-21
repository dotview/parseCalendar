<?php


class exclusivecaribbean{
	private $url;

	function __construct() {
		require_once("Snoopy.class.php"); 
    }
	public function getinfo($url)
	{
		set_time_limit(0); 
		$snoopy=new Snoopy(); 
 
		//login:shawna@wheretostay.com, password:fiftyfive
		$submit_url = "http://calendar.exclusivecaribbeanproperty.com"; 
		$submit_vars["username"] = "shawna@wheretostay.com"; // 
		$submit_vars["password"] = "fiftyfive"; // 
		$snoopy->submit($submit_url,$submit_vars); 
		if ($snoopy->results) 
		{ 
			$this->extactData($url);
		}		
	}
	public function extactData($url)
	{
		// Create DOM from URL or file
		$html = file_get_html($url);
		echo $html->plaintext;
		
		foreach($html->find("div[class=year_month]") as $row) {
			$mon_name = $row->find('div[class=month_name]',0)->plaintext;
			foreach($row->find('div[rel]') as $calMonthTD) {
				$status = "close";
				if(stripos($calMonthTD->outertext,"dt_on")>0){
					$status = "open";
				}
				$day = $calMonthTD->rel;
				if($day != ""){
					$this->savetodb($mon_name,$day, $status);
				}
			}
		}
	}
	function savetodb($mon_name,$day,$status){ 
		//format date
		
		//savetodb
		$daytime =  strftime("%d %b %Y",strtotime($day));
		echo $daytime.$status."<br>";
	}
 
	
}


?>