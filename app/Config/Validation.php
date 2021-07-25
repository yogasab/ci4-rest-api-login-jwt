<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
	public $blogRules = [
		'post_title' => 'required|min_length[6]',
		'post_description' => 'required',
		'post_featured_image' => 'uploaded[post_featured_image]|max_size[post_featured_image, 1024]|is_image[post_featured_image]'
	];
	public $userRules = [
		'firstname' => 'required|min_length[3]|max_length[20]',
		'lastname' => 'required|min_length[3]|max_length[20]',
		'password' => 'required|min_length[5]',
		'email' => 'required|valid_email|is_unique[users.email]',
		'password_confirm' => 'matches[password]'
	];
}
