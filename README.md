# Bitrix Banks Currency
A simplified way to get the exchange rates of central banks in different countries

The class provides quick access to the current exchange rates in different countries.

Available countries at this time:
 - RU - Russian Federation
 - BY - Republic of Belarus
 - UA - Republic of Ukraine
 - UZ - Republic of Uzbekistan
 - TJ - Republic of Tajikistan

Example:

```php
Currency\CentralBank::getInstance()->load('BY');
```

For more information, see "index.php" in repo.