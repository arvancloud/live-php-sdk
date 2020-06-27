# Live PHP SDK 

### This package has written in pure php which can be implemented in any PHP framework.

- The API document is also availavle [API Doc](https://napi.arvancloud.com/docs/vod/2.0#/)

#### Implementation:

In order to use th SDK, ```Client``` class should be initiated as below.
```PHP
$config = [
    'api_key'=> 'xyz', 
    'lang' => 'en',
    'api_url'=> 'https://www.arvancloud.com/fa/docs/api'
];

$liveApi = new Client($config);

$userDomain = $liveApi->DomainApi->getUserDomain(); 
```

### Available Methods:
- DomainApi
  * getUserDomain()
  * setSubdomainForLIVEService()
  
- ReportApi
  * getDomainStatisticsReport()
  * getUserAgent()
  * getUserVisitors()
  
- StreamApi
  * getAll()
  * create()
  * get()
  * delete()
  * update()
