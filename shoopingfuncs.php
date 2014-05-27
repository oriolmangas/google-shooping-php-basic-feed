<?php

// Generates the feed
// Need object array of all products, modify ( gets ) in this function to adapt to you case

function feedshooping($products) {

    $feed_productos = "";

    $feed_header = 'id' . "\t" . 'title' . "\t" . 'brand' . "\t" . 'description' . "\t" . 'link' . "\t" . 'condition' . "\t" . 'price' . "\t" . 'availability' . "\t" . 'image link' . "\t" . 'mpn' . "\t" . 'google product category' . "\t" . 'category' . "\n";

    foreach ($products as $product) {
        
        $product_id      = $product->getName();          // Reference in your website
        $name            = $product->getName();
        $reference       = $product->getReference();     // Reference mpn ( you can use ean if you want )
        $price           = $product->getPrice();         // example '55.23';
        $condition       = $product->getCondition();     // example 'new';
        $availability    = $product->getAvailability();  // example 'in stock';
        $brand           = $product->getBrand();         // example 'Sony'
        $description     = cleandescription($product->getDescription());  // Cleaned desription
        $categoryWeb     = $product->getCategoryURL(); // category in your website, for exmple    Media > DVDs & Movies > Television Shows
        $categoryGS      = $prodcut->getCategoryGS();  // category in Google Shooping, look http://www.google.com/basepages/producttype/taxonomy.en-US.txt. example = DVDs & Movies > TV Series > Fantasy Drama
        $link            = $prodcut->getLink();        // final url for product, example http://www.example.com/media/dvd/?sku=384616&src=gshopping&lang=en
        $link_img        = $prodcut->getLinkImg();     // iage url, example http://images.example.com/DVD-0564738?size=large&format=PNG
    
        $feed_products   = $feed_products . $product_id . "\t" . $name . "\t" . $brand . "\t" . $description . "\t" . $link . "\t" . $condition . "\t" . $price . "\t" . $availability . "\t" . $link_img . "\t" . $reference . "\t" . $categoryGS . "\t" . $categoryWeb . "\n";
    
    }
    
    if($feed_products){
        return ($feed_products);
    }else{
        return ('false');
    }
 
}



// Generates de file in memory as .txt

function generatefile($folder, $name_file, $feed) {

    $feed_generated = 'false';
    
    try {
        $file   = fopen($folder . $name_file . '.txt', 'w');    // open file          
        $errorw = fwrite($file, $feed_head . $feed_body);     // write file
        $errorc = fclose($file);                              // close file
        $feed_generated = 'true';
    } catch (Exception $e) {
        $feed_generated = 'false';
    }

    if ($feed_generado == 'true') {
        echo('feed  generated' . "\n");
        return('true');
    } else {
        echo('Generating error' . "\n" . 'ERROR: ' . $e . "\n");
        return('false');
    }
}



// we have to clean our description to avoid html tags and "\t" or "\n".

function cleandescription($descripcion) {

    $descripcion = strip_tags($descripcioncortada);
    $descripcion = html_entity_decode($descripcion, ENT_QUOTES, 'UTF-8');
    $descripcion = eregi_replace("[\n|\r|\n\r]", ' ', $descripcion);

    return ($descripcion);
}
