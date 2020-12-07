<?php  

namespace Drupal\ngt_evaluation\Plugin\Form;  

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EvaluationForm extends ConfigFormBase {
    /**  
     * {@inheritdoc}  
     */  
    protected function getEditableConfigNames() {  
        return [  
            'ngt_evaluation.settings',  
        ];  
    }  

    /**  
     * {@inheritdoc}  
     */  
    public function getFormId() {  
        return 'ngt_evaluation_form_settings';  
    } 

    /**  
     * {@inheritdoc}  
     */  
    public function buildForm(array $form, FormStateInterface $form_state) {  
        $config = $this->config('ngt_evaluation.settings');  


        $form['#tree'] = true;

        // configuración general 

        $form['ngt_evaluation'] = [  
            '#type' => 'details',
            '#title' => t('Configuraciones para las evaluaciones'),   
            '#open' => true,  
        ]; 

        $form['ngt_evaluation']['activate'] = [  
            '#type' => 'checkbox',
            '#title' => t('Activar las evaluaciones para cursos o módulos'),   
            '#default_value' => isset($config->get('ngt_evaluation')['activate']) ? $config->get('ngt_evaluation')['activate'] : 1,
        ]; 

        $form['ngt_evaluation']['title_average'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto final a mostrar en la evaluación'),   
            '#default_value' => isset($config->get('ngt_evaluation')['title_average']) ? $config->get('ngt_evaluation')['title_average'] : t('Puntaje'),
            '#required' => true
        ]; 

        $form['ngt_evaluation']['indicator'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto final a mostrar en la evaluación'),   
            '#default_value' => isset($config->get('ngt_evaluation')['indicator']) ? $config->get('ngt_evaluation')['indicator'] : t('Pregunta %n1 de %n2'),
            '#required' => true,
            '#description' => 'El texto obligatoriamente debe contener los prefijos %n1 para indicar el número de la pregunta actual y %n2 para la cantidad total de preguntas'
        ]; 

        $form['ngt_evaluation']['complete'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto evaluación finalizada'),   
            '#default_value' => isset($config->get('ngt_evaluation')['complete']) ? $config->get('ngt_evaluation')['complete'] : t('Completada'),
            '#required' => true
        ]; 

        $form['ngt_evaluation']['title'] = [  
            '#type' => 'textfield',
            '#title' => t('Título evaluación finalizada'),   
            '#default_value' => isset($config->get('ngt_evaluation')['title']) ? $config->get('ngt_evaluation')['title'] : t('Evaluación final'),
            '#required' => true
        ]; 

        $form['ngt_evaluation']['success'] = [  
            '#type' => 'textfield',
            '#title' => t('Título evaluación aprobada'),   
            '#default_value' => isset($config->get('ngt_evaluation')['success']) ? $config->get('ngt_evaluation')['success'] : t('!Felicitaciones¡'),
            '#required' => true
        ]; 

        $form['ngt_evaluation']['success_message'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto mensaje evaluación aprobada'),   
            '#default_value' => isset($config->get('ngt_evaluation')['success_message']) ? $config->get('ngt_evaluation')['success_message'] : t('Has aprobado la evaluación final'),
            '#required' => true
        ]; 


        $form['ngt_evaluation']['faild'] = [  
            '#type' => 'textfield',
            '#title' => t('Título evaluación no aprobada'),   
            '#default_value' => isset($config->get('ngt_evaluation')['success']) ? $config->get('ngt_evaluation')['success'] : t('No has aprobado la evaluación final'),
            '#required' => true
        ]; 

        $form['ngt_evaluation']['attempets'] = [  
            '#type' => 'textfield',
            '#title' => t('Intento disponible por evaluación no aprobada'),   
            '#default_value' => isset($config->get('ngt_evaluation')['attempets']) ? $config->get('ngt_evaluation')['attempets'] : t('Tienes disponible un (1) intento adicional.'),
            '#required' => true
        ]; 
        
        $form['ngt_evaluation']['certificate'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto botón descargar certificado'),   
            '#default_value' => isset($config->get('ngt_evaluation')['certificate']) ? $config->get('ngt_evaluation')['certificate'] : t('Descargar certificado'),
            '#required' => true
        ]; 

        $form['ngt_evaluation']['return'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto botón regresar'),   
            '#default_value' => isset($config->get('ngt_evaluation')['return']) ? $config->get('ngt_evaluation')['return'] : t('Volver al curso'),
            '#required' => true
        ]; 

        $form['ngt_evaluation']['cancell'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto botón cancelar evaluación'),   
            '#default_value' => isset($config->get('ngt_evaluation')['cancell']) ? $config->get('ngt_evaluation')['cancell'] : t('Salir de la evaluación'),
            '#required' => true
        ]; 


        $form['ngt_evaluation']['faild_message'] = [  
            '#type' => 'textarea',
            '#title' => t('Texto mensaje evaluación no aprobada'),   
            '#default_value' => isset($config->get('ngt_evaluation')['faild_message']) ? $config->get('ngt_evaluation')['faild_message'] : t('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur.'),
            '#required' => true
        ]; 

        $form['ngt_evaluation']['faild_message_approved'] = [  
            '#type' => 'textarea',
            '#title' => t('Texto final a mostrar en la evaluación aprobada'),   
            '#default_value' => isset($config->get('ngt_evaluation')['faild_message_approved']) ? $config->get('ngt_evaluation')['faild_message_approved'] : t('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur.'),
            '#required' => true
        ]; 

     

        return parent::buildForm($form, $form_state);
    } 

    /**  
     * {@inheritdoc}  
     */  
    public function submitForm(array &$form, FormStateInterface $form_state) {  
        parent::submitForm($form, $form_state);

        $this->config('ngt_evaluation.settings')
        ->set('ngt_evaluation_config', $form_state->getValue('ngt_evaluation_config'))  
        ->set('ngt_evaluation', $form_state->getValue('ngt_evaluation'))  
        ->save();   

    }  

    /**  
     * {@inheritdoc}  
     */ 
    public function validateFormat(array &$form, FormStateInterface $form_state){
        parent::validateFormat($form, $form_state);
    }

}