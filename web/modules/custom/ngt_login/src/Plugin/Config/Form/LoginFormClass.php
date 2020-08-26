<?php 

namespace Drupal\ngt_login\Plugin\Config\Form;

use Drupal\Core\Form\FormStateInterface;

class LoginFormClass{
    /**  
     * {@inheritdoc}  
     */  
    protected function getEditableConfigNames() {  
        return [  
            'ngt_login.adminSettingsLogin',  
        ];  
    }  

    /**  
     * {@inheritdoc}  
     */  
    public function getFormId() {  
        return 'ngt_login_form';  
    } 

    /**  
     * {@inheritdoc}  
     */  
    public function buildForm(array $form, FormStateInterface $form_state) {  
        $config = \Drupal::config('ngt_login.adminSettingsLogin');  

        $help_text_new_pass = [
            'Mínimo o caracteres',
            'Incluir números 0 - 9',
            'Incluir mayúsculas',
            'Incluir caracter especial'
        ];

        // login

        $form['login'] = [  
            '#type' => 'details',
            '#title' => t('Configuraciones del login'),   
            '#open' => false,  
        ]; 

        $form['login']['title'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto para saludo o título'),   
            '#default_value' => isset($config->get('login')['saludo']) ? $config->get('login')['saludo'] : t('¡Hola!'),
            '#required' => true
        ]; 

        $form['login']['message'] = [  
            '#type' => 'textarea',
            '#title' => t('texto mensaje login'),   
            '#default_value' => isset($config->get('login')['message']) ? $config->get('login')['message'] : t('Ingresa tus datos de accesso para iniciar sesión'),
            '#required' => true
        ]; 

        $form['login']['forgot_password'] = [  
            '#type' => 'textarea',
            '#title' => t('texto olvidaste contraseña'),   
            '#default_value' => isset($config->get('login')['forgot_password']) ? $config->get('login')['forgot_password'] : t('¿Olvidaste tu contraseña?'),
            '#required' => true
        ]; 

        $form['login']['new_user_message'] = [  
            '#type' => 'textarea',
            '#title' => t('texto invitar a registrarse'),   
            '#default_value' => isset($config->get('login')['new_user_message']) ? $config->get('login')['new_user_message'] : t('¿No tienes una cuenta?'),
            '#required' => true
        ];

        $form['login']['new_user_text'] = [  
            '#type' => 'textarea',
            '#title' => t('texto olvidaste contraseña'),   
            '#default_value' => isset($config->get('login')['new_user_text']) ? $config->get('login')['new_user_text'] : t('Regístrate aquí'),
            '#required' => true
        ];

        // restablecer contraseña

        $form['forgot_password'] = [  
            '#type' => 'details',
            '#title' => t('Configuraciones restablecer contraseña'),   
            '#open' => false,  
        ]; 

        $form['forgot_password']['continue'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto botón continuar'),   
            '#default_value' => isset($config->get('forgot_password')['continue']) ? $config->get('forgot_password')['continue'] : t('Continuar'),
            '#required' => true
        ]; 

        $form['forgot_password']['cancell'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto botón cancelar'),   
            '#default_value' => isset($config->get('forgot_password')['cancell']) ? $config->get('forgot_password')['cancell'] : t('Cancelar'),
            '#required' => true
        ];
        
        $form['forgot_password']['login'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto botón iniciar sesión'),   
            '#default_value' => isset($config->get('forgot_password')['login']) ? $config->get('forgot_password')['login'] : t('Iniciar sesión'),
            '#required' => true
        ]; 

        $form['forgot_password']['return'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto botón volver'),   
            '#default_value' => isset($config->get('forgot_password')['return']) ? $config->get('forgot_password')['return'] : t('Volver'),
            '#required' => true
        ]; 

        $form['forgot_password']['title'] = [  
            '#type' => 'textfield',
            '#title' => t('Título'),   
            '#default_value' => isset($config->get('forgot_password')['title']) ? $config->get('forgot_password')['title'] : t('Restablecer contraseña'),
            '#required' => true
        ]; 

        $form['forgot_password']['placeholder_code'] = [  
            '#type' => 'textfield',
            '#title' => t('Placelholder código de confirmación'),   
            '#default_value' => isset($config->get('forgot_password')['placeholder_code']) ? $config->get('forgot_password')['placeholder_code'] : t('Código de confirmación'),
            '#required' => true
        ]; 

        $form['forgot_password']['return'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto placeholder input código confirmación'),   
            '#default_value' => isset($config->get('forgot_password')['return']) ? $config->get('forgot_password')['return'] : t('Volver'),
            '#required' => true
        ]; 

        $form['forgot_password']['code_send'] = [  
            '#type' => 'textarea',
            '#title' => t('Mensaje código enviado'),   
            '#default_value' => isset($config->get('forgot_password')['code_send']) ? $config->get('forgot_password')['code_send'] : t('Te enviamos un código de confirmación al correo ingresado'),
            '#required' => true
        ]; 

        $form['forgot_password']['code_send'] = [  
            '#type' => 'textarea',
            '#title' => t('Mensaje código enviado'),   
            '#default_value' => isset($config->get('forgot_password')['code_send']) ? $config->get('forgot_password')['code_send'] : t('Te enviamos un código de confirmación al correo ingresado'),
            '#required' => true
        ]; 

        $form['forgot_password']['new_pass'] = [  
            '#type' => 'textarea',
            '#title' => t('Mensaje ingrese nueva contraseña'),   
            '#default_value' => isset($config->get('forgot_password')['new_pass']) ? $config->get('forgot_password')['new_pass'] : t('Ingresa tu nueva contraseña'),
            '#required' => true
        ]; 

        $form['forgot_password']['password'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto placeholder input contraseña'),   
            '#default_value' => isset($config->get('forgot_password')['return']) ? $config->get('forgot_password')['return'] : t('Contraseña'),
            '#required' => true
        ]; 

        $form['forgot_password']['repeat_password'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto placeholder input confirmar contraseña'),   
            '#default_value' => isset($config->get('forgot_password')['repeat_password']) ? $config->get('forgot_password')['repeat_password'] : t('Confirmar contraseña'),
            '#required' => true
        ]; 

        $form['forgot_password']['help_text_new_pass'] = [  
            '#type' => 'textarea',
            '#title' => t('Características de la contraseña'),   
            '#default_value' => isset($config->get('forgot_password')['help_text_new_pass']) ? $config->get('forgot_password')['help_text_new_pass'] : implode(PHP_EOL, $help_text_new_pass),
            '#description' => 'Ingrese linea por linea las características que la contraseña debe tener',
            '#required' => true
        ];

        $form['forgot_password']['new_pass_success'] = [  
            '#type' => 'textarea',
            '#title' => t('Mensaje contraseña restablecida correctamente'),   
            '#default_value' => isset($config->get('forgot_password')['new_pass_success']) ? $config->get('forgot_password')['new_pass_success'] : t('Tu contraseña se restableció correctamente'),
            '#required' => true
        ]; 

        $form['forgot_password']['new_pass_failed'] = [  
            '#type' => 'textarea',
            '#title' => t('Mensaje error al restablecer contraseña'),   
            '#default_value' => isset($config->get('forgot_password')['new_pass_failed']) ? $config->get('forgot_password')['new_pass_failed'] : t('Tu contraseña no se restableció correctamente, intenta nuevamente en unos minutos'),
            '#required' => true
        ]; 

        // Crear cuenta

        $form['new_user'] = [  
            '#type' => 'details',
            '#title' => t('Configuraciones para nuevo usuario'),   
            '#open' => false,  
        ]; 

        $form['new_user']['continue'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto botón continuar'),   
            '#default_value' => isset($config->get('new_user')['continue']) ? $config->get('new_user')['continue'] : t('Continuar'),
            '#required' => true
        ]; 

        $form['new_user']['cancell'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto botón cancelar'),   
            '#default_value' => isset($config->get('new_user')['cancell']) ? $config->get('new_user')['cancell'] : t('Cancelar'),
            '#required' => true
        ];
        
        $form['new_user']['login'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto botón iniciar sesión'),   
            '#default_value' => isset($config->get('new_user')['login']) ? $config->get('new_user')['login'] : t('Iniciar sesión'),
            '#required' => true
        ]; 

        $form['new_user']['return'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto botón volver'),   
            '#default_value' => isset($config->get('new_user')['return']) ? $config->get('new_user')['return'] : t('Volver'),
            '#required' => true
        ]; 

        $form['new_user']['omit'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto botón omitir'),   
            '#default_value' => isset($config->get('new_user')['omit']) ? $config->get('new_user')['omit'] : t('Omitir'),
            '#required' => true
        ]; 

        $form['new_user']['exit'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto regresar al sitio'),   
            '#default_value' => isset($config->get('new_user')['continue']) ? $config->get('new_user')['continue'] : t('Regresar al inicio'),
            '#description' => t('Texto del enlace a mostrar si se genera error al crear una nueva cuenta'),
            '#required' => true
        ]; 

        $form['new_user']['title'] = [  
            '#type' => 'textfield',
            '#title' => t('título'),   
            '#default_value' => isset($config->get('new_user')['title']) ? $config->get('new_user')['title'] : t('Crea tu cuenta'),
            '#required' => true
        ]; 

        $form['new_user']['message'] = [  
            '#type' => 'textarea',
            '#title' => t('Mensaje ingresa tus datos'),   
            '#default_value' => isset($config->get('new_user')['message']) ? $config->get('new_user')['message'] : t('Ingresa tus datos personales para crear tu cuenta'),
            '#required' => true
        ]; 

        $form['new_user']['name'] = [  
            '#type' => 'textfield',
            '#title' => t('PlaceHolder Nombres y Apellidos'),   
            '#default_value' => isset($config->get('new_user')['name']) ? $config->get('new_user')['name'] : t('Nombres y Apellidos'),
            '#required' => true
        ]; 

        $form['new_user']['email'] = [  
            '#type' => 'textfield',
            '#title' => t('PlaceHolder Email'),   
            '#default_value' => isset($config->get('new_user')['email']) ? $config->get('new_user')['email'] : t('Correo electrónico'),
            '#required' => true
        ];

        $form['new_user']['date'] = [  
            '#type' => 'textfield',
            '#title' => t('PlaceHolder fecha nacimiento'),   
            '#default_value' => isset($config->get('new_user')['date']) ? $config->get('new_user')['date'] : t('Fecha de nacimiento'),
            '#required' => true
        ];

        $form['new_user']['profession'] = [  
            '#type' => 'textfield',
            '#title' => t('PlaceHolder profession'),   
            '#default_value' => isset($config->get('new_user')['profession']) ? $config->get('new_user')['profession'] : t('Profesión'),
            '#required' => true
        ];

        $form['new_user']['country'] = [  
            '#type' => 'textfield',
            '#title' => t('PlaceHolder país'),   
            '#default_value' => isset($config->get('new_user')['country']) ? $config->get('new_user')['country'] : t('País'),
            '#required' => true
        ];

        $form['new_user']['state'] = [  
            '#type' => 'textfield',
            '#title' => t('PlaceHolder departamento/estado'),   
            '#default_value' => isset($config->get('new_user')['state']) ? $config->get('new_user')['state'] : t('Departamento/Estado'),
            '#required' => true
        ];

        $form['new_user']['city'] = [  
            '#type' => 'textfield',
            '#title' => t('PlaceHolder ciudad/municipio'),   
            '#default_value' => isset($config->get('new_user')['city']) ? $config->get('new_user')['city'] : t('Ciudad/Municipio'),
            '#required' => true
        ];

        $form['new_user']['user_name'] = [  
            '#type' => 'textfield',
            '#title' => t('PlaceHolder nombre de usuario'),   
            '#default_value' => isset($config->get('new_user')['user_name']) ? $config->get('user_name')['city'] : t('Nombre de usuario'),
            '#required' => true
        ];

        $form['new_user']['password'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto placeholder input contraseña'),   
            '#default_value' => isset($config->get('new_user')['return']) ? $config->get('new_user')['return'] : t('Contraseña'),
            '#required' => true
        ]; 

        $form['new_user']['repeat_password'] = [  
            '#type' => 'textfield',
            '#title' => t('Texto placeholder input confirmar contraseña'),   
            '#default_value' => isset($config->get('new_user')['repeat_password']) ? $config->get('new_user')['repeat_password'] : t('Confirmar contraseña'),
            '#required' => true
        ]; 

        $form['new_user']['help_text_new_pass'] = [  
            '#type' => 'textarea',
            '#title' => t('Características de la contraseña'),   
            '#default_value' => isset($config->get('new_user')['help_text_new_pass']) ? $config->get('new_user')['help_text_new_pass'] : implode(PHP_EOL, $help_text_new_pass),
            '#description' => 'Ingrese linea por linea las características que la contraseña debe tener',
            '#required' => true
        ];

        $form['new_user']['title_picture'] = [  
            '#type' => 'textarea',
            '#title' => t('Título Añade tu foto de perfil'),   
            '#default_value' => isset($config->get('new_user')['title_picture']) ? $config->get('new_user')['title_picture'] : 'Añade tu foto de perfil',
            '#required' => true
        ];

        $form['new_user']['message_picture'] = [  
            '#type' => 'textarea',
            '#title' => t('Mensaje invitación cargar foto perfil'),   
            '#default_value' => isset($config->get('new_user')['message_picture']) ? $config->get('new_user')['message_picture'] : t('¡Queremos conocerte!'),
            '#required' => true
        ]; 
        
        $form['new_user']['message_picture_load_success'] = [  
            '#type' => 'textarea',
            '#title' => t('Mensaje foto perfil cargada'),   
            '#default_value' => isset($config->get('new_user')['message_picture_load_success']) ? $config->get('new_user')['message_picture_load_success'] : t('Foto añadida correctamente'),
            '#required' => true
        ]; 

        $form['new_user']['message_picture_load_failed'] = [  
            '#type' => 'textarea',
            '#title' => t('Mensaje error al cargar foto perfil'),   
            '#default_value' => isset($config->get('new_user')['message_picture_load_failed']) ? $config->get('new_user')['message_picture_load_failed'] : t('Se presentó un error al cargar la foto, intenta nuevamente u omite este paso, podrás cargarla nuevamente accediendo a tu perfil'),
            '#required' => true
        ]; 

        $form['new_user']['ready'] = [  
            '#type' => 'textfield',
            '#title' => t('Título cuenta creada'),   
            '#default_value' => isset($config->get('new_user')['ready']) ? $config->get('new_user')['ready'] : t('¡Listo!'),
            '#required' => true
        ]; 

        $form['new_user']['message_new_user_success'] = [  
            '#type' => 'textarea',
            '#title' => t('Mensaje cuenta creada'),   
            '#default_value' => isset($config->get('new_user')['message_new_user_success']) ? $config->get('new_user')['message_new_user_success'] : t('Tu cuenta se cré correctamente'),
            '#required' => true
        ]; 

        $form['new_user']['message_new_user_welcome'] = [  
            '#type' => 'textarea',
            '#title' => t('Texto bienvenida'),   
            '#default_value' => isset($config->get('new_user')['message_new_user_welcome']) ? $config->get('new_user')['message_new_user_welcome'] : t('¡Bienvenido (a)!'),
            '#required' => true
        ]; 

        $form['new_user']['failed'] = [  
            '#type' => 'textfield',
            '#title' => t('Título error al crear cuenta'),   
            '#default_value' => isset($config->get('new_user')['ready']) ? $config->get('new_user')['ready'] : t('¡Algo salió mal!'),
            '#required' => true
        ]; 

        $form['new_user']['message_new_user_failed'] = [  
            '#type' => 'textarea',
            '#title' => t('Mensaje cuenta creada'),   
            '#default_value' => isset($config->get('new_user')['message_new_user_success']) ? $config->get('new_user')['message_new_user_success'] : t('No logramos crear tu cuenta, por favor intenta nuevamente, si el problema persiste por favor comunícate con nosotros mediante el formulario de contacto.'),
            '#required' => true
        ]; 

        return $form;
    } 

    /**  
     * {@inheritdoc}  
     */  
    public function submitForm(array &$form, FormStateInterface $form_state) {  

        $config = \Drupal::configFactory()->getEditable('ngt_login.adminSettingsLogin');
        $config
            ->set('login', $form_state->getValue('login'))
            ->set('forgot_password', $form_state->getValue('forgot_password'))
            ->set('new_user', $form_state->getValue('new_user'))
            ->save();  

    }  

}