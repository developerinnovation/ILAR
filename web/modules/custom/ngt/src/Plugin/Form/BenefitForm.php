<?php  

namespace Drupal\ngt\Plugin\Form;  

use Drupal\Core\Form\ConfigFormBase;  
use Drupal\Core\Form\FormStateInterface;  

class BenefitForm extends ConfigFormBase {  
    /**  
     * {@inheritdoc}  
     */  
    protected function getEditableConfigNames() {  
        return [  
            'ngt.adminSettingsBenefit',  
        ];  
    }  

    /**  
     * {@inheritdoc}  
     */  
    public function getFormId() {  
        return 'ngt_form_benefit';  
    } 

    /**  
     * {@inheritdoc}  
     */  
    public function buildForm(array $form, FormStateInterface $form_state) {  
        $config = $this->config('ngt.adminSettingsBenefit');  
        
        $form['beneficio_1'] = [  
            '#type' => 'textarea',  
            '#title' => $this->t('Primer beneficio'),  
            '#description' => $this->t('Beneficio a mostrar en el home'),  
            '#default_value' => $config->get('beneficio_1'),  
        ]; 

        $form['beneficio_2'] = [  
            '#type' => 'textarea',  
            '#title' => $this->t('Segundo beneficio'),  
            '#description' => $this->t('Beneficio a mostrar en el home'),  
            '#default_value' => $config->get('beneficio_2'),  
        ]; 

        $form['beneficio_3'] = [  
            '#type' => 'textarea',  
            '#title' => $this->t('Tercer beneficio'),  
            '#description' => $this->t('Beneficio a mostrar en el home'),  
            '#default_value' => $config->get('beneficio_3'),  
        ]; 

        return parent::buildForm($form, $form_state);  
    } 

    /**  
     * {@inheritdoc}  
     */  
    public function submitForm(array &$form, FormStateInterface $form_state) {  
        parent::submitForm($form, $form_state);  

        $this->config('ngt.adminSettingsBenefit')  
            ->set('beneficio_1', $form_state->getValue('beneficio_1'))  
            ->set('beneficio_2', $form_state->getValue('beneficio_2'))  
            ->set('beneficio_3', $form_state->getValue('beneficio_3'))  
            ->save();  
    }  
} 