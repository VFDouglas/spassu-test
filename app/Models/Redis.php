<?php

namespace App\Models;

use Exception;
use Predis\Client;

class Redis
{
    public Client $client;
    public const REDIS_CONTAINER = 'redis';

    public function __construct()
    {
        $this->client = new Client([
            'scheme' => 'tcp',
            'host'   => self::REDIS_CONTAINER,
            'port'   => 6379,
        ]);
    }

    public function excluirCache(array $chaves): bool
    {
        try {
            foreach ($this->client->keys('*') as $item) {
                foreach ($chaves as $chave) {
                    if (!$chave || strstr(strtoupper($item), strtoupper($chave))) {
                        $this->client->del($item);
                    }
                }
            }
            return true;
        } catch (Exception) {
            return false;
        }
    }
}
