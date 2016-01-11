<?php
namespace User;
use View, BaseController;
class FaqController extends BaseController {
	public function index(){

	return View::make('user.faq.index');

	}

}