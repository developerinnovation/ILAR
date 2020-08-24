<?php

namespace Drupal\login_popup\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;
/**
 * Provides a 'User Login Block Popup' block.
 *
 * @Block(
 *   id = "user_login_block_poppup",
 *   admin_label = @Translation("User Login Block Popup"),
 *   category = @Translation("User Login Block Popup")
 * )
 */
class CustomUserLoginBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    if (\Drupal::currentUser()->isAnonymous()) {
      $form = \Drupal::formBuilder()->getForm('Drupal\login_popup\Form\CustomUserLoginForm');
    }
    return $form;
  }
}
