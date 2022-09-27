<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/* Alowing Eloquent to insert data into our database */
	protected $fillable = array('name', 'username', 'password', 'verification_status');

        public $timestamps = false;

	use UserTrait, RemindableTrait;

	protected $table = 'users';
	protected $primaryKey = 'id';

	protected $hidden = array('password');

	public function getAuthPassword() {
	    return $this->password;
	}

}
