php-benchmark-ternary_operation
===============================

How quick a short-hand of the conditional operator is.

Prepering
------
    $max = 10000; //million loop
    $cnt = 10; //10 times
    
    $feedurl = 'contents.xml'; //yahoo news RSS
    $dom     = simplexml_load_file($feedurl, 'SimpleXMLElement', 0);
    $items   = $dom->xpath('//item');
    $item    = array_shift($items);
    
    $func    = function($str){ return htmlspecialchars($str); };

Results
------
### Sakura Internet VPS 1G ###

Average:

    ?1:0                 : 0.01757698s
    ?:0                  : 0.01499784s
    if(){1}{0}           : 0.01287918s
    
    ->?->:0              : 0.23545763s
    ->?:0                : 0.14179544s
    if(->){->}{0}        : 0.18292944s
    
    f(->)?f(->):0        : 0.40271592s
    f(->)?:0             : 0.20902412s
    if(f(->)){f(->)}{0}  : 0.41783948s

### Amazon EC2 Small Instance ###

Average:

    ?1:0                 : 0.02561765s
    ?:0                  : 0.02027040s
    if(){1}{0}           : 0.01852813s
    
    ->?->:0              : 0.45636880s
    ->?:0                : 0.33789077s
    if(->){->}{0}        : 0.44115984s
    
    f(->)?f(->):0        : 0.96727324s
    f(->)?:0             : 0.49595876s
    if(f(->)){f(->)}{0}  : 0.94341285s

