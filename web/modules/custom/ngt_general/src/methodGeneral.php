<?php 

namespace Drupal\ngt_general;

use Drupal\file\Entity\File;
use Drupal\rest\ResourceResponse;
use Drupal\user\Entity\User;

class methodGeneral{
   
   
    /**
     * @param string $fid
     *   File id.
     */
    public function setFileAsPermanent($fid) {
        \Drupal::service('page_cache_kill_switch')->trigger();
        if (is_array($fid)) {
            $fid = array_shift($fid);
        }

        $file = File::load($fid);
        if (!is_object($file)) {
            return;
        }

        $file->setPermanent();
        $file->save();
        \Drupal::service('file.usage')->add($file, 'ngt', 'ngt', $fid);
    }

        
    /**
     * renderLogo
     *
     * @return void
     */
    public function renderLogo(){
        \Drupal::service('page_cache_kill_switch')->trigger();
        // build uri logo
        $logo = [
            'image_src_general_settings_logo' => '',
            'image_src_img_second_logo' => '',
            'activated_second_logo' => false,
        ];

        $image_src_general_settings_logo = '';
        $image_src_img_second_logo = '';

        $conf = \Drupal::config('ngt_general.settings');
        $img_general_settings_logo = $conf->get('general_settings')['img_logo'];
        $img_second_logo = $conf->get('general_settings')['img_logo_second'];
        $activate_img_logo_second = $conf->get('general_settings')['activate_img_logo_second'];

        $logo['activated_second_logo'] = $activate_img_logo_second == true ? true : false;
        
        if ( is_array($img_general_settings_logo) ) {
            $fid = reset($img_general_settings_logo);  
            $file = File::load($fid);
            isset($file) ? $logo['general_settings_logo'] = $file->getFileUri() : '';
        }

        if ( is_array($img_second_logo) ) {
            $fid = reset($img_second_logo);  
            $file = File::load($fid);
            isset($file) ? $logo['second_logo'] = $file->getFileUri() : '';
        }
        
        return $logo;
    }
    
    /**
     * validateUserByMail
     *
     * @param  mixed $mail
     * @return void
     */
    public function validateUserByMail($mail){
        $user = user_load_by_mail($mail);
        if($user){
            $dataTmpStore = $this->createKeyDinamic($mail);
            $data = [
                'status' => 200,
                'data' => $dataTmpStore,
                'message' => t(''), // llamar desde la config de módulo login
            ];
        }else{
            $data = [
                'status' => 500,
                'message' => t(''), // llamar desde la config de módulo login
            ];
        }
        return new ResourceResponse($data);
    }
    
    /**
     * createKeyDinamic
     * 
     * Permite generar un cóodigo de 6 cifras
     *
     * @return void
     */
    public function createKeyDinamic($mail){
        \Drupal::service('page_cache_kill_switch')->trigger();
        mt_srand(time());
        $mt_rand = mt_rand(4,5000000);
        $keyDinamic = substr($mt_rand, '4', '3').substr($mt_rand, '2', '3');
        $this->saveTmpStore($mail, $keyDinamic);
        $data = [
            'code' => $keyDinamic,
            'mail' => $mail,
        ];
        return $data;
    }


    public function saveTmpStore($mail, $keyDinamic){
        \Drupal::service('page_cache_kill_switch')->trigger();
        $keyTmpStore = sha1($keyDinamic.$mail);
        $tmpStore = \Drupal::service('tempstore.shred')->get('ngt_general.keyDinamic');
        $dataToSave = [
            'hash' => $keyTmpStore,
            'mail' => $mail,
            'keyDinamic' => $keyDinamic,
        ];
        $dataToSaveJson = json_encode($dataToSave);
        $tmpStore->setIfNotExists($keyTmpStore, $dataToSaveJson);
    }

    public function getTmpStore($mail, $keyDinamic){
        \Drupal::service('page_cache_kill_switch')->trigger();
        $dataTmpStore = null;
        $keyTmpStore = sha1($keyDinamic.$mail);
        $tmpStore = \Drupal::service('tempstore.shred')->get('ngt_general.keyDinamic');
        $dataTmpStore = (array)json_decode($tmpStore->get($keyTmpStore));
        $tmpStore->delete($keyTmpStore);
        if($dataTmpStore != null){
            $data = [
                'status' => 200,
                'data' => $dataTmpStore,
            ];
        }else{
            $data = [
                'status' => 500,
            ];
        }
        return new ResourceResponse($data);
    }

}