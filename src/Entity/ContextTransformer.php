<?php

    namespace Fei\Service\Logger\Entity;


    use League\Fractal\TransformerAbstract;

    class ContextTransformer extends TransformerAbstract
    {

        public function transform(Context $context)
        {

            return [
                'id'  => (int) $context->getId(),
                'key' => $context->getKey(),
                'value' => $context->getValue()
            ];
        }
    }
