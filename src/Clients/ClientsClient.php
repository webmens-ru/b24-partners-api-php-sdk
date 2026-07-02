<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\Clients;

use Webmens\B24PartnersApi\DTO\Client;
use Webmens\B24PartnersApi\DTO\ClientList;
use Webmens\B24PartnersApi\HttpClient;

class ClientsClient
{
    public function __construct(private HttpClient $http) {}

    /**
     * Get list of clients.
     *
     * @param string $type 'cloud' or 'box'
     */
    public function list(string $type, int $page = 1, int $limit = 50): ClientList
    {
        $result = $this->http->post('sb.api.v1.partner.client.list', [
            'type' => $type,
            'page' => $page,
            'limit' => $limit,
        ]);

        return new ClientList($result['result'] ?? $result);
    }

    /**
     * Get single client.
     *
     * For type=cloud pass $cloudId.
     * For type=box pass $clientId.
     */
    public function get(string $type, ?int $cloudId = null, ?int $clientId = null): Client
    {
        $params = ['type' => $type];

        if ($type === 'cloud' && $cloudId !== null) {
            $params['cloudId'] = $cloudId;
        } elseif ($type === 'box' && $clientId !== null) {
            $params['clientId'] = $clientId;
        }

        $result = $this->http->post('sb.api.v1.partner.client.get', $params);

        return new Client($result['result'] ?? $result);
    }
}
