<?php


class icietlavillas{
	private $url;

    function __construct() 
	{
		//..
    }
	public function getinfo($url)
	{
		// Create DOM from URL or file
		$html = file_get_html($url);
 
		foreach($html->find("table[class=monthContent]") as $row) {
			foreach($row->find('tr th[class=month]') as $calMonthTitle) {
				if(stripos($calMonthTitle->outertext,"colspan")>0){
					$mon_name = $calMonthTitle->plaintext;
				}
			}
			foreach($row->find('tr td') as $calMonthTD) {
				$status = "open";
				//if($calMonthTD->find('td[class*=busy]',0)){
				if(stripos($calMonthTD->outertext,"busy")>0){
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
	
	function getinfo_raw()
	{
		$pagecontent=getwebcontent($this->url);
		preg_match_all("/<table class=\"monthContent\">([\s\S]*?)<\/table>/", $pagecontent, $content);
		$content= $content[1];
		//print_r($content);
		for ($i=0;$i<count($content);$i++){
			$month = $content[$i];
	
			$tmp_tr="/<tr.*>(.*)<\/tr>/iUs"; 
			$tmp_td="/<td.*>(.*)<\/td>/iUs"; 
			$tmp="/<td class=\"busy\">.*?<\/span>/iUs"; 
			
			preg_match_all($tmp_tr,$month,$macthes); 
			$trs = $macthes[1];
			$thead = $trs[0];
			if($i==0){
				preg_match_all("/<th colspan=\"5\" class=\"month previousMonth\">(.*)<\/th>/iU", $thead , $match2);
			}elseif($i==1){
				preg_match_all("/<th colspan=\"7\" class=\"month\">(.*)<\/th>/iU", $thead , $match2);
			}elseif($i==2){
				preg_match_all("/<th colspan=\"5\" class=\"month nextMonth\">(.*)<\/th>/iU", $thead , $match2);
			}
			$mon_name = count($match2[1])>0 ?   $match2[1][0] : "";
			//echo $mon_name;
			for ($j=2;$j<count($trs);$j++){
				$tr = $trs[$j];
				preg_match_all($tmp_td,$tr,$td); 
				$tds =$td[1]; 
				$tds0 =$td[0]; 
				
				for ($k=0;$k<count($tds);$k++){
					$cell = $tds[$k];
					preg_replace("/&nbsp;/si","",$cell);
					
					//print_r($cell);
					 
					if(stripos($tds0[$k],"busy")>0){
			 
					$this->insertdb($mon_name,$cell);
					}
				} 
			} 
		}
	}
}


?>