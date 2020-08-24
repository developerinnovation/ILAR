<?php 

namespace Drupal\reserver_now\Plugin\Config\Block;

use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\reserver_now\Plugin\Block\ReserverNowBlock;

/**
 * Manage config a 'ReserverNowBlockClass' block
 */
class ReserverNowBlockClass {
    protected $instance;
    protected $configuration;

    /**
     * @param \Drupal\reserver_now\Plugin\Block\ReserverNowBlock $instance
     * @param $config
     */
    public function setConfig(ReserverNowBlock &$instance, &$config){
        $this->instance = &$instance;
        $this->configuration = &$config;
    }

    /**
     * {@inheritdoc}
     */
    public function defaultConfiguration() {
        return [];
    }

    /**
     * @param \Drupal\reserver_now\Plugin\Block\ReserverNowBlock $instance
     * @param $config
     */
    public function build(ReserverNowBlock &$instance, $configuration){
        $config = \Drupal::config('reserver_now.settings'); 
        
        $parameters = [
            'theme' => 'reserver_now',
            'library' => 'reserver_now/reserver-now-course',
        ];

        // data to send theme
        $others = [
            '#uuid' => '',
            '#path_module' => '/'.drupal_get_path('module','reserver_now'),
        ];

        // data to send angular 
        $other_config = [
            'urlrestReserverNow' => '/ngt/reserver_now/course?_format=json',
        ];

        $config_block = $instance->cardBuildConfigBlock('/ngt/reserver_now/course?_format=json', $other_config);
        $instance->cardBuildVarBuild($parameters, $others);
        $instance->cardBuilAddConfigDirective($config_block);

        return $instance->getValue('build');
    }



}