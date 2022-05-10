<?php

namespace AllegroScraper;

/**
 * Extractor (scraper, crawler, parser) of products from Allegro.
 * It receives the search output of Allegro.pl, as well as detailed information about the products.
 *
 * @see https://www.parser.best/en/allegro-scraper-extractor.php
 * @author Telegram: @JWprogrammer
 * @copyright Telegram: @JWprogrammer
 */

class AllegroScraper
{
    const VERSION = "5.1.1";

    private string $db_host;
    private string $db_name;
    private string $db_user;
    private string $db_password;

    private bool $remote_access_exists;
    private string $remote_uri;
    private string $remote_api_key;

    public function __construct(string $db_host, string $db_name, string $db_user, string $db_password, string $remote_uri = null, string $remote_api_key = null)
    {
        $this->db_host = $db_host;
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_password = $db_password;

        if (!empty($remote_uri) && !empty($remote_api_key)){
            $this->remote_access_exists = true;
            $this->remote_uri = $remote_uri;
            $this->remote_api_key = $remote_api_key;
        }
        else {
            $this->remote_access_exists = false;
        }
    }

    /**
     * Get search results from Allegro
     * @param array $parameters
     * @param bool  $return_as_object
     * @return array|object
     */
    public function search(array $parameters, bool $return_as_object = true)
    {
        if ($this->isOnThisServer()){
            return $this->localRequest(__FUNCTION__, $return_as_object, $parameters['language'] ?? '', $parameters['page'] ?? 1, $parameters['category'] ?? null, $parameters['query'] ?? null, $parameters['sort'] ?? null, $parameters['status'] ?? null, $parameters['make'] ?? null, $parameters['model'] ?? null, $parameters['type'] ?? null, $parameters['price_from'] ?? null, $parameters['price_to'] ?? null, $parameters['filters'] ?? [], $parameters['seller_id'] ?? '', $parameters['seller_name'] ?? '', $parameters['show_lokalnie'] ?? false, $parameters['show_filters'] ?? false, $parameters['filters_excluded'] ?? []);
        }
        else {
            return $this->remoteRequest(__FUNCTION__, $return_as_object, $parameters);
        }
    }

    /**
     * Get detailed product information from Allegro
     * @param array $parameters
     * @param bool  $return_as_object
     * @return array|object
     */
    public function details(array $parameters, bool $return_as_object = true)
    {
        if ($this->isOnThisServer()){
            return $this->localRequest(__FUNCTION__, $return_as_object, $parameters['language'] ?? '', $parameters['product_id'] ?? null);
        }
        else {
            return $this->remoteRequest(__FUNCTION__, $return_as_object, $parameters);
        }
    }

    /**
     * Get a list of categories from Allegro
     * @param array $parameters
     * @param bool  $return_as_object
     * @return array|object
     */
    public function categories(array $parameters, bool $return_as_object = true)
    {
        if ($this->isOnThisServer()){
            return $this->localRequest(__FUNCTION__, $return_as_object, $parameters['language'] ?? '', $parameters['category'] ?? null);
        }
        else {
            return $this->remoteRequest(__FUNCTION__, $return_as_object, $parameters);
        }
    }

    private function remoteRequest(string $method, bool $return_as_object, array $parameters)
    {
        $parameters['api_key'] = $this->remote_api_key;
        $parameters['method'] = $method;
        $parameters['version'] = self::VERSION;
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->remote_uri . '?' . http_build_query($parameters),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_TIMEOUT => 360,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_USERAGENT => $_SERVER['HTTP_HOST'] ?? '',
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
        ]);
        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);
        if ($error){
            throw new \RuntimeException($error);
        }
        $result = json_decode($response, !$return_as_object);
        if ($result == null){
            throw new \RuntimeException('Error while request with response: "'. $response . '"');
        }
        return $result;
    }

    private function localRequest(string $method, bool $return_as_object, $language, ...$parameters)
    {
        $timezone_old = ini_set('date.timezone', 'Europe/Kiev');
        $array = (new \AllegroScraper\AllegroV4($this->db_host, $this->db_name, $this->db_user, $this->db_password, $language))->{$method}(...$parameters);
        ini_set('date.timezone', $timezone_old ?? 'Europe/Kiev');
        if ($return_as_object){
            return self::responseToObject($array);
        }
        else return $array;
    }

    private function isOnThisServer()
    {
        if (class_exists('\AllegroScraper\AllegroV4')) {
            return true;
        }
        elseif ($this->remote_access_exists){
            return false;
        }
        else {
            throw new \RuntimeException('The Allegro scraper is not installed on your server. Please contact: https://t.me/JWprogrammer');
        }
    }

    private static function responseToObject(array &$array)
    {
        $result_obj = new \stdClass();
        $result_arr = [];
        $has_str_keys = false;
        foreach ($array as $k => &$v) {
            if (!$has_str_keys) {
                $has_str_keys = is_string($k);
            }
            $object = is_array($v) ? self::responseToObject($v) : $v;
            if (!$has_str_keys) {
                $result_arr[$k] = $object;
            }
            $result_obj->{$k} = $object;
            $v = null;
        }
        return ($has_str_keys) ? $result_obj : $result_arr;
    }
}
