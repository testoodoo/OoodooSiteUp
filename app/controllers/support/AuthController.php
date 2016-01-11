<?php
namespace Support;
use View, BaseController;
class AuthController extends BaseController {
	public function index(){
	return View::make('support.auth.index');

	}

}