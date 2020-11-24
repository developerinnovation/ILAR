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
    public function get() {
        // Remove cache.
        \Drupal::service('page_cache_kill_switch')->trigger();
        $data = [];
       

        return new ModifiedResourceResponse($data);
    }

    /**
     * @return \Drupal\rest\ResourceResponse
     */
    public function post($params) {
        // Remove cache.
        \Drupal::service('page_cache_kill_switch')->trigger();
        $data = [];
       

        return new ResourceResponse($data);
    }
  
    /**
     * @return \Drupal\rest\ResourceResponse
     */
    public function update($params) {
        // Remove cache.
        \Drupal::service('page_cache_kill_switch')->trigger();
        $data = [];
       

        return new JsonResponse($data);
    }
}