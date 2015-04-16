<?php 


// You can find the keys here : http://search.digitalgov.gov/

return array(
    'KEY' => 'YOUR API KEY',
    'Affiliate' => 'YOUR AFFILIATE SITE ADDRESS',
    'DEFAULTS' => array(
        'highlight' => true, // enable keyword highlighting markup within results
        'limit' => 20, // 1 to 999 results
        'sort' => 'relevance' // 'relevance' or 'date'
    ),
    'BING' => array( // optional tie-in
        'KEY' => 'YOUR BING/AZURE API KEY'
    ),
    'GOOGLE' => array( // optional tie-in
        'KEY' => 'YOUR GOOGLE SITE SEARCH API KEY',
        'CX' => 'YOUR GOOGLE CUSTOM SEARCH ENGINE KEY' // KEY and CX are both required, if using this option
    )
);