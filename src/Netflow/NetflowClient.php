<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\Netflow;

use Webmens\B24PartnersApi\DTO\NetflowAttentionList;
use Webmens\B24PartnersApi\DTO\NetflowBase;
use Webmens\B24PartnersApi\DTO\NetflowBaseList;
use Webmens\B24PartnersApi\DTO\NetflowClientList;
use Webmens\B24PartnersApi\DTO\NetflowDictionary;
use Webmens\B24PartnersApi\DTO\NetflowEventList;
use Webmens\B24PartnersApi\DTO\NetflowSummary;
use Webmens\B24PartnersApi\HttpClient;

class NetflowClient
{
    public function __construct(private HttpClient $http) {}

    /**
     * Get netflow summary.
     */
    public function summary(?string $dateFrom = null, ?string $dateTo = null): NetflowSummary
    {
        $params = $this->buildDateParams($dateFrom, $dateTo);

        $result = $this->http->post('sb.api.v1.partner.netflow.summary.get', $params);

        return new NetflowSummary($result['result'] ?? $result);
    }

    /**
     * List netflow events.
     */
    public function events(
        int $page = 1,
        int $limit = 50,
        ?string $dateFrom = null,
        ?string $dateTo = null,
        ?int $clientId = null,
        ?string $clientType = null,
        ?array $eventTypes = null,
        ?array $licenses = null,
        ?string $orderBy = null,
        ?bool $orderAsc = null,
    ): NetflowEventList {
        $params = array_merge(
            $this->buildDateParams($dateFrom, $dateTo),
            $this->buildListParams($page, $limit),
        );

        if ($clientId !== null) {
            $params['clientId'] = $clientId;
        }
        if ($clientType !== null) {
            $params['clientType'] = $clientType;
        }
        if ($eventTypes !== null) {
            $params['eventType'] = $eventTypes;
        }
        if ($licenses !== null) {
            $params['license'] = $licenses;
        }
        if ($orderBy !== null) {
            $params['orderBy'] = $orderBy;
        }
        if ($orderAsc !== null) {
            $params['orderAsc'] = $orderAsc ? 'true' : 'false';
        }

        $result = $this->http->post('sb.api.v1.partner.netflow.event.list', $params);

        return new NetflowEventList($result['result'] ?? $result);
    }

    /**
     * Get base snapshot on date.
     */
    public function base(?string $date = null): NetflowBase
    {
        $params = [];
        if ($date !== null) {
            $params['date'] = $date;
        }

        $result = $this->http->post('sb.api.v1.partner.netflow.base.get', $params);

        return new NetflowBase($result['result'] ?? $result);
    }

    /**
     * List base on date.
     */
    public function baseList(
        ?string $date = null,
        int $page = 1,
        int $limit = 50,
        ?string $clientType = null,
        ?array $licenses = null,
        ?string $orderBy = null,
        ?bool $orderAsc = null,
    ): NetflowBaseList {
        $params = $this->buildListParams($page, $limit);

        if ($date !== null) {
            $params['date'] = $date;
        }
        if ($clientType !== null) {
            $params['clientType'] = $clientType;
        }
        if ($licenses !== null) {
            $params['license'] = $licenses;
        }
        if ($orderBy !== null) {
            $params['orderBy'] = $orderBy;
        }
        if ($orderAsc !== null) {
            $params['orderAsc'] = $orderAsc ? 'true' : 'false';
        }

        $result = $this->http->post('sb.api.v1.partner.netflow.base.list', $params);

        return new NetflowBaseList($result['result'] ?? $result);
    }

    /**
     * List clients in netflow.
     */
    public function clientList(
        int $page = 1,
        int $limit = 50,
        ?string $dateFrom = null,
        ?string $dateTo = null,
        ?int $clientId = null,
        ?string $clientType = null,
        ?bool $impactIncludingPast = null,
        ?string $orderBy = null,
        ?bool $orderAsc = null,
    ): NetflowClientList {
        $params = array_merge(
            $this->buildDateParams($dateFrom, $dateTo),
            $this->buildListParams($page, $limit),
        );

        if ($clientId !== null) {
            $params['clientId'] = $clientId;
        }
        if ($clientType !== null) {
            $params['clientType'] = $clientType;
        }
        if ($impactIncludingPast !== null) {
            $params['impactIncludingPast'] = $impactIncludingPast ? 'true' : 'false';
        }
        if ($orderBy !== null) {
            $params['orderBy'] = $orderBy;
        }
        if ($orderAsc !== null) {
            $params['orderAsc'] = $orderAsc ? 'true' : 'false';
        }

        $result = $this->http->post('sb.api.v1.partner.netflow.client.list', $params);

        return new NetflowClientList($result['result'] ?? $result);
    }

    /**
     * List clients requiring attention.
     */
    public function attentionList(
        ?string $dateTo = null,
        int $page = 1,
        int $limit = 50,
        ?int $clientId = null,
        ?string $clientType = null,
        ?array $riskTypes = null,
        ?array $licenses = null,
        ?bool $withForecast = null,
        ?bool $withOrderRequest = null,
        ?string $orderBy = null,
        ?bool $orderAsc = null,
    ): NetflowAttentionList {
        $params = $this->buildListParams($page, $limit);

        if ($dateTo !== null) {
            $params['dateTo'] = $dateTo;
        }
        if ($clientId !== null) {
            $params['clientId'] = $clientId;
        }
        if ($clientType !== null) {
            $params['clientType'] = $clientType;
        }
        if ($riskTypes !== null) {
            $params['riskType'] = $riskTypes;
        }
        if ($licenses !== null) {
            $params['license'] = $licenses;
        }
        if ($withForecast !== null) {
            $params['withForecast'] = $withForecast ? 'true' : 'false';
        }
        if ($withOrderRequest !== null) {
            $params['withOrderRequest'] = $withOrderRequest ? 'true' : 'false';
        }
        if ($orderBy !== null) {
            $params['orderBy'] = $orderBy;
        }
        if ($orderAsc !== null) {
            $params['orderAsc'] = $orderAsc ? 'true' : 'false';
        }

        $result = $this->http->post('sb.api.v1.partner.netflow.attention.list', $params);

        return new NetflowAttentionList($result['result'] ?? $result);
    }

    /**
     * Get dictionary of netflow codes.
     */
    public function dictionary(?string $lang = null): NetflowDictionary
    {
        $params = [];
        if ($lang !== null) {
            $params['lang'] = $lang;
        }

        $result = $this->http->post('sb.api.v1.partner.netflow.dictionary.get', $params);

        return new NetflowDictionary($result['result'] ?? $result);
    }

    private function buildDateParams(?string $dateFrom, ?string $dateTo): array
    {
        $params = [];
        if ($dateFrom !== null) {
            $params['dateFrom'] = $dateFrom;
        }
        if ($dateTo !== null) {
            $params['dateTo'] = $dateTo;
        }

        return $params;
    }

    private function buildListParams(int $page, int $limit): array
    {
        return [
            'page' => $page,
            'limit' => $limit,
        ];
    }
}
