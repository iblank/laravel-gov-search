# laravel-gov-search
Laravel PHP Facade/Wrapper for the USA.gov, DigitalGov Search API. You will need to create an account with DigialGov to create an affiliate id and access token key: http://search.digitalgov.gov/

## Installation
1. Add `iblank/laravel-gov-search` to your `composer.json` file.
```
"iblank/laravel-gov-search": "dev-master"
```
2. Run `composer update` to pull down the latest version of the package.
3. Open `app/config/app.php` and add the service provider to your `providers` array
```php
'providers' => array(
	'iblank\GovSearch\GovSearchServiceProvider'
)
```

## Configuration
### For Laravel 5
Run `php artisan vendor:publish` and set your API key and affiliate id in the file :
```
/app/config/youtube.php
```
### For Laravel 4
Run `php artisan config:publish alaouy/youtube` and set your API key and affiliate id in the file :
```
/app/config/packages/alaouy/youtube/config.php
```
### Default Options
You can also change the default values for search requests using the `DEFAULTS` array in the config file.

## Usage
```php
/**
 * Returns PHP object of search results
 * @param $searchStr - string to search for
 * @param $offset - starting index of results array (default 0)
 * @param $options - reference array of optional options ('highlight': [boolean], 'limit': [1 to 50], 'sort': ['relevance' or 'date'])
 * @return - PHP object { total: [number of results], next_offset: [next offset index], spelling_correction: [spell correction of search term], results: [array of search result objects] }
 **/
$apiResult = GovSearch::search($search, $offset, $options);
```

## Basic Search Pagination
```php
// Set Defaults
$search = 'Medal of Honor';
$offset = 0;
$totalResults = 0;
$totalPages = 0;
$options = array(
	'limit' => 25
);

// Make initial call
$apiResult = GovSearch::search($search, $offset, $options);

// Set total results
$totalResults = $apiResults['total'];

// Set total pages
$totalPages = ceil($totalResults / $options['limit']);

// Using this example, with 77 total results, would give you 4 pages
// If you want to go to page 3 of 4...
$page = 3;
$offset = ($page - 1) * $options['limit'];
$apiResults = GovSearch::search($search, $offset, $options);


