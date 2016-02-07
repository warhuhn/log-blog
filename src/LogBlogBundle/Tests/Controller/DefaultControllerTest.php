<?php

namespace LogBlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        static::markTestSkipped('Symfony Default Controller');
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertContains('Hello World', $client->getResponse()->getContent());
    }
}
