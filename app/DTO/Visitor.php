<?php

namespace App\DTO;

class Visitor
{
    public function __construct(
        private string $ipAddress,
        private string $userAgent,
        private string $pageUrl
    ) {
        //
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    public function getPageUrl(): string
    {
        return $this->pageUrl;
    }

    public static function createFromGlobals(): self
    {
        return new self(
            (string)$_SERVER['REMOTE_ADDR'],
            (string)$_SERVER['HTTP_USER_AGENT'],
            (string)$_SERVER['HTTP_REFERER']
        );
    }
}
