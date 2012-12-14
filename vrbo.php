<?php


class vrbo{
	private $url;

   function __construct($url) {
     $this->url = $url;
    }
	public function getinfo()
	{
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
			} 
		}
	}
	function insertdb($mon_name,$content){    
		echo $mon_name."-".$content."<br>";
	}
	function getnewscontent($newsurl){
		$newscontent=getwebcontent($newsurl);
		preg_match_all("/<div class=\"cal-month\" id=\"artibody\">([\s\S]*?)<!-- publish_helper_end -->/",$newscontent,$match);
		$content=preg_replace("/<a.*?<\/a>/si","",$match[1][0]);
		$content=preg_replace("/<div style=\"overflow:hidden;zoom:1;\" class=\"otherContent_01\">.*?<\/div>/si","",$content);
		$content=preg_replace("/<div class=\"blk-video\">.*?<div class=\"clearcl\"><\/div>/si","",$content);
		$content=str_replace("<div style=\"clear:both;height:0;visibility:hiddden;overflow:hidden;\"></div>","",$content);
		return $content;
	}
}


?>