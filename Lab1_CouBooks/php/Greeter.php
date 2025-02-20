<?php

namespace php;

class Greeter
{
    // Define an array of greetings
    private $greetings = [
        "Hello, welcome!",
        "Hi there, have a great day!",
        "Greetings, and welcome aboard!",
        "Welcome, friend!"
    ];

    // This method returns a random greeting from the array
    public function getGreeting() {
        // array_rand() picks a random key from the array
        $randomKey = array_rand($this->greetings);
        return $this->greetings[$randomKey];
    }
}