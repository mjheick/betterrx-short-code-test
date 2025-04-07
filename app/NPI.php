<?php
namespace App;
use Illuminate\Http\Response;

Class NPI
{
    private static $fields = [
        'number' => '',
        'enumeration_type' => '',
        'taxonomy_description' => '',
        'name_purpose' => '',
        'first_name' => '',
        'use_first_name_alias' => '',
        'last_name' => '',
        'organization_name' => '',
        'address_purpose' => '',
        'city' => '',
        'state' => '',
        'postal_code' => '',
        'country_code' => '',
        'limit' => '',
        'skip' => '',
        'pretty' => '',
        'version' => '2.1'
    ];

    public static function query($by, $query, $page): Response
    {
        $endpoint = env('ENDPOINT_BASE');
        $results = env('ENDPOINT_RESULTS');

        $params = self::$fields; 
        $params['limit'] = $results;
        $params[$by] = $query;
        $curl = new \GuzzleHttp\Client();
        $response = $curl->request('GET', $endpoint, ['query' => $params]);
        $statusCode = $response->getStatusCode();
        $content = $response->getBody();
        if ($statusCode != 200) {
            return Response(json_encode(['error' => 'backend query failed for some reason']), 200);
        } else {
            return Response($content, 200);
        }
    }
}