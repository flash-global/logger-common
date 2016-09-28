<?php

namespace Fei\Service\Logger\Validator;

use Fei\Entity\EntityInterface;
use Fei\Entity\Validator\AbstractValidator;
use Fei\Entity\Validator\Exception;
use Fei\Service\Context\Validator\ContextAwareValidatorTrait;
use Fei\Service\Logger\Entity\Notification;

/**
 * Class NotificationValidator
 *
 * @package Fei\Service\Logger\Validator
 */
class NotificationValidator extends AbstractValidator
{
    use ContextAwareValidatorTrait;

    /**
     * {@inheritdoc}
     */
    public function validate(EntityInterface $entity)
    {
        if (!$entity instanceof Notification) {
            throw new Exception('Entity to validate must be an instance of "Notification"');
        }

        $this->validateMessage($entity->getMessage());
        $this->validateLevel($entity->getLevel());
        $this->validateNamespace($entity->getNamespace());
        $this->validateOrigin($entity->getOrigin());
        $this->validateReportedAt($entity->getReportedAt());
        $this->validateContext($entity->getContext());

        $errors = $this->getErrors();

        return empty($errors);
    }

    /**
     * @param $level
     *
     * @return bool
     */
    public function validateLevel($level)
    {
        if (!in_array($level, array(
            Notification::LVL_DEBUG,
            Notification::LVL_INFO,
            Notification::LVL_WARNING,
            Notification::LVL_ERROR,
            Notification::LVL_PANIC
        ))
        ) {
            $this->addError('level', 'Invalid level value');

            return false;
        }

        return true;
    }

    /**
     * @param $message
     *
     * @return bool
     */
    public function validateMessage($message)
    {
        if (empty($message)) {
            $this->addError('message', 'Message cannot be empty');

            return false;
        }

        return true;
    }

    /**
     * @param $namespace
     *
     * @return bool
     */
    public function validateNamespace($namespace)
    {
        if (empty($namespace)) {
            $this->addError('namespace', 'Namespace cannot be empty');

            return false;
        }

        return true;
    }

    /**
     * @param $origin
     *
     * @return bool
     */
    public function validateOrigin($origin)
    {
        if (empty($origin)) {
            $this->addError('origin', 'Origin cannot be empty');
            return false;
        }

        if (!in_array($origin, array('http', 'cli', 'cron'))) {
            $this->addError('origin', 'Origin must be either "http", "cli" or "cron"');
            return false;
        }

        return true;
    }

    /**
     * @param $reportedAt
     *
     * @return bool
     */
    private function validateReportedAt($reportedAt)
    {
        if (empty($reportedAt)) {
            $this->addError('reported_at', 'Report date and time cannot be empty');

            return false;
        }

        return true;
    }
}
