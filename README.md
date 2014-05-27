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
// $products  => Array of all products with the minimum information, look shoopingfuncs.php for and example.
// $folder    => file directory where you want to save the feed
// $name_file => final name for feeds file

basic information in this generator:

feed_header => id + title + brand + description + link + condition + price + availability + image link + mpn + google product category + category

if you need to introduce more information the the feed have a look in the specifications in google shooping

Any question send me and email to oriolmangas@gmail.com

Oriol.
