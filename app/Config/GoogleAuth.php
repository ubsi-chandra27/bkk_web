<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class GoogleAuth extends BaseConfig
{
    public bool $enabled = false;
    public string $clientId = '';
    public string $clientSecret = '';
    public string $redirectUri = '';
    public string $hostedDomain = '';

    public function __construct()
    {
        parent::__construct();

        $this->enabled = (bool) env('google.auth.enabled', false);
        $this->clientId = trim((string) env('google.auth.clientId', ''));
        $this->clientSecret = trim((string) env('google.auth.clientSecret', ''));
        $this->redirectUri = trim((string) env('google.auth.redirectUri', ''));
        $this->hostedDomain = strtolower(trim((string) env('google.auth.hostedDomain', '')));
    }

    public function isConfigured(): bool
    {
        return $this->enabled && $this->clientId !== '' && $this->clientSecret !== '';
    }

    public function getRedirectUri(): string
    {
        return $this->redirectUri !== '' ? $this->redirectUri : site_url('auth/google/callback');
    }
}
