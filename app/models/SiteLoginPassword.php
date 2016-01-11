<?php

class SiteLoginPassword extends Eloquent {

	protected $table = 'site_login_passwords';

	protected $fillable = ["account_id","password"];


}