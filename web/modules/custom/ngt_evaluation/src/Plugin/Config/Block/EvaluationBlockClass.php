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

        $nid = $configuration['node'];
        $node = \Drupal\node\Entity\Node::load($nid);

        $parameters = [
            'theme' => 'evaluation_form',
            'library' => 'ngt_evaluation/evaluation-form',
        ];

        $data = $this->preparate_data($node);

        $others = [
            '#dataAngular' => $this->instance->getValue('dataAngular'),
            '#data' => $data,
            '#uuid' => $uuid,
        ];

        $other_config = [
            'urlCourse' => '',
            'total_questions' => $data['count_question'],
            'minute' => $data['minute'],
            'nid' => $nid,
        ];

        $config_block = $instance->cardBuildConfigBlock(NULL, $other_config);
        $instance->cardBuilVarBuild($parameters, $others);
        $instance->cardBuildAddConfigDirective($config_block);

        
        return $instance->getValue('build');
    }

    public function preparate_data($node){

        $questions = isset($node->get('field_pregunta')->getValue()[0]['target_id']) ? $this->load_questions($node->get('field_pregunta')->getValue()): NULL;

        $data = [
            'title' => $node->get('title')->getValue()[0]['value'],
            'nid' => $node->get('nid')->getValue()[0]['value'],
            'body' => isset($node->get('body')->getValue()[0]['value']) ? $node->get('body')->getValue()[0]['value'] : '',
            'minute' => isset($node->get('field_minutos')->getValue()[0]['value']) ? $node->get('field_minutos')->getValue()[0]['value'] : '',
            'average' => isset($node->get('field_porcentaje_aprobacion')->getValue()[0]['value']) ? $node->get('field_porcentaje_aprobacion')->getValue()[0]['value'] : '',
            'questions' => $questions,
            'count_question' => count($questions),
        ];

        return $data;
    }

     /**
     * load_questions
     *
     * @param  mixed $paragraph
     * @return void
     */
    public function load_questions($paragraph){
        $questions = [];
        $paragraphArray = $paragraph;
        foreach ( $paragraphArray as $element ) {
            $question = \Drupal\paragraphs\Entity\Paragraph::load( $element['target_id'] );
            array_push($questions, [
                'nidCourse' => $question->get('parent_id')->getValue()[0]['value'],
                'title' => $question->get('field_titulo_pregunta')->getValue()[0]['value'],
                'type' => $question->get('field_tipo_de_pregunta')->getValue()[0]['value'],
                'answer' => $question->get('field_respuesta_correcta')->getValue()[0]['value'],
                'possibleAnswers' => $question->get('field_posibles_respuestas')->getValue(),
            ]);
        }
        return $questions;
    }

}