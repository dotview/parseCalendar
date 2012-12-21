<?php


class vrbo{
	private $url;

    function __construct() 
	{
		//..
    }
	public function getinfo($url)
	{
		// Create DOM from URL or file
		$html = file_get_html($url);
 
		foreach($html->find('div[class=cal-month]') as $row) {
			$mon_name = $row->find('b',0)->plaintext;

			foreach($row->find('table tr td') as $calMonthTD) {
				$status = "open";
				if(isset($calMonthTD->class) && $calMonthTD->class == "strike"){
					$status = "close";
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
	//no third party plugin using
	function getinfo_raw($url){
		$pagecontent=getwebcontent($this->url);
		preg_match_all("/<div class=\"cal-month\">.*?<\/div>/si", $pagecontent, $match);
		$months = $match[0];
		for ($i=0;$i<count($months);$i++){
			$month = $months[$i];
			preg_match_all("/<b>(.*?)<\/b>/si", $month , $match2);
			$mon_name = $match2[1][0];
			
			$tmp_tr="/<tr.*>(.*)<\/tr>/iUs"; 
			$tmp_td="/<td.*>(.*)<\/td>/iUs"; 
			$tmp="/<strike>(.*)<\/strike>/iUs"; 
			
			preg_match_all($tmp_tr,$month,$macthes); 
			$trs = $macthes[1];
			
			for ($j=1;$j<count($trs);$j++){
				$tr = $trs[$j];
				preg_match_all($tmp_td,$tr,$td); 
				$tds =$td[1]; 
				
				for ($k=0;$k<count($tds);$k++){
					$cell = $tds[$k];
					$cell=preg_replace("/<span.*>.*?<\/span>/si","",$cell);
					preg_match_all($tmp,$cell,$day); 
					$output = count($day[1])>0 ?   $day[1] : $cell;
					if(count($day[1])>0){
					$this->insertdb($mon_name,$day[1][0]);
					}
				} 
			}/*end for trs*/ 
		}/*end for months*/ 
	}
}


?>