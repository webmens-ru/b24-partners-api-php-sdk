# B24 Partners API PHP SDK

PHP SDK for Bitrix24 Partner REST API (`sb.api.v1.partner.*`).

## Installation

```bash
composer require webmens-ru/b24-partners-api-php-sdk
```

## Quick Start

```php
use Webmens\B24PartnersApi\PartnerApi;

$api = new PartnerApi(
    accessToken: 'your-access-token',
    refreshToken: 'your-refresh-token',
    clientId: 'your-client-id',
    clientSecret: 'your-client-secret',
);

// Get profile
$profile = $api->profile()->get();
echo $profile->name;

// List cloud clients
$clients = $api->clients()->list(type: 'cloud', limit: 50);
foreach ($clients->items as $client) {
    echo $client->portalUrl;
}

// Create order
use Webmens\B24PartnersApi\Requests\RequestItem;

$request = $api->requests()->create(
    email: 'client@example.com',
    portalUrl: 'demo.bitrix24.ru',
    items: [new RequestItem(productId: 16204918, quantity: 1)],
);
echo $request->shortUrl; // Payment link

// Netflow
$attention = $api->netflow()->attentionList(withForecast: true);
```

## Error Handling

```php
use Webmens\B24PartnersApi\Exceptions\ValidationException;
use Webmens\B24PartnersApi\Exceptions\UnauthorizedException;

try {
    $request = $api->requests()->create(...);
} catch (ValidationException $e) {
    foreach ($e->errors as $error) {
        echo "{$error['field']}: {$error['reason']}";
    }
} catch (UnauthorizedException $e) {
    // Refresh failed — need to reissue token
}
```

## Available Methods

### Profile
- `profile()->get()` — Get partner profile

### Clients
- `clients()->list(type, page, limit)` — List clients (cloud/box)
- `clients()->get(type, cloudId, clientId)` — Get single client

### Requests
- `requests()->list(status, orderId, page, limit, sortField, sortOrder)` — List requests
- `requests()->get(requestId, orderId)` — Get single request
- `requests()->getPayment(requestId, orderId)` — Get payment data
- `requests()->create(email, items, portalUrl, ...)` — Create request

### Netflow
- `netflow()->summary(dateFrom, dateTo)` — Get summary
- `netflow()->events(page, limit, ...)` — List events
- `netflow()->base(date)` — Get base snapshot
- `netflow()->baseList(date, page, limit, ...)` — List base
- `netflow()->clientList(page, limit, ...)` — List clients
- `netflow()->attentionList(dateTo, page, limit, ...)` — List attention clients
- `netflow()->dictionary(lang)` — Get code dictionary

## Requirements

- PHP >= 8.1
- Guzzle 7
