<?php 

namespace Drupal\ngt\Plugin\Config\Form;

use Drupal\Core\Form\FormStateInterface;

class GeneralConfigFormClass{
    /**  
     * {@inheritdoc}  
     */  
    protected function getEditableConfigNames() {  
        return [  
            'ngt.adminSettingsGeneral',  
        ];  
    }  

    /**  
     * {@inheritdoc}  
     */  
    public function getFormId() {  
        return 'ngt_form_general';  
    } 

    /**  
     * {@inheritdoc}  
     */  
    public function buildForm(array $form, FormStateInterface $form_state) {  
        $config = \Drupal::config('ngt.adminSettingsGeneral');  

        $form['img_logo'] = [  
            '#type' => 'managed_file',
            '#upload_location' => 's3://file-project',
            '#title' => t('Logo'),
            '#upload_validators' => [
                'file_validate_extensions' => ['png svg']
            ],
            '#default_value' => $config->get('img_logo'),
            '#description' => t('Logo general de la plataforma'),
            '#required' => true
        ]; 
        
        $form['txt_curso'] = [  
            '#type' => 'textarea',  
            '#title' => 'Texto home cursos',  
            '#description' => t('Texto a mostrar en home, arriba de curso destacado'),  
            '#default_value' => $config->get('txt_curso'),  
            '#required' => true
        ]; 

        $form['txt_newsletter'] = [  
            '#type' => 'textarea',  
            '#title' => t('Texto newsletter'),  
            '#description' => t('Texto a mostrar en formulario de newsletter'),  
            '#default_value' => $config->get('txt_newsletter'),  
            '#required' => true
        ]; 

        $form['txt_footer'] = [  
            '#type' => 'textarea',  
            '#title' => t('Texto footer'),  
            '#description' => t('Texto a mostrar en footer'),  
            '#default_value' => $config->get('txt_footer'),  
            '#required' => true
        ]; 


        return $form;
    } 

    /**  
     * {@inheritdoc}  
     */  
    public function submitForm(array &$form, FormStateInterface $form_state) {  

        $config = \Drupal::configFactory()->getEditable('ngt.adminSettingsGeneral');
        $config
            ->set('img_logo', $form_state->getValue('img_logo'))   
            ->set('txt_curso', $form_state->getValue('txt_curso')) 
            ->set('txt_newsletter', $form_state->getValue('txt_newsletter')) 
            ->set('txt_footer', $form_state->getValue('txt_footer'))   
            ->save();  

        $fid = $form_state->getValue('img_logo');
        if ($fid) {
            $this->setFileAsPermanent($fid);
        }
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
        \Drupal::service('file.usage')->add($file, 'ngt', 'ngt', $fid);
    }
}