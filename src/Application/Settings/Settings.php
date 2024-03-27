<?php

declare(strict_types=1);

namespace App\Application\Settings;

use App\Application\Settings\SettingsInterface;

class Settings implements SettingsInterface
{
private array $settings;

public function __construct(array $settings)
{
$this->settings = $settings;
}

/**
* Get the value of a specific setting by key.
*
* @param string $key The key of the setting to retrieve
* @return mixed|null The value of the setting, or null if the key doesn't exist
*/
public function get(string $key = '')
{
if (empty($key)) {
return $this->settings;
}
return $this->settings[$key] ?? null;
}
}
