# \\[Lollipop](https://github.com/jabernardo/lollipop-php)\Scraper

These page will show you on how-to use ```\Lollipop\Scraper``` 

### Scraping ...

```php
<?php

$scraper = new \Lollipop\Scraper('http://domain.com');


```

### getContentsByAttr($attr, $attr_value) ```(array)```
Get contents of an element by using attributes

```php
<?php

$scraper = new \Lollipop\Scraper('http://domain.com');

$thumbnails = $scraper->getContentsByAttr('class', 'thumbnail');

```

### getContentsByElem('div') ```(array)```
Get contents of an element by using element name

```php
<?php

$scraper = new \Lollipop\Scraper('http://domain.com');

$divs = $scraper->getContentsByElem('div');

```

### getAttrByAttr($attr, $attr_value, $attr_to_get) ```(array)```
Get attribute value using other attributes

```php
<?php

$scraper = new \Lollipop\Scraper('http://domain.com');

$thumb_hrefs = getAttrByAttr('class', 'thumbnail', 'href');

```

### getAttrByElem($element) ```(array)```
Get attributes of elements

```php
<?php

$scraper = new \Lollipop\Scraper('http://domain.com');

$attrs = $scraper->getAttrByElemWithAttr('a');

/* Output:
 *        Array
 *        (
 *            [0] => Array
 *            (
 *                [href] => www.sample.com
 *                [class] => thumbnail
 *            )
 *        )
 */

```

### getAttrByElemWithAttr($element, $attr, $attr_value) ```(array)```
Get attributes by element using another attributes

```php
<?php

$scraper = new \Lollipop\Scraper('http://domain.com');

$attrs = $scraper->getAttrByElemWithAttr('a');

/* Output:
 *        Array
 *        (
 *            [0] => Array
 *            (
 *                [href] => www.sample.com
 *                [class] => thumbnail
 *            )
 *        )
 */

```
