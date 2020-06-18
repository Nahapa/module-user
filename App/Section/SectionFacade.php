<?php

namespace Modules\User\App\Section;


use Illuminate\Support\Facades\Facade;

class SectionFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SectionManager::class;
    }
}
