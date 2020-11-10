<?php  

namespace Drupal\ngt_inscription\Plugin\Form;  

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class InscriptionForm extends ConfigFormBase {
    /**  
     * {@inheritdoc}  
     */  
    protected function getEditableConfigNames() {  
        return [  
            'ngt_inscription.settings',  
        ];  
    }  

    /**  
     * {@inheritdoc}  
     */  
    public function getFormId() {  
        return 'ngt_inscription_form_settings';  
    } 

    /**  
     * {@inheritdoc}  
     */  
    public function buildForm(array $form, FormStateInterface $form_state) {  
        $config = $this->config('ngt_inscription.settings');  


        $form['#tree'] = true;

        // configuración general 

        $form['ngt_inscription_config'] = [  
            '#type' => 'details',
            '#title' => t('Activar o inactivar reserva de cupo'),   
            '#open' => false,  
        ]; 

        $form['ngt_inscription_config']['button'] = [  
            '#type' => 'checkbox',
            '#title' => t('Activar la reserva de cupo en cursos'),   
            '#default_value' => isset($config->get('ngt_inscription_config')['button']) ? $config->get('ngt_inscription_config')['button'] : 1,
        ]; 

        // inscriptición de cursos

        $form['ngt_inscription'] = [  
            '#type' => 'details',
            '#title' => t('Configuraciones del botón para inscriptión de cursos'),   
            '#open' => false,  
        ]; 

        $form['ngt_inscription']['inscription'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto del botón de reservar cupo'),   
            '#default_value' => isset($config->get('ngt_inscription')['inscription']) ? $config->get('ngt_inscription')['inscription'] : t('Reservar cupo'),
            '#required' => true
        ]; 

        $form['ngt_inscription']['uninscription'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto del botón al reservar cupo'),   
            '#default_value' => isset($config->get('ngt_inscription')['uninscription']) ? $config->get('ngt_inscription')['uninscription'] : t('Cancelar reservar'),
            '#required' => true
        ]; 


        // desincriptición de cursos

        $form['ngt_uninscription'] = [  
            '#type' => 'details',
            '#title' => t('Configuraciones del botón para desinscriptición de cursos'),   
            '#open' => false,  
        ]; 

        $form['ngt_uninscription']['uninscription'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto del botón cancelar reserva de cupo'),   
            '#default_value' => isset($config->get('ngt_uninscription')['uninscription']) ? $config->get('ngt_uninscription')['uninscription'] : t('Cancelar reserva'),
            '#required' => true
        ]; 

        $form['ngt_uninscription']['inscription'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto del botón de reservar cupo'),   
            '#default_value' => isset($config->get('ngt_uninscription')['inscription']) ? $config->get('ngt_uninscription')['inscription'] : t('Reservar cupo'),
            '#required' => true
        ];

        return parent::buildForm($form, $form_state);
    } 

    /**  
     * {@inheritdoc}  
     */  
    public function submitForm(array &$form, FormStateInterface $form_state) {  
        parent::submitForm($form, $form_state);

        $this->config('ngt_inscription.settings')
        ->set('ngt_inscription', $form_state->getValue('ngt_inscription'))  
        ->set('ngt_uninscription', $form_state->getValue('ngt_uninscription'))
        ->save();   

    }  

    /**  
     * {@inheritdoc}  
     */ 
    public function validateFormat(array &$form, FormStateInterface $form_state){
        parent::validateFormat($form, $form_state);
    }

}