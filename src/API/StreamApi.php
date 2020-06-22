<?php
declare(strict_types=1);

namespace AR\LiveSdk\API;

use AR\LiveSdk\Exceptions\ApiFailedException;
use AR\LiveSdk\Utils\Response;

class StreamApi extends API
{
    /**
     * @see https://www.arvancloud.com/docs/api/live/2.0#tag/Stream/paths/~1streams/get
     *
     * @param string|null $filter
     * @param int|null $perPage
     * @return Response
     * @throws ApiFailedException
     */
    public function getAll(string $filter = null, int $perPage = null) : Response
    {
        $response = $this->client
            ->request('get', 'streams', [
                'query'=> [
                    'filter'=> $filter,
                    'per_page'=> $perPage
                ]
            ]);
        return Response::create($response);
    }

    /**
     * @see https://www.arvancloud.com/docs/api/live/2.0#tag/Stream/paths/~1streams/post
     *
     * @param array $params
     * @return Response
     * @throws ApiFailedException
     */
    public function create(array $params) : Response
    {
        $response = $this->client
            ->request('post', 'streams', [
                'json'=> $params
            ]);
        return Response::create($response, 201);
    }

    /**
     * @see https://www.arvancloud.com/docs/api/live/2.0#tag/Stream/paths/~1streams~1{stream}/get
     *
     * @param string $id
     * @return Response
     * @throws ApiFailedException
     */
    public function get(string $id) : Response
    {
        $response = $this->client
            ->request('get', "streams/{$id}");
        return Response::create($response);
    }

    /**
     * @see https://www.arvancloud.com/docs/api/live/2.0#tag/Stream/paths/~1streams~1{stream}/delete
     *
     * @param string $id
     * @return Response
     * @throws ApiFailedException
     */
    public function delete(string $id) : Response
    {
        $response = $this->client
            ->request('delete', "streams/{$id}");
        return Response::create($response);
    }

    /**
     * @see https://www.arvancloud.com/docs/api/live/2.0#tag/Stream/paths/~1streams~1{stream}/patch
     *
     * @param string $id
     * @param array $params
     * @return Response
     * @throws ApiFailedException
     */
    public function update(string $id, array $params) : Response
    {
        $response = $this->client
            ->request('patch', "streams/{$id}", [
                'json'=> $params
            ]);
        return Response::create($response);
    }
}
