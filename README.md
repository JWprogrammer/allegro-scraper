## Extractor (scraper, crawler) of products from Allegro (2024)


### It is also available as API for _all programming languages_ <br> (Javascript, Python, Go, Java, Kotlin, PHP, C#, Swift, R, Ruby, C, C++, Rust, Perl and others)

#### ✅ ***Actual in 2024!***
#### It receives the search output of Allegro.pl, as well as detailed information about the products

#### To start use the project, please contact: https://t.me/JWprogrammer

## Description
We offer you a ready-made extractor of products from Allegro. It receives the search output of Allegro.pl, as well as detailed information about the goods.

The scraper is very easy to integrate with your website. Extractor is universal, it doesn't matter what CMS or engine your site is based on.

This crawler is working stably for two years now. It has never been banned by Allegro. In 2023 the scraper continues to work stably and quickly.

The data scraper can work "on the fly", that is, it can extract data from Allegro in real time when a request is made (from the point of view of your site, when a user visits some page). This ensures 100% data relevance and reduces the load on the server.
Also, this Allegro crawler can be used to constantly scraping all the products, that is, saving and updating a full catalog of products. 

## Installation
1) Get access to the scraper. To do this, please contact: https://t.me/JWprogrammer
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

$product->id;
$product->title;
$product->url;
$product->active;
$product->availableQuantity;
$product->price;
$product->price_with_delivery;
$product->seller;
$product->rating;
$product->buyers;
$product->delivery_options;
$product->currency;
$product->category_path;
$product->specifications;
$product->images;
$product->description;
$product->reviews;
$product->compatibility;
```

## Full documentation with all methods, parameters, filters and fields
### We will provide you with full documentation.
### To start use the project, please contact: https://t.me/JWprogrammer
