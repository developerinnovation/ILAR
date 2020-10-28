<?php 

namespace Drupal\ngt_general\Plugin\Config\Block;

use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\ngt_general\Plugin\Block\NodeLessonModulesBlock;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Manage config a 'NodeLessonModulesBlockClass' block
 */
class NodeLessonModulesBlockClass {
    protected $instance;
    protected $configuration;

    /**
     * @param \Drupal\ngt_general\Plugin\Block\NodeLessonModulesBlock $instance
     * @param $config
     */
    public function setConfig(NodeLessonModulesBlock &$instance, &$config){
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
     * @param \Drupal\ngt_general\Plugin\Block\NodeLessonModulesBlock $instance
     * @param $config
     */
    public function build(NodeLessonModulesBlock &$instance, $configuration){
        $this->configuration = $configuration;
        $instance->setValue('config_name', 'NodeLessonModulesBlock');
        $instance->setValue('class', 'block-node-lesson-modules');
        $uuid = $instance->uuid('block-node-lesson-modules');
        $instance->setValue('directive', 'data-ng-node-lesson-modules');
        $this->instance->setValue('dataAngular', 'node-lesson-modules-' . $uuid);

        // $nid = $configuration['node'];
        // $node = \Drupal\node\Entity\Node::loadMultiple(array($nid));

        $parameters = [
            'theme' => 'node_lesson_modules',
            'library' => 'ngt_general/node-lesson-modules',
        ];

        $others = [
            '#dataAngular' => $this->instance->getValue('dataAngular'),
            '#data' => [],
            '#uuid' => $uuid,
        ];

        $other_config = [
        ];

        $config_block = $instance->cardBuildConfigBlock(NULL, $other_config);
        $instance->cardBuilVarBuild($parameters, $others);
        $instance->cardBuildAddConfigDirective($config_block);

        
        return $instance->getValue('build');
    }

}