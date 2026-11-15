<?php

namespace Keepcloud\Laravel\Freshdesk;

use Freshdesk\Api as Freshdesk;
use Freshdesk\Resources\Agent;
use Freshdesk\Resources\Article;
use Freshdesk\Resources\BusinessHour;
use Freshdesk\Resources\Comment;
use Freshdesk\Resources\Company;
use Freshdesk\Resources\Contact;
use Freshdesk\Resources\Conversation;
use Freshdesk\Resources\Discussion;
use Freshdesk\Resources\EmailConfig;
use Freshdesk\Resources\Folder;
use Freshdesk\Resources\Forum;
use Freshdesk\Resources\Group;
use Freshdesk\Resources\Product;
use Freshdesk\Resources\SLAPolicy;
use Freshdesk\Resources\Solution;
use Freshdesk\Resources\Ticket;
use Freshdesk\Resources\TimeEntry;
use Freshdesk\Resources\Topic;

class Api
{
    private Freshdesk $api;

    /**
     * @param  array<string, mixed>  $clientOptions  Extra Guzzle options (timeout, handler...). Auth cannot be overridden.
     *
     * @throws \Freshdesk\Exceptions\InvalidConfigurationException
     */
    public function __construct(string $key, string $domain, array $clientOptions = [])
    {
        $this->api = new Freshdesk($key, $domain, $clientOptions);
    }

    public function agents(): Agent
    {
        return $this->api->agents;
    }

    public function companies(): Company
    {
        return $this->api->companies;
    }

    public function contacts(): Contact
    {
        return $this->api->contacts;
    }

    public function groups(): Group
    {
        return $this->api->groups;
    }

    public function tickets(): Ticket
    {
        return $this->api->tickets;
    }

    public function timeEntries(): TimeEntry
    {
        return $this->api->timeEntries;
    }

    public function conversations(): Conversation
    {
        return $this->api->conversations;
    }

    /**
     * Forum categories (/discussions/categories).
     */
    public function discussions(): Discussion
    {
        return $this->api->discussions;
    }

    /**
     * @deprecated Use discussions(). Kept for backwards compatibility.
     */
    public function categories(): Discussion
    {
        return $this->discussions();
    }

    public function forums(): Forum
    {
        return $this->api->forums;
    }

    public function topics(): Topic
    {
        return $this->api->topics;
    }

    public function comments(): Comment
    {
        return $this->api->comments;
    }

    /**
     * Solution (knowledge base) categories.
     */
    public function solutions(): Solution
    {
        return $this->api->solutions;
    }

    public function folders(): Folder
    {
        return $this->api->folders;
    }

    public function articles(): Article
    {
        return $this->api->articles;
    }

    public function emailConfigs(): EmailConfig
    {
        return $this->api->emailConfigs;
    }

    public function products(): Product
    {
        return $this->api->products;
    }

    public function businessHours(): BusinessHour
    {
        return $this->api->businessHours;
    }

    public function slaPolicies(): SLAPolicy
    {
        return $this->api->slaPolicies;
    }

    /**
     * Headers of the most recent response (e.g. X-RateLimit-Remaining, Link).
     *
     * @return array<string, string[]>
     */
    public function lastResponseHeaders(): array
    {
        return $this->api->getLastResponseHeaders();
    }

    /**
     * The underlying SDK client.
     */
    public function sdk(): Freshdesk
    {
        return $this->api;
    }
}
