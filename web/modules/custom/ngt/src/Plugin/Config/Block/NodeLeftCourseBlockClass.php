<?php 

namespace Drupal\ngt\Plugin\Config\Block;

use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\ngt\Plugin\Block\NodeLeftCourseBlock;

/**
 * Manage config a 'NodeLeftCourseBlockClass' block
 */
class NodeLeftCourseBlockClass {
    protected $instance;
    protected $configuration;

    /**
     * @param \Drupal\ngt\Plugin\Block\NodeLeftCourseBlock $instance
     * @param $config
     */
    public function setConfig(NodeLeftCourseBlock &$instance, &$config){
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
     * @param \Drupal\ngt\Plugin\Block\NodeLeftCourseBlock $instance
     * @param $config
     */
    public function build(NodeLeftCourseBlock &$instance, $configuration){

        $build = [
            '#theme' => 'node_left_course',
            '#node' => 'hola',
        ];

        return $build;
    }

   

}