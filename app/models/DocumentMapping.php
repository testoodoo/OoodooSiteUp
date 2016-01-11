<?php 
//namespace Intervention\Image\Gd;
//use \Intervention\Image\Size;
use Image;

class DocumentMapping extends Eloquent {

	protected $table ='document_mapping';

	public static function map($file_id,$params){
		$dm = new DocumentMapping();
		$dm->owner_id = $params["owner_id"];
		$dm->owner_type = $params["owner_type"];
		$dm->file_id = $file_id;
		$dm->document_type =$params["proof_type"];
       	var_dump($params);die;
		$dm->save();
	}

	public function document(){
		return $this->belongsTo('FileUpload','file_id');
	}
    
 
}