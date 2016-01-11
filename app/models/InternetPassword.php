<?php

class InternetPassword extends Eloquent {

	protected $table = 'internet_passwords';

	protected $fillable = ["account_id","password"];

}