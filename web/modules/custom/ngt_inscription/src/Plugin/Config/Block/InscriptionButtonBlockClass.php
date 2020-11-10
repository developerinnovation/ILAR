<?php 

namespace Drupal\ngt_inscription\Plugin\Config\Block;

use Drupal\ngt_inscription\Plugin\Block\InscriptionButtonBlock;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\file\Entity\File;



/**
 * Manage config a 'InscriptionButtonBlockClass' block
 */
class InscriptionButtonBlockClass {
    protected $instance;
    protected $configuration;

    /**
     * @param \Drupal\ngt_inscription\Plugin\Block\InscriptionButtonBlock $instance
     * @param $config
     */
    public function setConfig(InscriptionButtonBlock &$instance, &$config){
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
     * @param \Drupal\ngt_inscription\Plugin\Block\InscriptionButtonBlock $instance
     * @param $config
     */
    public function build(InscriptionButtonBlock &$instance, $configuration){
        $this->configuration = $configuration;
        $instance->setValue('config_name', 'InscriptionButtonBlock');
        $instance->setValue('class', 'block-inscription-button');
        $uuid = $instance->uuid('block-inscription-button');
        $instance->setValue('directive', 'data-ng-inscription-button');
        $this->instance->setValue('dataAngular', 'inscription-button-' . $uuid);

       
        $parameters = [
            'theme' => 'inscriptiion_button',
            'library' => 'ngt_inscription/inscription-button',
        ];

        $others = [
            '#dataAngular' => $this->instance->getValue('dataAngular'),
          
            '#config' => '',
            '#uuid' => $uuid,
        ];

        $other_config = [
            'pathReserve' => '/ngt/api/v1/inscription/reserve',
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