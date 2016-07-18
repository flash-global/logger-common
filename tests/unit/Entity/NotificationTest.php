<?php
    
    namespace Tests\Fei\Service\Logger\Entity;
    
    use Fei\Service\Logger\Entity\Context;
    use Fei\Service\Logger\Entity\Notification;

    class NotificationTest extends \Codeception\Test\Unit
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
        
    }
