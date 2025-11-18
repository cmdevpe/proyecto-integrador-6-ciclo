<?php

namespace App\Support;

use Carbon\Carbon;
use Detection\MobileDetect;
use Illuminate\Contracts\Support\Arrayable;

class SessionDetails implements Arrayable
{
    public readonly string $id;
    public readonly string $ipAddress;
    public readonly bool $isCurrentDevice;
    public readonly string $lastActive;
    public readonly string $browserName;
    public readonly string $platformName;
    public readonly string $deviceName;

    public function __construct(object $session)
    {
        $detector = new MobileDetect();
        $detector->setUserAgent($session->user_agent ?? '');

        $this->id = $session->id;
        $this->ipAddress = $session->ip_address;
        $this->isCurrentDevice = $session->id === request()->session()->getId();
        $this->lastActive = Carbon::createFromTimestamp($session->last_activity)->diffForHumans();

        $this->browserName = $this->findMatch($detector, self::$browserRules) ?: 'Desconocido';
        $this->platformName = $this->findMatch($detector, self::$platformRules) ?: 'Desconocido';
        $this->deviceName = $this->determineDeviceName($detector);
    }

    private static array $platformRules = [
        'Windows' => 'Windows',
        'OS X' => 'OS X',
        'Ubuntu' => 'Ubuntu',
        'Linux' => 'Linux',
        'iPhone' => 'iPhone',
        'Android' => 'Android',
        'Macintosh' => 'Macintosh',
    ];
    private static array $browserRules = [
        'Edge' => 'Edge|Edg',
        'Opera' => 'Opera|OPR',
        'Firefox' => 'Firefox',
        'Chrome' => 'Chrome',
        'Safari' => 'Safari(?!.*(Chrome|Edge|Opera))',
    ];

    private function findMatch(MobileDetect $detector, array $rules): string|false
    {
        $userAgent = $detector->getUserAgent();

        foreach ($rules as $key => $regex) {
            if ($detector->match($regex, $userAgent)) {
                return $key;
            }
        }
        return false;
    }

    private function determineDeviceName(MobileDetect $detector): string
    {
        if ($detector->isTablet()) {
            return 'Tablet';
        }
        if ($detector->isMobile()) {
            return 'Mobile';
        }
        return 'Desktop';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'ip_address' => $this->ipAddress,
            'is_current_device' => $this->isCurrentDevice,
            'last_active' => $this->lastActive,
            'browser_name' => $this->browserName,
            'platform_name' => $this->platformName,
            'device_name' => $this->deviceName,
        ];
    }
}
