<?php
namespace OCA\SingleLogout\AppInfo;

use \OCP\AppFramework\App;
use \OCA\SingleLogout\Hooks\UserHooks;

class Application extends App {

    public function __construct(array $urlParams = array()) {

        parent::__construct('singlelogout', $urlParams);

        $container = $this->getContainer();

        /**
         * Hooks
         */
        $container->registerService('UserHooks', function($c) {
            return new UserHooks(
                $c->query('Config'),
                $c->query('UserManager'),
                $c->query('Logger')
            );
        });

        $container->registerService('Config', function($c) {
            return $c->query('ServerContainer')->getConfig();
        });

        $container->registerService('UserManager', function($c) {
            return $c->query('ServerContainer')->getUserManager();
        });

        $container->registerService('Logger', function($c) {
            return $c->query('ServerContainer')->getLogger();
        });
    }
}

$app = new Application();
$app->getContainer()->query('UserHooks')->register();
