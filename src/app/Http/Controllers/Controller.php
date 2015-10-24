<?php
namespace TmlpStats\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {

    use DispatchesCommands, ValidatesRequests;

    const CACHE_TTL = 60;
    const STATS_REPORT_CACHE_TTL = 7 * 24 * 60;
}
