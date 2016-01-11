<?php

class PreActivationStatus extends Eloquent {

	protected $table = 'pre_activation_status';

	protected $fillable = ['crf_no','fiber','fiber_updated_at','splicing','splicing_updated_at',
							'feasible','feasible_updated_at','ethernet','ethernet_updated_at','hut_boxes',
							'hut_boxes_updated_at','activation','activation_updated_at',
							'configuration','configuration_updated_at'];


}