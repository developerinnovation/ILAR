<?php 

namespace Drupal\ngt_general\Plugin\Config\Block;

use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\ngt_general\Plugin\Block\NodeRightCourseBlock;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Manage config a 'NodeRightCourseBlockClass' block
 */
class NodeRightCourseBlockClass {
    protected $instance;
    protected $configuration;

    /**
     * @param \Drupal\ngt_general\Plugin\Block\NodeRightCourseBlock $instance
     * @param $config
     */
    public function setConfig(NodeRightCourseBlock &$instance, &$config){
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
     * @param \Drupal\ngt_general\Plugin\Block\NodeRightCourseBlock $instance
     * @param $config
     */
    public function build(NodeRightCourseBlock &$instance, $configuration){
        $this->configuration = $configuration;
        $instance->setValue('config_name', 'NodeRightCourseBlock');
        $instance->setValue('class', 'block-node-right-course');
        $uuid = $instance->uuid('block-node-right-course');
        $instance->setValue('directive', 'data-ng-node-right-course');
        $this->instance->setValue('dataAngular', 'node-right-course-' . $uuid);

        $nid = $configuration['node'];
        $node = \Drupal\node\Entity\Node::loadMultiple(array($nid));

        $parameters = [
            'theme' => 'node_right_course',
            'library' => 'ngt_general/node-right-course',
        ];

        $others = [
            '#dataAngular' => $this->instance->getValue('dataAngular'),
            '#data' => $this->preparerate($node),
            '#uuid' => $uuid,
        ];

        $other_config = [
        ];

        $config_block = $instance->cardBuildConfigBlock(NULL, $other_config);
        $instance->cardBuilVarBuild($parameters, $others);
        $instance->cardBuildAddConfigDirective($config_block);

        
        return $instance->getValue('build');
    }

      /**
     * preparerate
     *
     * @param  array $node
     * @return array
     */
    public function preparerate($nodes){
        $courses = [];
        
        foreach ($nodes as $node) {
            $date = new DrupalDateTime($node->get('field_fecha_de_inicio')->getValue()[0]['value']);
            $formatted_date = \Drupal::service('date.formatter')->format($date->getTimestamp(), 'custom', 'M d, Y');
            $modules = isset($node->field_modulo->getValue()[0]['target_id']) ? \Drupal::service('ngt_general.methodGeneral')->load_module_course($node->field_modulo->getValue()): NULL;
            $course = [
                'nid' => $node->get('nid')->getValue()[0]['value'],
                'body' => isset($node->get('body')->getValue()[0]['value']) ? $node->get('body')->getValue()[0]['value'] : '',
                'resume' => isset($node->get('field_resumen')->getValue()[0]['value']) ? $node->get('field_resumen')->getValue()[0]['value'] : '',
                'autor' => \Drupal::service('ngt_general.methodGeneral')->load_author($node->get('field_autor_principal')->getValue()),
                'expertos' => \Drupal::service('ngt_general.methodGeneral')->load_author($node->get('field_expertos')->getValue()),
                'foto_portada' => [
                    'uri' => \Drupal::service('ngt_general.methodGeneral')->load_image($node->get('field_foto_portada')->getValue()[0]['target_id']),
                    'uri_360x196' => \Drupal::service('ngt_general.methodGeneral')->load_image($node->get('field_foto_portada')->getValue()[0]['target_id'],'360x196'),
                    'uri_604x476' => \Drupal::service('ngt_general.methodGeneral')->load_image($node->get('field_foto_portada')->getValue()[0]['target_id'],'604x476'),
                    'target_id' => $node->get('field_foto_portada')->getValue()[0]['target_id'],
                    'alt' => isset($node->get('field_foto_portada')->getValue()[0]['value']) ? $node->get('field_foto_portada')->getValue()[0]['alt'] : '',
                    'title' => isset($node->get('field_foto_portada')->getValue()[0]['value']) ? $node->get('field_foto_portada')->getValue()[0]['title'] : '',
                    'width' => $node->get('field_foto_portada')->getValue()[0]['width'],
                    'height' => $node->get('field_foto_portada')->getValue()[0]['height'],
                ],
                'video' => \Drupal::service('ngt_general.methodGeneral')->load_url_file($node->get('field_video')->getValue()[0]['target_id']),
                'modules' => $modules,
            ];
            array_push($courses,$course);
        }
        return $courses;
    }

}