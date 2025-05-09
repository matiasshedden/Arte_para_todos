<?php
// Require the Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Configure Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false, // Set to a directory path for production
    'debug' => DEBUG, // Usar la constante DEBUG
]);

// Example data
$name = "World";
$items = [
    ['name' => 'Appetizer', 'price' => 8.99],
    ['name' => 'Main Course', 'price' => 15.99],
    ['name' => 'Dessert', 'price' => 6.50],
    ['name' => 'Beverage', 'price' => 3.25],
];

// Render the template with the data
echo $twig->render('hello.twig', [
    'title' => 'Welcome to Twig',
    'name' => $name,
    'current_date' => new \DateTime(),
    'menu_items' => $items,
]);

echo "\n\nTwig is now set up and working correctly in your project!";

