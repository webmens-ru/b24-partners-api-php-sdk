<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\Requests;

use Webmens\B24PartnersApi\DTO\Payment;
use Webmens\B24PartnersApi\DTO\Request;
use Webmens\B24PartnersApi\DTO\RequestList;
use Webmens\B24PartnersApi\HttpClient;

class RequestsClient
{
    public function __construct(private HttpClient $http) {}

    /**
     * List requests with optional filters.
     */
    public function list(
        ?string $status = null,
        ?string $orderId = null,
        int $page = 1,
        int $limit = 50,
        ?string $sortField = null,
        ?string $sortOrder = null,
    ): RequestList {
        $params = [
            'page' => $page,
            'limit' => $limit,
        ];

        if ($status !== null) {
            $params['status'] = $status;
        }
        if ($orderId !== null) {
            $params['orderId'] = $orderId;
        }
        if ($sortField !== null) {
            $params['sortField'] = $sortField;
        }
        if ($sortOrder !== null) {
            $params['sortOrder'] = $sortOrder;
        }

        $result = $this->http->post('sb.api.v1.partner.request.list', $params);

        return new RequestList($result['result'] ?? $result);
    }

    /**
     * Get single request by requestId or orderId.
     */
    public function get(?int $requestId = null, ?int $orderId = null): Request
    {
        $params = $this->buildIdParams($requestId, $orderId);

        $result = $this->http->post('sb.api.v1.partner.request.get', $params);

        return new Request($result['result'] ?? $result);
    }

    /**
     * Get payment data for request.
     */
    public function getPayment(?int $requestId = null, ?int $orderId = null): Payment
    {
        $params = $this->buildIdParams($requestId, $orderId);

        $result = $this->http->post('sb.api.v1.partner.request.payment.get', $params);

        return new Payment($result['result'] ?? $result);
    }

    /**
     * Create new request (write method).
     *
     * @param RequestItem[] $items
     */
    public function create(
        string $email,
        array $items,
        ?string $portalUrl = null,
        ?string $boxLicenseKey = null,
        ?string $idempotencyKey = null,
        ?string $clientInn = null,
        ?string $partnerInn = null,
        ?string $clientKpp = null,
        ?string $clientKppOriginal = null,
        ?string $clientAddressLegal = null,
        ?string $clientAddressPost = null,
    ): Request {
        $fields = [
            'email' => $email,
            'items' => array_map(static fn(RequestItem $item) => $item->toArray(), $items),
        ];

        if ($portalUrl !== null) {
            $fields['portalUrl'] = $portalUrl;
        }
        if ($boxLicenseKey !== null) {
            $fields['boxLicenseKey'] = $boxLicenseKey;
        }
        if ($clientInn !== null) {
            $fields['clientInn'] = $clientInn;
        }
        if ($partnerInn !== null) {
            $fields['partnerInn'] = $partnerInn;
        }
        if ($clientKpp !== null) {
            $fields['clientKpp'] = $clientKpp;
        }
        if ($clientKppOriginal !== null) {
            $fields['clientKppOriginal'] = $clientKppOriginal;
        }
        if ($clientAddressLegal !== null) {
            $fields['clientAddressLegal'] = $clientAddressLegal;
        }
        if ($clientAddressPost !== null) {
            $fields['clientAddressPost'] = $clientAddressPost;
        }

        $headers = [
            'X-Request-Id' => $idempotencyKey ?? $this->generateUuid(),
            'Idempotency-Key' => $idempotencyKey ?? $this->generateUuid(),
        ];

        $result = $this->http->post(
            'sb.api.v1.partner.request.create',
            body: ['fields' => $fields],
            headers: $headers,
        );

        return new Request($result['result']['request'] ?? $result['result'] ?? $result);
    }

    /**
     * Build params with exactly one of requestId or orderId.
     *
     * @throws \InvalidArgumentException
     */
    private function buildIdParams(?int $requestId, ?int $orderId): array
    {
        if ($requestId !== null && $orderId !== null) {
            throw new \InvalidArgumentException('Pass exactly one of requestId or orderId');
        }

        if ($requestId === null && $orderId === null) {
            throw new \InvalidArgumentException('Pass either requestId or orderId');
        }

        return $requestId !== null
            ? ['requestId' => $requestId]
            : ['orderId' => $orderId];
    }

    private function generateUuid(): string
    {
        $data = random_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // version 4
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // variant 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
