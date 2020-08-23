<?php

namespace Drupal\notification;

interface SendNotificationInterface{
    public function send_notification(array $tokens, $template);
}