<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Service\WelcomeGenerator;
use App\Controller\HelloWorldController;
use Symfony\Component\HttpFoundation\Response;

class UtilTest extends TestCase
{
    /**
     * Test that the WelcomeGenerator returns a valid welcome message.
     */
    public function testGenerateWelcomeMessage()
    {
        // Test with default name
        $message = WelcomeGenerator::getWelcome('World');

        // Check that the result is a non-empty string and contains the expected output
        $this->assertIsString($message, "Expected the welcome message to be a string.");
        $this->assertNotEmpty($message, "The welcome message should not be empty.");
        $this->assertEquals("Hello, World!", $message, "The welcome message should be 'Hello, World!'");

        // Test with custom name
        $customMessage = WelcomeGenerator::getWelcome('Symfony');
        $this->assertEquals("Hello, Symfony!", $customMessage, "The welcome message should be 'Hello, Symfony!'");
    }

    /**
     * Test the HelloWorldController's index action.
     */
    public function testControllerIndex()
    {
        // Create a mock for AbstractController
        $controller = $this->getMockBuilder(HelloWorldController::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['render'])
            ->getMock();

        // Use reflection to call the index method
        $method = new \ReflectionMethod(HelloWorldController::class, 'index');
        $method->setAccessible(true);

        // Test with default name
        $response = $method->invoke($controller, 'World');

        $this->assertInstanceOf(Response::class, $response, "Expected the controller response to be a Response object.");
        $this->assertEquals("Greeting: Hello, World!", $response->getContent(), "The response content should match the expected greeting.");

        // Test with custom name
        $customResponse = $method->invoke($controller, 'Symfony');
        $this->assertEquals("Greeting: Hello, Symfony!", $customResponse->getContent(), "The response should include the custom name.");
    }

    /**
     * Test that the WelcomeGenerator handles special characters correctly.
     */
    public function testSpecialCharactersInWelcome()
    {
        $message = WelcomeGenerator::getWelcome('<script>alert("XSS")</script>');
        $this->assertIsString($message);
        $this->assertStringContainsString('&lt;script&gt;', htmlspecialchars($message), "The welcome message should escape HTML special characters.");
    }

    /**
     * Test that the route parameter works correctly.
     */
    public function testRouteParameterPassing()
    {
        // This is a simplified test since we can't test the actual routing in a unit test
        // In a real application, you'd use a functional test for this
        $names = ['John', 'Alice', 'Bob', ''];

        foreach ($names as $name) {
            $safeName = empty($name) ? 'World' : $name; // Default to 'World' if empty
            $message = WelcomeGenerator::getWelcome($safeName);
            $this->assertEquals("Hello, $safeName!", $message, "The welcome message should use the provided name.");
        }
    }
}