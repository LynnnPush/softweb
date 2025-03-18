<?php

namespace App\Controller;

use App\Service\WelcomeGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HelloWorldController extends AbstractController
{
    #[Route('/hello/{name}', name: 'hello_world', defaults: ['name' => 'World'])]
    public function index(string $name): Response
    {
        $message = WelcomeGenerator::getWelcome($name);
        return new Response("Greeting: $message");
    }
}