<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\Profile;

use Webmens\B24PartnersApi\DTO\Profile;
use Webmens\B24PartnersApi\HttpClient;

class ProfileClient
{
    public function __construct(private HttpClient $http) {}

    public function get(): Profile
    {
        $result = $this->http->post('sb.api.v1.partner.profile.get');

        return new Profile($result['result'] ?? $result);
    }
}
