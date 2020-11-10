<?php 

namespace Drupal\ngt_inscription\Services\Rest;

use Drupal\rest\ResourceResponse;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\rest\ModifiedResourceResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\user\Entity\User;

/**
 * Class class UnInscriptionRestLogic.
 *
 * @package Drupal\ngt_inscription
 */
class UnInscriptionRestLogic {

    /**
     * @method PUT
     * function used for receive data from apiari
     *
     * Calls delete method.
     *
     * @param \Drupal\Core\Session\AccountProxyInterface $currentUser
     *   current User.
     * 
     * @param array $params
     *   Data of directive for to know the payment status.
     *
     * @return JsonResponse
     *   Return Json Code.
     * @throws \Exception
     */
    public function delete(AccountProxyInterface $currentUser, array $params) {
        \Drupal::service('page_cache_kill_switch')->trigger();
        $this->currentUser = $currentUser;
        if (!$this->currentUser->hasPermission('access content')) {
            throw new AccessDeniedHttpException();
        }

        $return = \Drupal::service('ngt_inscription.method_general')->deleteReserve($currentUser, $params);
        return new JsonResponse($return, 200);
    }
  
}