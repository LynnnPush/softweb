<?php
namespace App\Service;
class WelcomeGenerator
 {
    public static function getWelcome(string $name): string
{
         return "Hello, $name!";
}
}