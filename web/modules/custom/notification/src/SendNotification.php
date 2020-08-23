<?php

namespace Drupal\notification;

use Drupal\user\Entity\User;
use Drupal\Core\Render\BubbleableMetadata;

class SendNotification implements SendNotificationInterface{
    protected $params = [];
        
    /**
     * send_notification
     *
     * @param  array $tokens
     *  Notification tokens.
     * @param  string $template
     *  Template name.
     * @return void
     */
    public function send_notification(array $tokens, $template){
        $uid = \Drupal::currentUser()->id();
        $account = User::load($uid);

        $email = $account->getMail();
        $params = [];

        $settings = \Drupal::config('notification.settings');
        $params['mail_to_send'] = $tokens['mail_to_send'];
        $langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();
        $params['langcode'] = $langcode;
        $this->send_notification_template($template, $tokens, $settings);
    }

    
    /**
     * send_mail
     *
     */
    public function send_mail(){
        ob_start();
            $langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();
            $send = \Drupal::service('plugin.manager.mail')->mail('notification', 'default', $this->params['mail_to_send'], $this->params['langcode'], $this->params, NULL, true);
        ob_end_clean();
        if ($send['result'] !== true) {
            \Drupal::logger('notification_result')->info('Se presentó un problema al enviar el correo');
        }else{
            \Drupal::logger('notification_response')->info(print_r([$send], TRUE));
        }
    }
    
    /**
     * send_notification_template
     *
     * @param  string $template
     * @param  array $tokens
     * @param  array $settings'
     */
    public function send_notification_template($template, $tokens, $settings){
        switch ($template) {
            case 'new_user':
                    $params['mailt_to_send'] = $tokens['mail_to_send'];
                    $params['subject'] = $tokens['subject'];
                    $params['body'] = $settings->get('new_user')['body']['value'];
                    // $params['tokens']['example'] = $tokens['example'];
                    $this->params = $params;
                    $this->send_notification();
                break;
        }
    }
}   