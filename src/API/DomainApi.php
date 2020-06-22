<?php
declare(strict_types=1);

namespace AR\LiveSdk\API;

use AR\LiveSdk\Exceptions\ApiFailedException;
use AR\LiveSdk\Utils\Response;

class DomainApi extends API
{
    /**
     * @see https://www.arvancloud.com/docs/api/live/2.0#tag/Domain/paths/~1domain/get
     *
     * @return Response
     * @throws ApiFailedException
     */
    public function getUserDomain(): Response
    {
        $response = $this->client
            ->request('get', 'domain');
        return Response::create($response);
    }

    /**
     * @see https://www.arvancloud.com/docs/api/live/2.0#tag/Domain/paths/~1domain/post
     *
     * @param string $subdomain
     * @return Response
     * @throws ApiFailedException
     */
    public function setSubdomainForLIVEService(string $subdomain): Response
    {
        $response = $this->client
            ->request('post', 'domain', [
                'json' => [
                    'subdomain' => $subdomain
                ]
            ]);
        return Response::create($response, 201);
    }
}
