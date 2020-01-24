<?php
namespace OCA\SingleLogout\Hooks;

use \OCP\IConfig;

class UserHooks {

    private $config;

    private $userManager;

    private $logger;

    public function __construct($config, $userManager, $logger) {
        $this->config = $config;
        $this->userManager = $userManager;
        $this->logger = $logger;
    }

    public function register() {
        $callback = function() {
            $url = $this->getRedirectUrl();

            $this->logger->info('Redirecting to '.$url);
            header('Location: '.$url);
            exit;
        };
        $this->userManager->listen('\OC\User', 'postLogout', $callback);
    }

    public function getRedirectUrl() {
        return $this->config->getSystemValue('single_logout_redirect_url');
    }
}
