<?php
 
/**
* @file 
* Contains \Drupal\ngt_evaluation\Controller\CertificateRenderController.
*/
namespace Drupal\ngt_evaluation\Controller ;
use Drupal\Core\Controller\ControllerBase ;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Render\Renderer;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Component\Utility\Html ;
use Drupal\Core\Database\Connection;
use Drupal\user\Entity\User;
use Drupal\Core\Url;

class CertificateRenderController extends ControllerBase{ 

    public function render_certificate(Request $request){

    }

}