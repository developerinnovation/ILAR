<?php 

namespace Drupal\ngt_evaluation;

use Drupal\file\Entity\File;
use Drupal\rest\ResourceResponse;
use Drupal\user\Entity\User;
use Drupal\Core\Database\DatabaseExceptionWrapper;
use Drupal\ngt_evaluation\Entity\EvaluationLog;

class methodGeneralEvaluation{

    /**
     * Obtiene un registro desde el id
     * @param $id
     * @return entity EvaluationLog
     */
    public function getEvaluationById($id) {
        $evaluation = EvaluationLog::load($id);
        return $evaluation;
    }

    /**
     * registra el inicio de euna evaluación
     * @param $fields array
     * @return entity EvaluationLog
     */
    public function initEvaluation($fields = []) {

        $evaluation = EvaluationLog::create();
            foreach ($fields as $key => $value) {
            $evaluation->set($key, $value);
        }
        $evaluation->save();
        $id = ($evaluation) ? $evaluation->Id() : NULL;

        if($id != NULL){
            return [
                'status' => '200',
                'id' => $id,
            ];
        }
        return [
            'status' => '500',
        ];
    }
    
    /**
     * Actualiza los datos de la evaluación
     * @param $id
     * @param $fields array
     * @return entity EvaluationLog
     */
    public function updateDataTransaction($id, $fields = []) {
        $evaluation = EvaluationLog::load($id);
            foreach ($fields as $key => $value) {
            $evaluation->set($key, $value);
        }
        $evaluation->save();
        return $evaluation->Id();
    }



}