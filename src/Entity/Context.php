<?php
    namespace Fei\Service\Logger\Entity;

    use Fei\Entity\AbstractEntity;

    /**
     * Class Context
     *
     * @Entity
     * @Table(name="contexts")
     */
    class Context extends AbstractEntity
    {
        /**
         * @Id
         * @GeneratedValue(strategy="AUTO")
         * @Column(type="integer")
         */
        protected $id;

        /**
         * @ManyToOne(targetEntity="Notification", inversedBy="contexts")
         * @JoinColumn(name="notification_id", referencedColumnName="id")
         */
        protected $notification;

        /**
         * @Column(type="string", name="`key`")
         */
        protected $key;

        /**
         * @Column(type="string", name="`value`")
         */
        protected $value;


        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @param mixed $id
         *
         * @return Context
         */
        public function setId($id)
        {
            $this->id = $id;

            return $this;
        }


        /**
         * @return mixed
         */
        public function getNotification()
        {
            return $this->notification;
        }

        /**
         * @param mixed $notification
         *
         * @return Context
         */
        public function setNotification($notification)
        {
            $this->notification = $notification;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getKey()
        {
            return $this->key;
        }

        /**
         * @param mixed $key
         *
         * @return Context
         */
        public function setKey($key)
        {
            $this->key = $key;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getValue()
        {
            return $this->value;
        }

        /**
         * @param mixed $value
         *
         * @return Context
         */
        public function setValue($value)
        {
            $this->value = $value;

            return $this;
        }
    }
