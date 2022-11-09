<?php

namespace Mayahkw\CMS\Facade;

use Illuminate\Support\Facades\Facade;

class CmsContent extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'cmscontent';
	}
}
