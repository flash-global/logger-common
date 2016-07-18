<?php
    
    namespace Fei\Service\Logger\Validator;
    
    use Fei\Entity\EntityInterface;
    use Fei\Entity\Validator\AbstractValidator;
    use Fei\Entity\Validator\Exception;
    use Fei\Service\Logger\Entity\Notification;
    
    /**
     * This file is part of the Objective PHP project
     *
     * More info about Objective PHP on www.objective-php.org
     *
     * @license http://opensource.org/licenses/GPL-3.0 GNU GPL License 3.0
     */
    class NotificationValidator extends AbstractValidator
    {
        public function validate(EntityInterface $entity)
        {
            if (!$entity instanceof Notification)
            {
                throw new Exception('Entity to validate must be an instance of "Notification"');
            }
            
            $this->validateMessage($entity->getMessage());
            $this->validateLevel($entity->getLevel());
            $this->validateNamespace($entity->getNamespace());
            $this->validateOrigin($entity->getOrigin());
            
            return empty($this->getErrors());
        }
        
        public function validateLevel($level)
        {
            if (!in_array($level, array(Notification::LVL_DEBUG, Notification::LVL_INFO, Notification::LVL_WARNING, Notification::LVL_ERROR, Notification::LVL_PANIC)))
            {
                $this->addError('level', 'Invalid level value');
                
                return false;
            }
            
            return true;
        }
        
        public function validateMessage($message)
        {
            if (empty($message))
            {
                $this->addError('message', 'Message cannot be empty');
                
                return false;
            }
            
            return true;
        }
        
        public function validateNamespace($namespace)
        {
            if (empty($namespace))
            {
                $this->addError('namespace', 'Namespace cannot be empty');
                
                return false;
            }
            
            return true;
        }
        
        public function validateOrigin($origin)
        {
            if (empty($origin))
            {
                $this->addError('origin', 'Origin cannot be empty');
                
                return false;
            }
            
            return true;
        }
        
    }
