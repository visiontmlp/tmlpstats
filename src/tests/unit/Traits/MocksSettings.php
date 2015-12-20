<?php
namespace TmlpStats\Tests\Traits;

use stdClass;
use TmlpStats\ModelCache;

trait MocksSettings
{
    /**
     * Prepopulates the cache to force a set value
     *
     * @param     $name
     * @param     $value
     * @param int $centerId
     */
    public function setSetting($name, $value, $centerId = 0)
    {
        $setting = new stdClass;
        $setting->name = $name;
        $setting->value = $value;
        ModelCache::create()->set($name, $centerId, $setting);
    }

    /**
     * Forget a cached setting
     *
     * @param     $name
     * @param int $centerId
     */
    public function unsetSetting($name, $centerId = 0)
    {
        ModelCache::create()->forget($name, $centerId);
    }
}