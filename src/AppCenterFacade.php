<?php
namespace Presi\AppCenter;

use Illuminate\Support\Facades\Facade;

class AppCenterFacade extends Facade {

    protected static function getFacadeAccessor() {
        return 'appcenter';
    }
}