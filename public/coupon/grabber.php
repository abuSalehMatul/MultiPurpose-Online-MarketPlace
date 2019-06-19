<?php 

@$str = file_get_contents($_GET['url']); 
 // file_get_contents($main_url);


   //This Code Block is used to extract title
   if(strlen($str)>0)
   {
     $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
     preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title);
   }


   // This Code Block is used to extract any image 1st image of the webpage
   $dom = new domDocument;
   @$dom->loadHTML($str);
   $images = $dom->getElementsByTagName('img');
   foreach ($images as $image)
   {
     $l1=@parse_url($image->getAttribute('src'));
     $a = $image->getAttribute('src');
     if(preg_match("/^http|.jpg$/", $a))
     {
     	$data = getimagesize($a);
     	// if($data[1]>100){
		   	$img[]=$image->getAttribute('src'); 
		   // }
	   }
   }

// echo 
echo "<ul><li><img src='".$img[0]."'><br></li></li><li><img src='".$img[1]."'><br></li><li><img src='".$img[2]."'><br></li></li><li><img src='".$img[3]."'><br></li></li><li><img src='".$img[6]."'><br></li></ul>";
// $url = "http://www.flipkart.com/rado-analog-watch-women/p/itmdsvdxqb3y3jvp?affid=amitlabnol";

// $response = getPriceFromFlipkart($_GET['url']);
// // $response = getPriceFromFlipkart($url);

// echo json_encode($response);

// /* Returns the response in JSON format */

// function getPriceFromFlipkart($url) {

// 	$curl = curl_init($url);
// 	curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 10.10; labnol;) ctrlq.org");
// 	curl_setopt($curl, CURLOPT_FAILONERROR, true);
// 	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
// 	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// 	$html = curl_exec($curl);
// 	curl_close($curl);

// 	$regex = '/<meta itemprop="price" content="([^"]*)"/';
// 	preg_match($regex, $html, $price);

// 	$regex = '/<h1[^>]*>([^<]*)<\/h1>/';
// 	preg_match($regex, $html, $title);

// 	$regex = '/data-src="([^"]*)"/i';
// 	preg_match($regex, $html, $image);

// 	if ($price && $title && $image) {
// 		$response = array("price" => "Rs. $price[1].00", "image" => $image[1], "title" => $title[1], "status" => "200");
// 	} else {
// 		$response = array("status" => "404", "error" => "We could not find the product details on Flipkart $url");
// 	}

// 	return $response;
// }







?>
