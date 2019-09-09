<?php
set_time_limit(120);
include 'simple_html_dom.php';
$keyword = get_option('rcl-first');
$rank = $_SERVER['SERVER_NAME'];;
$pagenum = 1;
$posnum = Array();
$pagerank = 0;
$found = 0;
for($page = 0; $page<100; $page+=10){
$html = new simple_html_dom();
$html = file_get_html('https://www.google.com/search?q='.$keyword.'&start='.$page.'');
if(substr_count($html->plaintext, $rank) > 0){
$found = 1;
foreach($html->find('a') as $link){
    if(substr_count($link->href, '/url?') > 0){
   // $position = strripos($link->href, "//");
    //$substring = substr($link->href,$position+2);
   //$value = strtok($substring,"/");
    //echo $link->href. '<br>';
    array_push($posnum, $link->href);
   } 
}
}
if($found){
    break;
}
else{
    $pagenum+=1;
}
}
if($found){
$finalresult = array_unique($posnum);
for($i=0; $i<count($finalresult); $i++){
    $fstring = $finalresult[$i];
    if(substr_count($fstring,$rank)>0){
      break;
    }
    $pagerank+=1;
 }
echo '<h3>Keyword ['.$keyword.'] is on page number '.$pagenum.' on google</h3>';
echo '<h3>And on page position is '.($pagerank+1).'</h3>';
}
else{
echo '<h3>Your site is not found! in top 10 results of google for this keyword ['.$keyword .']</h3>';
}
include 'mail.php';
?>