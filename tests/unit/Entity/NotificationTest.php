<?php

namespace Tests\Fei\Service\Logger\Entity;

use Codeception\Test\Unit;
use Fei\Service\Logger\Entity\Context;
use Fei\Service\Logger\Entity\Notification;

class NotificationTest extends Unit
{
    public function testHydration()
    {
        $notificationData = array(
            'message' => 'test message',
            'namespace' => '/test',
            'origin' => 'cli',
            'context' => array(
                array('key' => 'test', 'value' => 'test value'),
                array('key' => 'test2', 'value' => 'test value2')
            )
        );

        $notification = new Notification($notificationData);

        $this->assertCount(2, $notification->getContext());

        $context = $notification->getContext()->first();
        $this->assertInstanceOf(Context::class, $context);
        $this->assertEquals('test', $context->getKey());
        $this->assertEquals('test value', $context->getValue());
    }

    public function testEmptySerialization()
    {
        $notification = new Notification();
        $notification->setOrigin('cron');

        $serialized = json_encode($notification->toArray());

        $return = new Notification();
        $return = $return->hydrate(json_decode($serialized, true));

        $this->assertEquals($notification, $return);
    }

    public function testSerialization()
    {
        $notification = new Notification();
        $notification
            ->setId(1)
            ->setReportedAt('2016-07-18')
            ->setLevel(Notification::LVL_DEBUG)
            ->setFlags(1)
            ->setNamespace('/Test/AnotherTest')
            ->setMessage('This is a message')
            ->setBackTrace(['A back trace']) //FIXME The string `[]` doesn't work here
            ->setUser('A user')
            ->setServer('serverName')
            ->setCommand('acommand')
            ->setOrigin('http')
            ->setCategory(Notification::AUDIT)
            ->setEnv('test')
            ->setContext([
                new Context(['id' => 1, 'key' => 'a key', 'value' => 'a value']),
                new Context(['id' => 2, 'key' => 'a another key', 'value' => 'a another value'])
            ]);

        $serialized = json_encode($notification->toArray());

        $return = new Notification();
        $return = $return->hydrate(json_decode($serialized, true));

        $this->assertEquals($notification, $return);
    }
}
