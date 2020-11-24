<?php 

namespace Drupal\ngt_evaluation\Plugin\Config\Block;

use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\ngt_evaluation\Plugin\Block\EvaluationBlock;

/**
 * Manage config a 'EvaluationBlockClass' block
 */
class EvaluationBlockClass {
    protected $instance;
    protected $configuration;

    /**
     * @param \Drupal\ngt_evaluation\Plugin\Block\EvaluationBlock $instance
     * @param $config
     */
    public function setConfig(EvaluationBlock &$instance, &$config){
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
     * @param \Drupal\ngt_evaluation\Plugin\Block\EvaluationBlock $instance
     * @param $config
     */
    public function build(EvaluationBlock &$instance, $configuration){
        $this->configuration = $configuration;
        $instance->setValue('config_name', 'EvaluationBlock');
        $instance->setValue('class', 'block-evaluation');
        $uuid = $instance->uuid('block-evaluation');
        $instance->setValue('directive', 'data-ng-evaluation');
        $this->instance->setValue('dataAngular', 'evaluation-' . $uuid);

        // $nid = $configuration['node'];
        // $node = \Drupal\node\Entity\Node::loadMultiple(array($nid));

        $parameters = [
            'theme' => 'evaluation_form',
            'library' => 'ngt_evaluation/evaluation-form',
        ];

        $others = [
            '#dataAngular' => $this->instance->getValue('dataAngular'),
            '#data' => NULL,
            '#uuid' => $uuid,
        ];

        $other_config = [
            'urlCourse' => '',
        ];

        $config_block = $instance->cardBuildConfigBlock(NULL, $other_config);
        $instance->cardBuilVarBuild($parameters, $others);
        $instance->cardBuildAddConfigDirective($config_block);

        
        return $instance->getValue('build');
    }

}