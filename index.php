<?php
define('NEED_AUTH', false);
define('NO_KEEP_STATISTIC', true);
define("NO_AGENT_CHECK", true);
define('NOT_CHECK_PERMISSIONS',true);
define('BX_CRONTAB', true);
define('BX_NO_ACCELERATOR_RESET', true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php" );
$_SESSION["SESS_SHOW_INCLUDE_TIME_EXEC"] = "N";
$APPLICATION->ShowIncludeStat = false;

use \Bitrix\Main\ {
    Application as App,
    Loader,
    IO
};
use \Thelema\Currency as Currency;

/**
 * Simple dumper
 * @param null $obj
 */
function dump($obj = null) {
    echo '<pre>';
    print_r($obj);
    echo '</pre>';
}

/**
 * Relative path to any dir
 * @return mixed
 */
function thelemaPath() {
    $dir = new IO\Directory(__DIR__);
    return str_replace(App::getDocumentRoot(),  '', $dir->getPath()) ;
}

Loader::registerAutoLoadClasses(
    null,
    [
        namespace\Thelema\Currency\BankLink::class          => thelemaPath() . '/bank_link.php',
        namespace\Thelema\Currency\CurrencyInterface::class => thelemaPath() . '/currency_interface.php',
        namespace\Thelema\Currency\CentralBank::class       => thelemaPath() . '/central_bank.php'
    ]
);

dump(Currency\CentralBank::getInstance()->load('TJ'));