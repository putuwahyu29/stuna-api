<?php

namespace Config;

use App\Filters\CorsFilter;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\DebugToolbar;
use App\Filters\AuthFilter;

class Filters extends BaseConfig
{
	// Makes reading things below nicer,
	// and simpler to change out script that's used.
	public $aliases = [
		'csrf'     => CSRF::class,
		'toolbar'  => DebugToolbar::class,
		'honeypot' => Honeypot::class,
		'auth' => JWTAuthenticationFilter::class,
		'cors' => CorsFilter::class,
		'auth' => AuthFilter::class,
	];

	// Always applied before every request
	public $globals = [
		'before' => [
			'cors'
			//'honeypot'
			// 'csrf',
		],
		'after'  => [
			'toolbar',
			//'honeypot'
		],
	];

	// Works on all of a particular HTTP method
	// (GET, POST, etc) as BEFORE filters only
	//     like: 'post' => ['CSRF', 'throttle'],
	public $methods = [];

	// List filter aliases and any before/after uri patterns
	// that they should run on, like:
	//    'isLoggedIn' => ['before' => ['account/*', 'profiles/*']],
	public $filters = [
		'auth' => [
			'before' => [
				'client/*',
				'client'
			],
		]
	];
}
