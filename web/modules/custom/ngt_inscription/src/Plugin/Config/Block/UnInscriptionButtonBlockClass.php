<?php 

namespace Drupal\ngt_inscription\Plugin\Config\Block;

use Drupal\ngt_inscription\Plugin\Block\UnInscriptionButtonBlock;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\file\Entity\File;



/**
 * Manage config a 'UnInscriptionButtonBlockClass' block
 */
class UnInscriptionButtonBlockClass {
    protected $instance;
    protected $configuration;

    /**
     * @param \Drupal\ngt_inscription\Plugin\Block\UnInscriptionButtonBlock $instance
     * @param $config
     */
    public function setConfig(UnInscriptionButtonBlock &$instance, &$config){
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
     * @param \Drupal\ngt_inscription\Plugin\Block\UnInscriptionButtonBlock $instance
     * @param $config
     */
    public function build(UnInscriptionButtonBlock &$instance, $configuration){
        $this->configuration = $configuration;
        $instance->setValue('config_name', 'UnInscriptionButtonBlock');
        $instance->setValue('class', 'block-uninscription-button');
        $uuid = $instance->uuid('block-uninscription-button');
        $instance->setValue('directive', 'data-ng-uninscription-button');
        $this->instance->setValue('dataAngular', 'uninscription-button-' . $uuid);

       
        $parameters = [
            'theme' => 'inscriptiion_button',
            'library' => 'ngt_inscription/uninscription-button',
        ];

        $others = [
            '#dataAngular' => $this->instance->getValue('dataAngular'),
          
            '#config' => '',
            '#uuid' => $uuid,
        ];

        $other_config = [
            'pathReserve' => '/ngt/api/v1/uninscription/reserve',
        ];

        $config_block = $instance->cardBuildConfigBlock(NULL, $other_config);
        $instance->cardBuilVarBuild($parameters, $others);
        $instance->cardBuildAddConfigDirective($config_block);

        
        return $instance->getValue('build');
    }

    /**
     * {@inheritdoc}
     */
    public function blockAccess(AccountInterface $account){
        if ($account->isAnonymous()) {
            return AccessResult::allowed();
        }
        return AccessResult::forbidden();
    }

}