<?php

namespace Mayahkw\CMS\Facades;

use Illuminate\Support\Facades\Facade;

class MyCms extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'mycms';
	}
}
