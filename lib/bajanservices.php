<?php


class bajanservices{
	private $url;

	function __construct() {
    }
	public function getinfo($url)
	{
		// Create DOM from URL or file
		$html = file_get_html($url);
		
		$div = $html->find('div[class=CalendarPanel]',0);
		$i =0;
		foreach($div->find('tr[id]') as $calMonthTBs) {
			$calMonthTB = $calMonthTBs->find('table',0);
			//$calMonthTitle = $calMonthTB->find('td.CalendarMonth',0)->plaintext;
			foreach($div->find('table') as $calMonthTB) {
				echo $i;$i++;
			}
			
			$calMonth = $calMonthTBs->find('table',1);
		}
	}
	
	function savetodb($mon_name,$day,$status){ 
		//format date
		
		//savetodb
		$daytime =  strftime("%d %b %Y",strtotime($day."-".$mon_name));
		echo $daytime.$status."<br>";
	}
	
	public function getinfo_raw($url)
	{
		$this->url = $url;
		$pagecontent=getwebcontent($this->url);
		preg_match_all("/<div id=\"RoomDetailsTabs1_uwtTabs__ctl2_RoomDetailsCalendar1_pnlCalendar\" class=\"CalendarPanel\" align=\"center\">.*?<\/div>/si", $pagecontent, $match);
		
		print_r($pagecontent);exit;
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
			} 
		}
	}
}


?>