<?php 

namespace Drupal\ngt_inscription;

use Drupal\file\Entity\File;
use Drupal\rest\ResourceResponse;
use Drupal\user\Entity\User;
use Drupal\Core\Database\DatabaseExceptionWrapper;
use Drupal\ngt_inscription\Entity\InscriptionLog;

class methodGeneralInscription{

    /**
     * Obtiene un registro desde el id
     * @param $id
     * @return entity InscriptionLog
     */
    public function getinscripctionById($id) {
        $inscripction = InscriptionLog::load($id);
        return $inscripction;
    }

    /**
     * registra una nueva reserva
     * @param $user_id
     * @param $node_id
     * @return $id
     */
    public function initReserve($user_id, $node_id) {

        $inscripction = InscriptionLog::create();
        $inscripction->set('node_id', $node_id);
        $inscripction->set('user_id', \Drupal::currentUser()->Id());
        $inscripction->save();
        $id = ($inscripction) ? $inscripction->Id() : NULL;

        return $id;
    }

    /**
     * elimina una reserva
     * @param $user_id
     * @param $node_id
     * @return bool
     */
    public function deleteReserve($user_id, $node_id){

        $query = \Drupal::database()->delete('ngt_inscription_log');
        $query->condition('user_id', $user_id);
        $query->condition('node_id', $node_id);
        $result = $query->execute();

        if($result){
            return [
                'status' => '200',
            ];
        }

        return [
            'status' => '500',
        ];

    }



}