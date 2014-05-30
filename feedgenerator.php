<?php

/* 
 * By Oriol Mangas Abellan, PHP Web Developer 
 * comments please email me on oriolmangas@gmail.com
 * 
 * Simple way to generate a simple google shooping feed
 * 
 * feedshooping($products); generates de feed
 * 
 * generatefile(); // save the file as .txt, separator are "\n" (tab) and end of line "\n"
 *
 */


include 'shoopingfuncs.php';

// what we need 
// $products  => Array of all products with the minimum information, look shoopingfuncs.php.
// $folder    => file directory where you want to save the feed
// $name_file => final name for feeds file
        
$feed       = feedshooping($products);  // returns the feed or false

$file_generated = generatefile($folder, $name_file, $feed);  // returns true or false

