<?php


namespace AR\LiveSdk\API;

use AR\LiveSdk\Exceptions\ApiFailedException;
use AR\LiveSdk\Utils\Response;

class ReportApi extends API
{

    /**
     * @see https://www.arvancloud.com/docs/api/live/2.0#tag/General-Report/paths/~1report~1statistics/get
     *
     * @return Response
     * @throws ApiFailedException
     */
    public function getDomainStatisticsReport() : Response
    {
        $response = $this->client
            ->request('get', 'report/statistics');
        return Response::create($response);
    }

    /**
     * @see https://www.arvancloud.com/docs/api/live/2.0#tag/General-Report/paths/~1report~1traffics/get
     *
     * @param string $period
     * @return Response
     * @throws ApiFailedException
     */
    public function getDomainTraffic(string $period) : Response
    {
        $response = $this->client
            ->request('get', 'report/traffics', [
                'query'=> [
                    'period'=> $period
                ]
            ]);
        return Response::create($response);
    }

    /**
     * @see https://www.arvancloud.com/docs/api/live/2.0#tag/General-Report/paths/~1report~1user-agent/get
     *
     * @param string $period
     * @return Response
     * @throws ApiFailedException
     */
    public function getUserAgent(string $period) : Response
    {
        $response = $this->client
            ->request('get', 'report/user-agent', [
                'query'=> [
                    'period'=> $period
                ]
            ]);
        return Response::create($response);
    }

    /**
     * @see https://www.arvancloud.com/docs/api/live/2.0#tag/General-Report/paths/~1report~1visitors/get
     *
     * @param string $period
     * @return Response
     * @throws ApiFailedException
     */
    public function getUserVisitors(string $period) : Response
    {
        $response = $this->client
            ->request('get', 'report/visitors', [
                'query'=> [
                    'period'=> $period
                ]
            ]);
        return Response::create($response);
    }
}
