<?php

namespace Kunlyly\PlasGate;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kunlyly\PlasGate\PlasGate
 */
class PlasGateFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'lyly-cg-otp';
    }
}
