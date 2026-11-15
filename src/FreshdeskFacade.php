<?php

namespace Keepcloud\Laravel\Freshdesk;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Freshdesk\Resources\Agent agents()
 * @method static \Freshdesk\Resources\Company companies()
 * @method static \Freshdesk\Resources\Contact contacts()
 * @method static \Freshdesk\Resources\Group groups()
 * @method static \Freshdesk\Resources\Ticket tickets()
 * @method static \Freshdesk\Resources\TimeEntry timeEntries()
 * @method static \Freshdesk\Resources\Conversation conversations()
 * @method static \Freshdesk\Resources\Discussion discussions()
 * @method static \Freshdesk\Resources\Discussion categories()
 * @method static \Freshdesk\Resources\Forum forums()
 * @method static \Freshdesk\Resources\Topic topics()
 * @method static \Freshdesk\Resources\Comment comments()
 * @method static \Freshdesk\Resources\Solution solutions()
 * @method static \Freshdesk\Resources\Folder folders()
 * @method static \Freshdesk\Resources\Article articles()
 * @method static \Freshdesk\Resources\EmailConfig emailConfigs()
 * @method static \Freshdesk\Resources\Product products()
 * @method static \Freshdesk\Resources\BusinessHour businessHours()
 * @method static \Freshdesk\Resources\SLAPolicy slaPolicies()
 * @method static array lastResponseHeaders()
 * @method static \Freshdesk\Api sdk()
 *
 * @see \Keepcloud\Laravel\Freshdesk\Api
 */
class FreshdeskFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'freshdesk';
    }
}
