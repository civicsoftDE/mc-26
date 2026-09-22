<?php

namespace App\Service;

use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MastodonService
{
    private const string ACCOUNT_URL = 'https://mastodon.social/api/v1/accounts/lookup';
    private const string STATUSES_URL = 'https://mastodon.social/api/v1/accounts/%s/statuses';

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly CacheInterface $cache
    ) {}

    /**
     * @throws InvalidArgumentException
     */
    public function getAccountPosts(string $username, int $limit = 5, string $cacheSlot = "mastodon_posts_"): array
    {
        //$this->cache->delete('mastodon_posts_' . md5($username));
        return $this->cache->get(
            $cacheSlot . md5($username),
            function (ItemInterface $item) use ($username, $limit) {
                $item->expiresAfter(300);
                // 1. Account-ID holen
                $accountResponse = $this->client->request('GET', self::ACCOUNT_URL, [
                    'query' => ['acct' => $username]
                ]);
                $account = $accountResponse->toArray();

                // 2. Posts holen
                $statusesResponse = $this->client->request('GET',
                    sprintf(self::STATUSES_URL, $account['id']),
                    [
                        'query' => [
                            'limit' => $limit,
                            'exclude_replies' => true,      // Keine Antworten
                            'exclude_reblogs' => true       // Keine Boosts
                        ]
                    ]
                );

                return $statusesResponse->toArray();
            },
            1.0
        );
    }
}
