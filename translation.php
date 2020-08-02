<?php
if(isset($_POST['syriac_text']))
{
	$html="<div id='name_check_div'>";
	$syriac_text = trim(preg_replace('/[\x{0300}-\x{036f}]+/u', '',$_POST['syriac_text']));
	$original_syriac_text = trim($_POST['syriac_text']);
	
	//print_r($matches);
	//echo $original_syriac_text;
	$grammer_conversion = array('masculine'=>'M','feminine'=>'F','singular'=>'SG','dual'=>'DU','plural'=>'PL','noun'=>'N','verb'=>'V','pronoun'=>'PRO','adjective'=>'ADJ','common'=>'C','participle adjective'=>'ADJ.PTC','preposition'=>'PREP','particle'=>'PTCL','imperfect'=>'PST.IPFV','adjective of place'=>'ADJ','past'=>'PST','perfect'=>'PRF','present'=>'PRS','future'=>'FUT','emphatic'=>'DEF','absolute'=>'STEM','construct'=>'GEN','*proper noun'=>'PN','*demonstrative'=>'DEM','*preposition'=>'P','*conjunction'=>'CONJ','first'=>'1','second'=>'2','third'=>'3');
	$translation_array = array('ܐ'=>"ʾ",'ܒ'=>"b",'ܓ'=>"g",'ܕ'=>"d",'ܗ'=>"h",'ܘ'=>"w",'ܙ'=>"z",'ܚ'=>"h",'ܛ'=>"t",'ܝ'=>"y",'ܟ'=>"k",'ܠ'=>"l",'ܡ'=>"m",'ܢ'=>"n",'ܤ'=>"s",'ܥ'=>"ʿ",'ܦ'=>"p",'ܨ'=>"ṣ",'ܩ'=>"q",'ܪ'=>"r",'ܫ'=>"š",'ܬ'=>"t",'-'=>'-');
	$syriac_array_ex = explode(' ',$syriac_text);
	$original_syriac_array_ex = explode(' ',$original_syriac_text);
/*echo "<pre>";
print_r($syriac_array_ex);
print_r($original_syriac_array_ex);
*/
	$w_by_word_trans = array();
	$a=0;
	foreach ($syriac_array_ex as $key => $value) 
	{
		if($value != "")
		{
			$matches = array();
			preg_match('/ܕ-/', $value, $matches[]);
			preg_match('/ܒ-/', $value, $matches[]);
			preg_match('/ܘ-/', $value, $matches[]);
			preg_match('/ܠ-/', $value, $matches[]);
			$value = trim($value);
			$replace = str_replace("ܕ-","",$value);
			$replace = str_replace("ܒ-","",$replace);
			$replace = str_replace("ܘ-","",$replace);
			$replace = str_replace("ܠ-","",$replace);
			
			//echo "<br>";
			$chars_arr = preg_split('//u',$value, null, PREG_SPLIT_NO_EMPTY);
			$value = $replace;
			$matches = array_reverse($matches);
			$syriac_word = "";
			//echo "<pre>";
			//print_r($chars_arr);
			foreach ($chars_arr as $key2 => $value2) 
			{
				if(array_key_exists($value2,$translation_array))
				{
					$syriac_word .= $value2;
				}
			}
			//echo $syriac_word;
			//exit;

			$encoded_word = urlencode($value);
			$json = @file_get_contents('https://sedra.bethmardutho.org/api/word/'.$encoded_word.".json");
			$word = "";
			foreach ($chars_arr as $key3 => $value3) 
			{
				if(array_key_exists($value3,$translation_array))
				{
					$word .= $translation_array[$value3];	
				}
				
			}

			
			//print_r($matches);

			$string = implode(unpack('H*', iconv("UTF-8","UCS-4BE",$original_syriac_array_ex[$key])));
			$w_by_word_trans[$a]['translation_start'] ='';
			foreach ($matches as $key4 => $value4) 
			{
				if(sizeof($value4)>0)
				{
					if($value4[0] == 'ܕ-')
					{
						$w_by_word_trans[$a]['translation_start'] .='<span style="font-size:12px;display:inline-block;">PTCL</span>-';	
					}

					if($value4[0] == 'ܘ-')
					{
						$w_by_word_trans[$a]['translation_start'] .='<span style="font-size:12px;display:inline-block;">CONJ</span>-';
					}

					if($value4[0] == 'ܒ-')
					{
						$w_by_word_trans[$a]['translation_start'] .='<span style="font-size:12px;display:inline-block;">OBJ</span>-';
					}
					if($value4[0]=='ܠ-')
					{
						$w_by_word_trans[$a]['translation_start'] .='<span style="font-size:12px;display:inline-block;">PREP</span>-';
					}
					/*
					if (strpos($string,implode(unpack('H*', iconv("UTF-8", "UCS-4BE",'ܕ-')))) !== false) 
					{
					    $w_by_word_trans[$a]['translation_start'] .='<span style="font-size:12px;display:inline-block;">PTCL</span>-';
					}
					//echo $w_by_word_trans[$a]['translation_start'];echo "<br>";
					if (strpos($string,implode(unpack('H*', iconv("UTF-8", "UCS-4BE",'-ܘ')))) !== false) 
					{
					    $w_by_word_trans[$a]['translation_start'] .='<span style="font-size:12px;display:inline-block;">CONJ</span>-';
					}
					//echo $w_by_word_trans[$a]['translation_start'];echo "<br>";
					if (strpos($string,implode(unpack('H*', iconv("UTF-8", "UCS-4BE",'-ܒ')))) !== false) 
					{
					    $w_by_word_trans[$a]['translation_start'] .='<span style="font-size:12px;display:inline-block;">OBJ</span>-';
					}
					//echo $w_by_word_trans[$a]['translation_start'];echo "<br>";
					if (strpos($string,implode(unpack('H*', iconv("UTF-8", "UCS-4BE",'-ܠ')))) !== false) 
					{
					    $w_by_word_trans[$a]['translation_start'] .='<span style="font-size:12px;display:inline-block;">PREP</span>-';
					}*/		
				}
			}
			//	echo "<br>";
			
			
			//echo $w_by_word_trans[$a]['translation_start'];
			$array = json_decode($json,true);
			$w_by_word_trans[$a]['translation'] =$array;
			$w_by_word_trans[$a]['our_translation'] =$word;
			$a++;	
		}
		
	}
	
	foreach ($w_by_word_trans as $key => $value) 
	{
		$category = (isset($value['translation'][0]['category']))?((array_key_exists($value['translation'][0]['category'],$grammer_conversion))?$grammer_conversion[$value['translation'][0]['category']]:$value['translation'][0]['category']):"X";
		$person = (isset($value['translation'][0]['person']))?((array_key_exists($value['translation'][0]['person'],$grammer_conversion))?".".$grammer_conversion[$value['translation'][0]['person']]:".".$value['translation'][0]['person']):"";
		$gender = (isset($value['translation'][0]['gender']))?((array_key_exists($value['translation'][0]['gender'],$grammer_conversion))?".".$grammer_conversion[$value['translation'][0]['gender']]:".".$value['translation'][0]['gender']):"";
		
		if($syriac_array_ex[$key] !== $original_syriac_array_ex[$key])
		{
			$number  = '.PL';
		}
		else
		{
			$number = (isset($value['translation'][0]['number']))?((array_key_exists($value['translation'][0]['number'],$grammer_conversion))?".".$grammer_conversion[$value['translation'][0]['number']]:".".$value['translation'][0]['number']):"";
		}
		
		$tense = (isset($value['translation'][0]['tense']))?((array_key_exists($value['translation'][0]['tense'],$grammer_conversion))?".".$grammer_conversion[$value['translation'][0]['tense']]:".".$value['translation'][0]['tense']):"";
		
		$english_trans = "";
		if(sizeof($value['translation'])>0)
		{
			foreach ($value['translation'] as $key2 => $value2) 
			{
				foreach ($value2['glosses']['eng'] as $key3 => $value3) 
				{
					if (strpos($value3, '<span>') !== false) 
					{
					    //echo 'true';
					}
					else
					{
						$english_trans .= $value3;
						$translation = true;
						break;
					}
				}
				if($translation == true)
				{
					break;
				}
			}	
		}
		else
		{
			$english_trans = "X";
		}
		 
		$english_trans = (substr($english_trans, 0, strpos($english_trans,",")) != false)?substr($english_trans, 0, strpos($english_trans,",")):$english_trans;
		//$english_trans = str_replace(' ', '.',$english_trans);
		$english_trans = preg_replace("#[[:punct:]]#","", $english_trans);
		//$english_trans = preg_replace('/[^[:punct:]]/', '', $english_trans);
		$w_by_word_trans[$key]['english_trans'] = $english_trans;
		$w_by_word_trans[$key]['grammer'] = $category.$person.$gender.$number.$tense;
		$html .= '<div style="padding:10px; text-align:left; display:inline-block;">
					<i style="display:block;">'.$w_by_word_trans[$key]['our_translation'].'</i>
					<span>'.$w_by_word_trans[$key]['translation_start'].'</span><span>'.$w_by_word_trans[$key]['english_trans'].'</span>.<span style="font-size:12px;display:inline-block;">'.$w_by_word_trans[$key]['grammer'].'<br>
				  </div>';
	
	}
	$html .="</div>";
	echo $html;
}
?>