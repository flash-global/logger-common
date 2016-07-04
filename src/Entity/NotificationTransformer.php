<?php

namespace Fei\Service\Logger\Entity;


use League\Fractal\TransformerAbstract;

class NotificationTransformer extends TransformerAbstract
{

    public function transform(Notification $notification)
    {
        return [
            'id' => (int) $notification->getId(),
            'reported_at' => $notification->getReportedAt()->format(\DateTime::ISO8601),
            'level' => (int) $notification->getLevel(),
            'flags' => (int) $notification->getFlags(),
            'namespace' => $notification->getNamespace(),
            'message' => $notification->getMessage(),
            'backtrace' => $notification->getBackTrace(),
            'user' => $notification->getUser(),
            'server' => $notification->getServer(),
            'command' => $notification->getCommand(),
            'origin' => $notification->getOrigin(),
            'category' => $notification->getCategory(),
            'env' => $notification->getEnv(),
            'context' => $notification->getContext(),
        ];
    }
}
