<?php

class Jsubs extends \LaravelBook\Ardent\Ardent {

	protected $table = 'jsubs_det';

public function data_usage_in_gb(){
		$usage_bytes_total = $this->bytes_total;
		$get_GB = $usage_bytes_total /1000000000;
		$get_gb_percent = number_format((float)$get_GB, 2, '.', '');
		return $get_gb_percent;
	}

}