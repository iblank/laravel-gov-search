# laravel-gov-search
Laravel PHP Facade/Wrapper for the USA.gov, DigitalGov Search API. You will need to create an account with DigialGov to create an affiliate id and access token key: http://search.digitalgov.gov/

## Installation
1. Add project to the require array in your `composer.json` file:

        "require": {
            "iblank/laravel-gov-search": "dev-master"
        }
2. Run `composer update` to pull down the latest version of the package.
3. Open `app/config/app.php` and add the service provider to your `providers` array:

        'providers' => array(
            'iblank\GovSearch\GovSearchServiceProvider'
        )

## Configuration
### For Laravel 5
Run `php artisan vendor:publish` and set your API key and affiliate id in the file:
```
/app/config/youtube.php
```
### For Laravel 4
Run `php artisan config:publish alaouy/youtube` and set your API key and affiliate id in the file:
```
/app/config/packages/alaouy/youtube/config.php
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
 * @param $offset (int) - starting index of results array (default 0)
 * @param $options (array) - override any of the defaults set in the config file
 * @return (object) - PHP object (details below)
 */
$apiResult = GovSearch::search($search, $offset, $options);
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
$offset = 0;
$options = array(
    'limit' => 25
);

// Make initial call
$apiResult = GovSearch::search($search, $offset, $options);

// Set total results
$totalResults = $apiResult['total'];

// Set total pages
$totalPages = ceil($totalResults / $options['limit']);

// Using this example, with 77 total results, would give you 4 pages
// If you want to go to page 3 of 4...
$page = 3;
$offset = ($page - 1) * $options['limit'];
$apiResults = GovSearch::search($search, $offset, $options);
```

## Credits
Built on code from Alaouy's [Youtube](https://github.com/alaouy/Youtube).
