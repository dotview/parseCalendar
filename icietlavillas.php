<?php


class icietlavillas{
	private $url;

   function __construct($url) {
     $this->url = $url;
    }
	public function getinfo()
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