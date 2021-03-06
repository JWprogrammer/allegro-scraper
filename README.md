## Extractor (scraper, crawler) of products from Allegro (2021)

#### ✅ ***Actual in 2021!***
#### It receives the search output of Allegro.pl, as well as detailed information about the products

#### To buy the project, please contact: https://t.me/JWprogrammer
#### The program is a paid solution. You buy the whole scraper program and it will work all the time on your server and work directly with Allegro.pl (no third-party databases or APIs are used), so you won't need to make any subscription fees.

## Description
We offer you a ready-made extractor of products from Allegro. It receives the search output of Allegro.pl, as well as detailed information about the goods.

The scraper is very easy to integrate with your website. Extractor is universal, it doesn't matter what CMS or engine your site is based on.

This crawler is working stably for two years now. It has never been banned by Allegro. In 2021 the scraper continues to work stably and quickly.

The data scraper can work "on the fly", that is, it can extract data from Allegro in real time when a request is made (from the point of view of your site, when a user visits some page). This ensures 100% data relevance and reduces the load on the server.
Also, this Allegro crawler can be used to constantly scraping all the products, that is, saving and updating a full catalog of products. 

## Installation
1) Install the scraper on your server. To do this, please contact: https://t.me/JWprogrammer
2) Use the crawler in your project. Simply add the library to the project via the composer dependencies:
```
composer require jwprogrammer/allegro-scraper
```

## Usage examples
```PHP
require __DIR__ . '/vendor/autoload.php';

$allegro = new \AllegroScraper\AllegroScraper();

$result = $allegro->search([
    'page' => 1,
    'query' => 'Led halogen lampa',
    'category' => 'czesci-samochodowe-620',
    'order' => 'pd'
]);
if ($result->success) {
    $result->totalCount;
    foreach ($result->products as $product) {
        $product->id;
        $product->url;
        $product->title;
        $product->price;
        $product->price_with_delivery;
        $product->mainThumbnail;
        $product->mainImage;
    }
}
```

```PHP
$allegro = new \AllegroScraper\AllegroScraper();

$result = $allegro->details([
    'product_id' => 11437180475
]);

print_r($result); //ALL INFORMATION about this product
```

## Full documentation with all methods, parameters, filters and fields
### We will provide you with full documentation.
### To buy the project, please contact: https://t.me/JWprogrammer
