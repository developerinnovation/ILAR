<?php 

namespace Drupal\ngt_login;

use Drupal\file\Entity\File;
use Drupal\rest\ResourceResponse;
use Drupal\user\Entity\User;

class methodGeneralLogin{

  /**
     * validateUserByMail
     *
     * @param  mixed $mail
     * @return void
     */
    public function validateUserByMail($mail){
        \Drupal::service('page_cache_kill_switch')->trigger();
        $user = user_load_by_mail($mail);
        $conf = \Drupal::config('ngt_login.settings');
        if($user){
            $message = $conf->get('ngt_forgot_password')['code_send'];
            $dataTmpStore = $this->createKeyDinamic($mail, $user);
            $data = [
                'status' => '200',
                'message' => $message,
            ];
        }else{
            $message = $conf->get('ngt_forgot_password')['error_code_send'];
            $data = [
                'status' => '500',
                'message' => $message,
            ];
        }
        return $data;
    }
    
    /**
     * createKeyDinamic
     * 
     * Permite generar un cóodigo de 6 cifras
     *
     * @return void
     */
    public function createKeyDinamic($mail, $user = NULL){
        $tokens = [];
        mt_srand(time());
        $mt_rand = mt_rand(100000,50000000);
        $keyDinamic = substr($mt_rand, '4', '3').substr($mt_rand, '2', '3');
        $this->saveTmpStore($mail, $keyDinamic);
        $data = [
            'code' => $keyDinamic,
            'mail' => $mail,
        ];
        $tokens['code'] = $keyDinamic;
        $template = 'notification_get_code';
        \Drupal::service('ngt.send')->send_notification($tokens, $template, $user);
        return $data;
    }

    
    /**
     * saveTmpStore
     *
     * @param  mixed $mail
     * @param  mixed $keyDinamic
     * @return void
     */
    public function saveTmpStore($mail, $keyDinamic){
        $keyTmpStore = sha1($keyDinamic.$mail);
        $tmpStore = \Drupal::service('tempstore.shared')->get('ngt_general.keyDinamic');
        $dataToSave = [
            'hash' => $keyTmpStore,
            'mail' => $mail,
            'keyDinamic' => $keyDinamic,
        ];
        $dataToSaveJson = json_encode($dataToSave);
        $tmpStore->set($keyTmpStore, $dataToSaveJson);
    }
    
    /**
     * verifyCode
     *
     * @param  mixed $mail
     * @param  mixed $keyDinamic
     * @return void
     */
    public function verifyCode($mail, $keyDinamic, $clearCode = false){
        \Drupal::service('page_cache_kill_switch')->trigger();
        $dataTmpStore = null;
        $keyTmpStore = sha1($keyDinamic.$mail);
        $conf = \Drupal::config('ngt_login.settings');
        $message_error = $conf->get('ngt_forgot_password')['error_code'];
        if($keyTmpStore){
            $tmpStore = \Drupal::service('tempstore.shared')->get('ngt_general.keyDinamic');
            $dataTmpStore = (array)json_decode($tmpStore->get($keyTmpStore));
            if($dataTmpStore != null){
                if ($clearCode){
                    $tmpStore->delete($keyTmpStore);
                }
                $data = [
                    'status' => '200',
                    'data' => $dataTmpStore,
                ];
            }else{
                $data = [
                    'status' => '500',
                    'message' => $message_error, 
                ];
            }
            return $data;
        }
        
        
        
        $data = [
            'status' => '500',
            'message' => $message_error, 
        ];
        
        return $data;
    }
    
    /**
     * setNewPass
     *
     * @param  mixed $mail
     * @param  mixed $key_dinamic
     * @param  mixed $pass
     * @return void
     */
    public function setNewPass($mail, $key_dinamic, $pass){
        \Drupal::service('page_cache_kill_switch')->trigger();
        $user = user_load_by_mail($mail);

        if($user){
            $verifyCode = $this->verifyCode($mail, $key_dinamic, true);
            if($verifyCode['status'] == '200'){
                $user->setPassword($pass);
                $user->save();
                $data = [
                    'status' => '200',
                ];
            }else{
                $data = [
                    'status' => '500', 
                ];
            }
        }else{
            $data = [
                'status' => '500', 
            ];
        }
        return $data;
    }

}