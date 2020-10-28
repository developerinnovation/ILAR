<?php 

namespace Drupal\ngt_general\Plugin\Config\Block;

use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\ngt_general\Plugin\Block\NodeTopLessonBlock;
use Drupal\media\Entity\Media;
use Drupal\Core\Url;
use Drupal\image\Entity\ImageStyle;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Manage config a 'NodeTopLessonBlockClass' block
 */
class NodeTopLessonBlockClass {
    protected $instance;
    protected $configuration;

    /**
     * @param \Drupal\ngt_general\Plugin\Block\NodeTopLessonBlock $instance
     * @param $config
     */
    public function setConfig(NodeTopLessonBlock &$instance, &$config){
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
     * @param \Drupal\ngt_general\Plugin\Block\NodeTopLessonBlock $instance
     * @param $config
     */
    public function build(NodeTopLessonBlock &$instance, $configuration){
        $nid = $configuration['node'];
        $node = \Drupal\node\Entity\Node::loadMultiple(array($nid));

        $build = [
            '#theme' => 'node_top_lesson',
            '#data' => $this->preparerate($node),
        ];

        return $build;
    }

        
    /**
     * preparerate
     *
     * @param  array $node
     * @return array
     */
    public function preparerate($nodes){
        $lessons = [];
        
        foreach ($nodes as $node) {
            $resource = isset($node->get('field_recursos')->getValue()[0]['target_id']) ? \Drupal::service('ngt_general.methodGeneral')->load_resource($node->get('field_recursos')->getValue()) : null;
            $lesson = [
                'nid' => $node->get('nid')->getValue()[0]['value'],
                'title' => $node->get('title')->getValue()[0]['value'],
                'expertos' => \Drupal::service('ngt_general.methodGeneral')->load_author($node->get('field_docente')->getValue()),
                'nextLesson' => '#',
                'prevLesson' => '#',
                'module' => 'M1 ¿Cómo iniciar un estuduio?',
                'courseTitle' => '',
                'courseResume' => 'Officia tempor nisi aliqua dolore est fugiat incididunt incididunt voluptate elit do ut dolor.',
            ];
            array_push($lessons,$lesson);
        }
        return $lessons;
    }

}