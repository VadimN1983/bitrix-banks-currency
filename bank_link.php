<?php
/**
 * @package Thelema Currency
 * @subpackage Banks url
 * @author Vadim A. Nikitin, 2021
 * @version 0.0.1
 */

declare(strict_types=1);

namespace Thelema\Currency;

use \Bitrix\Main\Web\HttpClient as HttpClient;

/**
 * Class BankLink
 *
 * @package Thelema\Currency
 */
abstract class BankLink {

    /**
     * Bank url
     * @var array
     */
    public static $url = [
        'RU' => 'http://www.cbr.ru/scripts/XML_daily.asp',
        'BY' => 'https://www.nbrb.by/api/exrates/rates',
        'UA' => 'https://bank.gov.ua/NBU_Exchange/exchange',
        'UZ' => 'https://cbu.uz/ru/arkhiv-kursov-valyut/json/',
        'TJ' => 'https://nbt.tj/ru/kurs/export_xml.php'
    ];

    /**
     * HttpClient settings
     * @var array
     */
    public static $request_options = [
        "redirect" => true,
        "redirectMax" => 5,
        "waitResponse" => true,
        "socketTimeout" => 30,
        "streamTimeout" => 60,
        "version" => HttpClient::HTTP_1_0,
        "compress" => false,
        "charset" => "utf-8",
        "disableSslVerification" => false
    ];

    /**
     * Prepares full url
     * @param string|null $country_code
     * @return string
     */
    public function url(string $country_code = null): string {
        switch ($country_code) {
            case 'BY':
                static::$url[$country_code] = static::$url[$country_code] . '?' . http_build_query([
                        'periodicity' => 0
                    ]);
                break;

            case 'UA':
                static::$url[$country_code] = static::$url[$country_code] . '?' . http_build_query([
                        'json' => 'Y'
                    ]);
                break;

            case 'TJ':
                static::$url[$country_code] = static::$url[$country_code] . '?' . http_build_query([
                        'date' => date('Y-m-d'),
                        'export' => 'xmlout'
                    ]);
                break;
        }

        return static::$url[$country_code];
    }
}