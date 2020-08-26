<?php

namespace Drupal\ngt_notification\Plugin\Config\Form;

use Drupal\fiel\Entity\File;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


class notificationSettingsFormClass {
    
    /**  
     * {@inheritdoc}  
     */  
    protected function getEditableConfigNames() {  
        return [  
            'ngt_notification.notificationSettingsForm',  
        ];  
    }  

    /**
     * getFormId
     *
     */
    public function getFormId(){
        return 'ngt_notification_settings_form';
    }


    /**
     * validateForm
     *
     * @param  mixed $form
     * @param  mixed $form_state
     */
    public function validateForm(array &$form, FormStateInterface $form_state){
        parent::validateForm($form, $form_state);
    }

    /**
     * @param string $fid
     *   File id.
     */
    public function setFileAsPermanent($fid) {
        if (is_array($fid)) {
            $fid = array_shift($fid);
        }

        $file = \Drupal\file\Entity\File::load($fid);
        if (!is_object($file)) {
            return;
        }

        $file->setPermanent();
        $file->save();
        \Drupal::service('file.usage')->add($file, 'ngt_notification', 'ngt_notification', $fid);
    }
    
    /**
     * submitForm
     *
     * @param  mixed $form
     * @param  mixed $form_state
     */
    public function submitForm(array &$form, FormStateInterface $form_state){

        $fid = $form_state->getValue('images')['logo'];
        if($fid){
            $this->setFileAsPermanent($fid);
        }
        
        $config = \Drupal::configFactory()->getEditable('ngt_notification.settings');
        $config
            ->set('images', $form_state->getValue('images'))
            ->set('new_user', $form_state->getValue('new_user'))
            ->save();
    }
    
    /**
     * buildForm
     *
     * @param  mixed $form
     * @param  mixed $form_state
     */
    public function buildForm(array $form, FormStateInterface $form_state){
        $config = \Drupal::config('ngt_notification.settings');

        $form['images'] = [
            '#type' => 'details',
            '#title' => t('Images'),
            '#open' => FALSE,
        ];

        $form['images']['logo'] = [
            '#type' => 'managed_file',
            '#title' => t('Logo'),
            '#upload_location' => 's3://file-project',
            '#upload_validators' => [
                'file_validate_extensions' => ['png svg jpg jpeg']
            ],
            '#default_value' => $config->get('images')['logo'],
            '#description' => t('Logo general para correos'),
        ];

        $form['new_user'] = [
            '#type' => 'details',
            '#title' => t('Template para notificar la creación de un nuevo usuario'),
            '#open' => FALSE,
        ];

        $form['new_user']['subject'] = [
            '#type' => 'textfield',
            '#maxlength' => 180,
            '#title' => t('Asunto'),
            '#default_value' => isset($config->get('new_user')['subject']) ? $config->get('new_user')['subject'] : t('Creación de nuevo usuario'),
        ];

        $form['new_user']['body'] = [
            '#type' => 'text_format',
            '#title' => t('Body'),
            '#format' => 'full_html',
            '#default_value' => $config->get('new_user')['body']['value'],
            '#description' => t('Mensaje en formato HTMl.'),
        ];


        return $form;
    }
    
    

}