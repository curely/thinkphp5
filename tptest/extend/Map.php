<?php 
/*
*百度地图封装类
*/

class Map {
	
	/**
	 * [getLngLat description]
	 * @param  [type] $address [地址]
	 * @return [type]  array   [返回数组]
	 */
	
	public static function getLngLat($address){
		
		if(!$address){
			return '';
		}
		$data = [
			'address' => $address,
			'ak' => config('map.ak'),
			'output' => 'json',
		];

		$url = config('map.map_url').config('map.geocoder').'?'.http_build_query($data);
		//1、file_get_content();
		//2、curl
		$result = doCurl($url);
		if($result){
			return json_decode($result, true);
		}else {
			return [];
		}
	}

	/**
	 * [静态图API]
	 * @param  [type] $center [地图中心点位置]
	 * @return [type]         [description]
	 */
	public static function getImage($center){
		if(!$center){
			return '';
		}

		$data = [
			'ak' => config("map.ak"),
			'width' => config("map.width"),
			'height' => config("map.height"),
			'center' => $center,
			'markers' => $center,
		];

		$url = config("map.map_url").config("map.image").'?'.http_build_query($data);
		$result = doCurl($url);
		return $result;
	}
	
}

?>
