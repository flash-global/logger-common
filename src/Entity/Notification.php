<?php
    namespace Fei\Service\Logger\Entity;

    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\ORM\Mapping\Column;
    use Doctrine\ORM\Mapping\Entity;
    use Doctrine\ORM\Mapping\GeneratedValue;
    use Doctrine\ORM\Mapping\Id;
    use Doctrine\ORM\Mapping\Index;
    use Doctrine\ORM\Mapping\Table;
    use Fei\Entity\AbstractEntity;


    /**
     * Class NotificationEndpoint
     *
     * @Entity
     * @Table(name="notifications", indexes={@Index(name="idx_notification_levels", columns={"level"}),
     *                              @Index(name="idx_notification_servers", columns={"server"}),
     *                                                                      @Index(name="idx_notification_envs", columns={"env"})})
     */
    class Notification extends AbstractEntity
    {
        // category
        const SECURITY    = 1;
        const PERFORMANCE = 2;
        const BUSINESS    = 4;
        const AUDIT       = 8;

        // level
        const DEBUG   = 1;
        const INFO    = 2;
        const WARNING = 4;
        const ERROR   = 8;
        const PANIC   = 16;


        protected $levelLabels    = [1 => 'Debug', 2 => 'Info', 4 => 'Warning', 8 => 'Error', 16 => 'Panic'];

        protected $categoryLabels = [1 => 'Security', 2 => 'Performance', 4 => 'Business', 8 => 'Audit'];

        /**
         * @Id
         * @GeneratedValue(strategy="AUTO")
         * @Column(type="integer")
         */
        protected $id;

        /**
         * @Column(type="datetime")
         *
         */
        protected $reportedAt;

        /**
         * @Column(type="integer")
         */
        protected $level = 2;

        /**
         * @Column(type="integer")
         */
        protected $flags = 0;

        /**
         * @Column(type="string")
         */
        protected $namespace;

        /**
         * @Column(type="string")
         */
        protected $message;

        /**
         * @Column(type="text", nullable=true)
         */
        protected $backTrace;

        /**
         * @Column(type="string", name="user", nullable=true)
         */
        protected $user;

        /**
         * @Column(type="string", nullable=true)
         */
        protected $server;

        /**
         * @Column(type="string", nullable=true)
         *
         * This represents URL+QUERY STRING for HTTP environment and command line for CLI
         */
        protected $command;

        /**
         * @Column(type="string")
         */
        protected $origin;

        /**
         * @Column(type="integer", nullable=true)
         */
        protected $category;

        /**
         * Environment of the originating application
         *
         * @Column(type="string")
         */
        protected $env = 'n/c';

        /**
         * @OneToMany(targetEntity="Context", mappedBy="notification")
         */
        protected $contexts;

        public function __construct()
        {
            $this->contexts = new ArrayCollection();
        }

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
         * @return Notification
         */
        public function setId($id)
        {
            $this->id = $id;

            return $this;
        }

        /**
         * @return \DateTime
         */
        public function getReportedAt()
        {
            return $this->reportedAt;
        }

        /**
         * @param mixed $reportedAt
         *
         * @return Notification
         */
        public function setReportedAt($reportedAt)
        {
            if (is_string($reportedAt))
            {
                $reportedAt = new \DateTime($reportedAt);
            }
            $this->reportedAt = $reportedAt;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getLevel()
        {
            return $this->level;
        }

        /**
         * @param mixed $level
         *
         * @return Notification
         */
        public function setLevel($level)
        {
            $this->level = $level;

            return $this;
        }

        public function getLevelLabel()
        {
            $labels = [];
            foreach ($this->levelLabels as $level => $label)
            {
                if ($level & $this->level) $labels[] = $label;
            }

            return implode(', ', $labels);
        }

        /**
         * @return mixed
         */
        public function getFlags()
        {
            return $this->flags;
        }

        /**
         * @param mixed $flags
         *
         * @return Notification
         */
        public function setFlags($flags)
        {
            $this->flags = $flags;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getNamespace()
        {
            return $this->namespace;
        }

        /**
         * @param mixed $namespace
         *
         * @return Notification
         */
        public function setNamespace($namespace)
        {
            $namespace       = $this->toSnakeCase($namespace, '-');
            $namespace       = '/' . trim($namespace, '/');
            $this->namespace = $namespace;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getMessage()
        {
            return $this->message;
        }

        /**
         * @param mixed $message
         *
         * @return Notification
         */
        public function setMessage($message)
        {
            $this->message = $message;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getBackTrace()
        {
            $backTrace = $this->backTrace;

            if (is_string($backTrace))
            {
                $backTrace = json_decode($backTrace, true);
            }

            return $backTrace;
        }

        /**
         * @param mixed $backTrace
         */
        public function setBackTrace($backTrace)
        {
            $this->backTrace = $backTrace;
        }

        /**
         * @return mixed
         */
        public function getUser()
        {
            return $this->user;
        }

        /**
         * @param mixed $user
         */
        public function setUser($user)
        {
            $this->user = $user;
        }

        /**
         * @return mixed
         */
        public function getServer()
        {
            return $this->server;
        }

        /**
         * @param mixed $server
         */
        public function setServer($server)
        {
            $this->server = $server;
        }

        /**
         * @return mixed
         */
        public function getCommand()
        {
            return $this->command;
        }

        /**
         * @param mixed $command
         */
        public function setCommand($command)
        {
            $this->command = $command;
        }

        /**
         * Return the appropriate label to describe the command depending on log origin
         */
        public function getCommandLabel()
        {
            return $this->origin == 'http' ? 'url' : 'command line';
        }

        /**
         * @return mixed
         */
        public function getOrigin()
        {
            return $this->origin;
        }

        /**
         * @param mixed $origin
         *
         * @return $this
         */
        public function setOrigin($origin)
        {
            if (!in_array($origin, ['http', 'cron', 'cli']))
            {
                throw new \InvalidArgumentException('NotificationEndpoint origin has to be either "http", "cron" or "cli"');
            }
            $this->origin = $origin;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getCategory()
        {
            return $this->category;
        }

        /**
         * @param mixed $category
         *
         * @return $this
         */
        public function setCategory($category)
        {
            $this->category = $category;

            return $this;
        }

        /**
         * @return array
         */
        public function getCategoryLabel()
        {
            $labels = [];
            foreach ($this->categoryLabels as $category => $label)
            {
                if ($category & $this->category) $labels[] = $label;
            }

            return implode(', ', $labels);
        }

        /**
         * @return mixed
         */
        public function getEnv()
        {
            return $this->env;
        }

        /**
         * @param mixed $env
         *
         * @return $this
         */
        public function setEnv($env)
        {
            $this->env = strtolower($env);

            return $this;
        }

        /**
         * @return ArrayCollection
         */
        public function getContext()
        {
            return $this->contexts;
        }

        public function setContext($context)
        {
            if(is_string($context))
            {
                $context = json_decode($context, JSON_OBJECT_AS_ARRAY);
            }


            if($context instanceof Context)
            {
                $context = array($context);
            }
            
            if($context instanceof \ArrayObject || is_array($context) || $context instanceof \Iterator)
            {
                foreach($context as $item)
                {
                    if(!$item instanceof Context)
                    {
                        $item = new Context($item);
                    }
                    
                    $item->setNotification($this);
                    $this->contexts->add($item);
                }
            }

            return $this;
        }
    }
