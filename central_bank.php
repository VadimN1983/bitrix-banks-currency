<?php
/**
 * @package Thelema Currency
 * @subpackage Banks url
 * @author Vadim A. Nikitin, 2021
 * @version 0.0.1
 */

declare(strict_types=1);

namespace Thelema\Currency;

use \Bitrix\Main\ {
    Web\HttpClient as HttpClient,
    Web\Json as Json,
    Text\Encoding as Encoding,
    ArgumentException as ArgException
};


/**
 * Class CentralBank
 *
 * @package Thelema\Currency
 */
final class CentralBank extends BankLink implements CurrencyInterface
{
    /**
     * Singleton instance
     * @var null
     */
    private static $instance = null;

    /**
     * XML Parser instance
     * @var null
     */
    private $xml = null;

    /**
     * Any data parser
     * @var null
     */
    private $data = null;

    /**
     * Content type
     * @var null
     */
    private $contentType = null;

    /**
     * Empty CentralBank constructor.
     */
    private function __construct() {

    }

    /**
     * Load data by simple country code
     * @param string|null $country_code
     * @return array
     * @throws ArgException
     */
    public function load(string $country_code = null): array {

        if (!isset(parent::$url[$country_code])) {
            throw new ArgException('No country detected.');
        } else {
            $httpClient = new HttpClient(self::$request_options);
            $this->data = $httpClient->get(self::url($country_code));
            $this->contentType = $httpClient->getContentType();
            switch ($this->contentType) {

                case 'application/json':
                    return self::parseJson();
                    break;

                case 'application/xml':
                default:
                    return self::parseXml();
                    break;
            }
        }
    }

    /**
     * XML data decode
     * @return array
     */
    public function parseXml(): array {

        $this->xml = new \CDataXML(true);
        $this->xml->LoadString($this->data);

        $res = [];
        if ($node = $this->xml->SelectNodes('/ValCurs')->children) {
            foreach ($node as $cur) {
                $tmp = [];
                foreach ($cur->children as $c) {
                    $tmp[$c->name] = Encoding::convertEncodingToCurrent($c->content);
                }

                $tmp['Iso'] = $cur->getAttribute('ID');
                $res[] = $tmp;
            }
        }

        return $res;
    }

    /**
     * Json data decode
     * @return array
     * @throws ArgException
     */
    public function parseJson(): array {
        try {
            return Json::decode($this->data);
        } catch (\Exception $e) {
            throw new ArgException('Invalid json format: ' . $e->getMessage());
        }
    }

    /**
     * Singleton
     * @return CentralBank
     */
    public static function getInstance(): self {
        if (null === self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Empty clone
     */
    private function __clone() {

    }
}