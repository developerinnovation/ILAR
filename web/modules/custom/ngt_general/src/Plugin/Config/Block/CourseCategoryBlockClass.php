<?php 

namespace Drupal\ngt_general\Plugin\Config\Block;

use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\ngt_general\Plugin\Block\CourseCategoryBlock;

/**
 * Manage config a 'CourseCategoryBlockClass' block
 */
class CourseCategoryBlockClass {
    protected $instance;
    protected $configuration;

    /**
     * @param \Drupal\ngt_general\Plugin\Block\CourseCategoryBlock $instance
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
     * @param \Drupal\ngt_general\Plugin\Block\CourseCategoryBlock $instance
     * @param $config
     */
    public function build(CourseCategoryBlock &$instance, $configuration){

        $build = [
            '#theme' => 'course_category',
            '#main_category' => \Drupal::config('ngt_general.adminSettingsCategory')->getRawData(),
        ];

        return $build;
    }

}