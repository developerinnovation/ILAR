<?php 

namespace Drupal\ngt\Plugin\Config\Block;

use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\ngt\Plugin\Block\CourseCategoryBlock;

/**
 * Manage config a 'CourseCategoryBlockClass' block
 */
class CourseCategoryBlockClass {
    protected $instance;
    protected $configuration;

    /**
     * @param \Drupal\ngt\Plugin\Block\CourseCategoryBlock $instance
     * @param $config
     */
    public function setConfig(CourseCategoryBlock &$instance, &$config){
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
     * @param \Drupal\ngt\Plugin\Block\CourseCategoryBlock $instance
     * @param $config
     */
    public function build(CourseCategoryBlock &$instance, $configuration){

        $build = [
            '#theme' => 'course_category',
        ];

        return $build;
    }

}