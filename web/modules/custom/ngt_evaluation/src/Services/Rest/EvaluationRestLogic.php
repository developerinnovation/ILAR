<?php 

namespace Drupal\ngt_evaluation\Services\Rest;

use Drupal\rest\ResourceResponse;
use Drupal\rest\ModifiedResourceResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class class EvaluationRestLogic.
 *
 * @package Drupal\ngt_evaluation
 */
class EvaluationRestLogic {


    /**
     * @return \Drupal\rest\ResourceResponse
     */
    public function post($params) {
        // Remove cache.
        \Drupal::service('page_cache_kill_switch')->trigger();
        $data = [];
       
        $fields = [
            'user_id' =>  \Drupal::currentUser()->Id(),
            'node_id' => $params['nid'],
            'module_id' => $params['moduleId'],
            'type_evaluation' => $params['module'],
            'attempts' => $params['1'],
            'total_question' => $params['maxNavValue'],
        ];

        \Drupal::service('ngt_evaluation.method_general')->initEvaluation($fields);

        return new ResourceResponse($data);
    }
  
    /**
     * @return \Drupal\rest\ResourceResponse
     */
    public function put($params) {
        // Remove cache.
        \Drupal::service('page_cache_kill_switch')->trigger();
        
        \Drupal::service('ngt_evaluation.method_general')->updateDataTransaction($id, $fields);

        return new JsonResponse($data);
    }
}