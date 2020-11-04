<?php 

namespace Drupal\ngt_social_shared\Plugin\Config\Block;

use Drupal\ngt_social_shared\Plugin\Block\SocialSharedBlock;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\file\Entity\File;



/**
 * Manage config a 'SocialSharedBlockClass' block
 */
class SocialSharedBlockClass {
    protected $instance;
    protected $configuration;

    /**
     * @param \Drupal\ngt_social_shared\Plugin\Block\SocialSharedBlock $instance
     * @param $config
     */
    public function setConfig(SocialSharedBlock &$instance, &$config){
        $this->instance = &$instance;
        $this->configuration = &$config;
    }

    /**
     * {@inheritdoc}
     */
    public function defaultConfiguration() {
        return [];
    }

  
    /**
     * @param \Drupal\ngt_social_shared\Plugin\Block\SocialSharedBlock $instance
     * @param $config
     */
    public function build(SocialSharedBlock &$instance, $configuration){
        $config = \Drupal::config('ngt_social_shared.settings');  
        $via = $config->get('ngt_social_shared_config')['twitter_via'];
        
        $url = \Drupal::request()->getSchemeAndHttpHost(). \Drupal::request()->getRequestUri();
        $twitter_hashtags = $config->get('ngt_social_shared_config')['twitter_hashtags'];
        $url_twitter  =  $config->get('ngt_social_shared_config')['twitter_url'] .'?url='. $url .'&via='. $via .'&hashtags='. $twitter_hashtags;
        $url_facebook  =  $config->get('ngt_social_shared_config')['facebook_url'] .'?u='. $url;
        
        $build = [
            '#theme' => 'social_shared_button',
            '#url' => $url,
            '#via' => $via,
            '#url_facebook' => $url_facebook,
            '#url_twitter' => $url_twitter,
        ];

        return $build;
    }

}