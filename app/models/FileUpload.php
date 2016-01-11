<?php

class FileUpload extends Eloquent {

	protected $table = 'file_uploads';

	public function documentType(){
		return $this->belongsTo('Masterdata','document_id');
	}

}
