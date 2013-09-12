<?php
//ループ回数
//$max = 1*1000*1000;
$max = 100*1000;
//$max = 10000;

//試行回数
$cnt = 10;

//データ準備
{
	$feedurl = 'contents.xml';
	$dom     = simplexml_load_file($feedurl, 'SimpleXMLElement', 0);
	$items   = $dom->xpath('//item');
	$item    = array_shift($items);
	$func    = function($str){ return htmlspecialchars($str); };
}

//計測用
$mesure = function() {
  list($m, $s) = explode(' ', microtime());
  return ((float)$m + (float)$s);
};
$format = '%-20s : %3.8fs';

{
	/* ====================================== */
	//echo '数値演算'.PHP_EOL;
	/* ====================================== */

	//数値演算・三項演算子(省略なし)
	$difft=0;
	$test = '?1:0';
	foreach( range(1,$cnt) as $jj ){
		$start = $mesure();
		for( $ii=0; $ii<$max; $ii++  ){
			$title = $max? $max: 1;
		}
		$diff  = $mesure() - $start;
		$difft+= $diff;
		echo sprintf($format,$test,$diff).PHP_EOL;
	}
	echo sprintf($format,'AVG',$difft/$cnt).PHP_EOL.PHP_EOL;

	//数値演算・三項演算子(省略)
	$difft=0;
	$test = '?:0';
	foreach( range(1,$cnt) as $jj ){
		$start = $mesure();
		for( $ii=0; $ii<$max; $ii++  ){
			$title = $max?: 1;
		}
		$diff  = $mesure() - $start;
		$difft+= $diff;
		echo sprintf($format,$test,$diff).PHP_EOL;
	}
	echo sprintf($format,'AVG',$difft/$cnt).PHP_EOL.PHP_EOL;


	//数値演算・if文
	$difft=0;
	$test = 'if(){1}{0}';
	foreach( range(1,$cnt) as $jj ){
		$start = $mesure();
		for( $ii=0; $ii<$max; $ii++  ){
			if( $max ){ $title = $max; }else{ $title = 1; }
		}
		$diff  = $mesure() - $start;
		$difft+= $diff;
		echo sprintf($format,$test,$diff).PHP_EOL;
	}
	echo sprintf($format,'AVG',$difft/$cnt).PHP_EOL.PHP_EOL;


	/* ====================================== */
	//echo 'DOM'.PHP_EOL;
	/* ====================================== */

	//DOM・三項演算子(省略なし)
	$difft=0;
	$test = '->?->:0';
	foreach( range(1,$cnt) as $jj ){
		$start = $mesure();
		for( $ii=0; $ii<$max; $ii++  ){
			$title = $item->title? $item->title : '';
		}
		$diff  = $mesure() - $start;
		$difft+= $diff;
		echo sprintf($format,$test,$diff).PHP_EOL;
	}
	echo sprintf($format,'AVG',$difft/$cnt).PHP_EOL.PHP_EOL;

	//DOM・三項演算子(省略)
	$difft=0;
	$test = '->?:0';
	foreach( range(1,$cnt) as $jj ){
		$start = $mesure();
		for( $ii=0; $ii<$max; $ii++  ){
			$title = $item->title?: '';
		}
		$diff  = $mesure() - $start;
		$difft+= $diff;
		echo sprintf($format,$test,$diff).PHP_EOL;
	}
	echo sprintf($format,'AVG',$difft/$cnt).PHP_EOL.PHP_EOL;

	//DOM・if文
	$difft=0;
	$test = 'if(->){->}{0}';
	foreach( range(1,$cnt) as $jj ){
		$start = $mesure();
		for( $ii=0; $ii<$max; $ii++  ){
			if( $item->title ){ $title = $item->title; }else{ $title=''; }
		}
		$diff  = $mesure() - $start;
		$difft+= $diff;
		echo sprintf($format,$test,$diff).PHP_EOL;
	}
	echo sprintf($format,'AVG',$difft/$cnt).PHP_EOL.PHP_EOL;


	/* ====================================== */
	//echo 'DOM・Function'.PHP_EOL;
	/* ====================================== */

	//DOM・Function・三項演算子(省略なし)
	$difft=0;
	$test = 'f(->)?f(->):0';
	foreach( range(1,$cnt) as $jj ){
		$start = $mesure();
		for( $ii=0; $ii<$max; $ii++  ){
			$title = $func($item->title)? $func($item->title) : '';
		}
		$diff  = $mesure() - $start;
		$difft+= $diff;
		echo sprintf($format,$test,$diff).PHP_EOL;
	}
	echo sprintf($format,'AVG',$difft/$cnt).PHP_EOL.PHP_EOL;

	//DOM・Function・三項演算子(省略)
	$difft=0;
	foreach( range(1,$cnt) as $jj ){
		$test = 'f(->)?:0';
		$start = $mesure();
		for( $ii=0; $ii<$max; $ii++  ){
			$title = $func($item->title)?: '';
		}
		$diff  = $mesure() - $start;
		$difft+= $diff;
		echo sprintf($format,$test,$diff).PHP_EOL;
	}
	echo sprintf($format,'AVG',$difft/$cnt).PHP_EOL.PHP_EOL;

	//DOM・Function・if文
	$difft=0;
	$test = 'if(f(->)){f(->)}{0}';
	foreach( range(1,$cnt) as $jj ){
		$start = $mesure();
		for( $ii=0; $ii<$max; $ii++  ){
			if( $func($item->title) ){ $title = $func($item->title); }else{ $title=''; }
		}
		$diff  = $mesure() - $start;
		$difft+= $diff;
		echo sprintf($format,$test,$diff).PHP_EOL;
	}
	echo sprintf($format,'AVG',$difft/$cnt).PHP_EOL.PHP_EOL;

}
