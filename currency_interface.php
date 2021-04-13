<?php
declare(strict_types=1);

/**
 * @package Thelema Currency
 * @subpackage Currency interface
 * @author Vadim A. Nikitin, 2021
 * @version 0.0.1
 */

namespace Thelema\Currency;


/**
 * Interface CurrencyInterface
 *
 * @package Thelema\Currency
 */
interface CurrencyInterface
{
    /**
     * Returns an array of currency rates by country code
     * @param string|null $country_code
     * @return array
     */
    public function load(string $country_code = null): array;

    /**
     * Converts result to array if content type is xml
     * @return array
     */
    public function parseXml(): array;

    /**
     * Converts result to array if content type is json
     * @return array
     */
    public function parseJson(): array;

    /**
     * Returns singleton
     * @return CentralBank
     */
    public static function getInstance(): CentralBank;
}