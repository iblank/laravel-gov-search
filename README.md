# laravel-gov-search
Laravel PHP Facade/Wrapper for the USA.gov, DigitalGov Search API. You will need to create an account with DigialGov to create an affiliate id and access token key: http://search.digitalgov.gov/

## Installation
1. Add project to the require array in your `composer.json` file:

        "require": {
            "iblank/laravel-gov-search": "dev-master"
        }
2. Run `composer update` to pull down the latest version of the package.
3. Open `app/config/app.php`**&#42;** and add the service provider to your `providers` array:

        'providers' => array(
            'iblank\GovSearch\GovSearchServiceProvider'
        )

**&#42; NOTE:** if you are using environmental configurations, make sure to place the service provider in the `app.php` file respective to your environment.

## Configuration
### For Laravel 5
Run `php artisan vendor:publish` and set your API key and affiliate id in the file:
```
/app/config/govsearch.php
```
### For Laravel 4
Run `php artisan config:publish iblank/laravel-gov-search` and set your API key and affiliate id in the file:
```
/app/config/packages/iblank/laravel-gov-search/config.php
```
### Default Options
Optionally change the default values for search requests using the `DEFAULTS` array in the config file:
```php
'DEFAULTS' => array(
    'highlight' => true,
    'limit' => 20, // 1 to 999
    'sort' => 'relevance' // or 'date'
)
```

## Usage
```php
/**
 * Returns PHP object of search results
 * @param $search (string) - what to search for
 * @param $options (array) - set an 'offset' index and/or override any of the defaults set in the config file
 * @return (object) - PHP object (details below)
 */
$apiResult = GovSearch::search($search, $options);
```
#### Sample Format of Returned Object:
```javascript
{
    "total": 356,
    "next_offset": 20,
    "spelling_correction": null,
    "results": [
        {
            "title": "sample title",
            "url": "http://www.anyplace.com",
            "snippet": "sample snippet",
            "publication_date": "2014-11-24"
        }
    ]
}
```

## Basic Search Pagination Example
```php
// Set Defaults
$search = 'Medal of Honor';
$options = array(
    'offset' => 0,
    'limit' => 25
);

// Make initial call
$apiResult = GovSearch::search($search, $options);

// Set total results
$totalResults = $apiResult['total'];

// Set total pages
$totalPages = ceil($totalResults / $options['limit']);

// Using this example, with 77 total results, would give you 4 pages
// If you want to go to page 3 of 4...
$page = 3;
$options['offset'] = ($page - 1) * $options['limit'];
$apiResults = GovSearch::search($search, $options);
```

## Credits
Built on code from Alaouy's [Youtube](https://github.com/alaouy/Youtube) Laravel Facade/Wrapper.
