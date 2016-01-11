<?php
namespace Admin;

use View,Input,Redirect,NewCustomer,Employee,Auth,Masterdata;
use FileUpload,DocumentMapping,File,Image,Session;

class DocumentsController extends \BaseController {

	public function create($id){
		$data['customer'] = NewCustomer::find($id);
		$document = DocumentMapping::where('owner_id','=',$id)->get()->first();
	    if(count($document)!=0)	{
	    $data['photo_view'] = FileUpload::where('id','=',$document->file_id)->where('document_id','=','13')->get()->first();
		$application=str_replace('/uploads/','/applications/',$data['photo_view']->file_name);
		$data['app_view']='/uploads'.$application;	
		} else {
		    $data['photo_view'] = NULL;	
		     $data['app_view'] = NULL;	
		}
		$data['document_types'] = Masterdata::where('type','=','document_type')->get();
        $data['new_customers'] = NewCustomer::all();
		return View::make('admin.documents.create',$data);
	}

	
	public function store() {
		$file = Input::file('document');
		$owner_id=Input::get('owner_id');
		if(strpos($file->getMimeType(), "image") !== false ) {
		
			$destinationPath = public_path(). '/uploads/';
			$filename=$file->getClientOriginalName();

			$renamed_filename = str_random(6) . '_' . $filename;


			if (File::exists(public_path(). '/uploads/' . $renamed_filename)) {
				$renamed_filename = (string)rand(1, 99) . "_" . $renamed_filename;
			}

			//var_dump(Input::file('document')->move($destinationPath, $renamed_filename));die;
			Image::make($file->getRealPath())->resize('200','200')->save(public_path(). '/uploads/'.$renamed_filename);
			Image::make($file->getRealPath())->resize('200','200')->save(public_path(). '/uploads/applications/'.$renamed_filename);
            
			$file_upload = new FileUpload();
			$file_upload->file_name = '/uploads/'. $renamed_filename; 
			$file_upload->document_id = Input::get('document_type_id');
            $file_upload->save();
         

			DocumentMapping::map($file_upload->id,Input::all());
			Session::put('image','/uploads/' . $renamed_filename);

			return Redirect::back()->with('success', 'Uploaded Successfully');
		}
		return Redirect::back()->with('failure', 'Only Image files allowed');
	}

	public function delete($id) {
		$resource = Input::get('resource');
		if( is_null($resource) ) {
			$document = FileUpload::find($id);
			if(!is_null($document)){
				$document->delete();
				return Redirect::back()->with('success','Deleted Successfully');
			}
			return Redirect::back()->with('failure','Invalid Request');
		}
		$method_name = $resource . "Delete";
		if (method_exists($this, $method_name)) {
			return $this->$method_name($id);
		}
		return Redirect::back()->with('failure','Invalid Request');
	}

	//////////////////////////////////////////////////////////////////////////////
	////////////////////// Resource Methods //////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	private function document_mappingDelete($id){
		$dm = DocumentMapping::find($id);
		if(!is_null($dm)){
			$dm->delete();
			return Redirect::back()->with('success','Deleted Successfully');	
		}
		return Redirect::back()->with('failure','Invalid Request');
	}


	public function cropImage(){
		$image=Input::get('image');
		 //var_dump($image);die; 
		$int=public_path().$image;
        $int_image=Image::make($int);
		$int_image->crop(intval(Input::get('w')),intval(Input::get('h')),intval(Input::get('x')),intval(Input::get('y')));
		$int_image->fit(200);
		$int_image->save($int);

	return Redirect::back()->with('success','Croped Successfully');	
	}
}

