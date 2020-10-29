<?php 

namespace Drupal\ngt_general;

use Drupal\file\Entity\File;
use Drupal\rest\ResourceResponse;
use Drupal\user\Entity\User;
use Drupal\media\Entity\Media;
use Drupal\Core\Url;
use Drupal\image\Entity\ImageStyle;

class methodGeneral{
   
   
    /**
     * @param string $fid
     *   File id.
     */
    public function setFileAsPermanent($fid) {
        \Drupal::service('page_cache_kill_switch')->trigger();
        if (is_array($fid)) {
            $fid = array_shift($fid);
        }

        $file = File::load($fid);
        if (!is_object($file)) {
            return;
        }

        $file->setPermanent();
        $file->save();
        \Drupal::service('file.usage')->add($file, 'ngt', 'ngt', $fid);
    }

        
    /**
     * renderLogo
     *
     * @return void
     */
    public function renderLogo(){
        \Drupal::service('page_cache_kill_switch')->trigger();
        // build uri logo
        $logo = [
            'image_src_general_settings_logo' => '',
            'image_src_img_second_logo' => '',
            'activated_second_logo' => false,
        ];

        $image_src_general_settings_logo = '';
        $image_src_img_second_logo = '';

        $conf = \Drupal::config('ngt_general.settings');
        $img_general_settings_logo = $conf->get('general_settings')['img_logo'];
        $img_second_logo = $conf->get('general_settings')['img_logo_second'];
        $activate_img_logo_second = $conf->get('general_settings')['activate_img_logo_second'];

        $logo['activated_second_logo'] = $activate_img_logo_second == true ? true : false;
        
        if ( is_array($img_general_settings_logo) ) {
            $fid = reset($img_general_settings_logo);  
            $file = File::load($fid);
            isset($file) ? $logo['general_settings_logo'] = $file->getFileUri() : '';
        }

        if ( is_array($img_second_logo) ) {
            $fid = reset($img_second_logo);  
            $file = File::load($fid);
            isset($file) ? $logo['second_logo'] = $file->getFileUri() : '';
        }
        
        return $logo;
    }
    
    /**
     * loadTermByCategory
     *
     * @param  string $name
     * @return array
     */
    public function loadTermByCategory($name){
        
        $term = [];
        
        $query = \Drupal::entityQuery('taxonomy_term');
        $query->condition('vid', $name);
        $tids = $query->execute();

        if($tids){
            $terms = \Drupal\taxonomy\Entity\Term::loadMultiple($tids);
            foreach ($terms as $value) {
                array_push($term,[
                    'tid' => $value->tid->value,
                    'name' => $value->name->value
                ]); 
            }
        }
        
        return $term;
    }

      /**
     * load_image
     *
     * @param  int $media_field
     * @return url
     */
    public function load_image($media_field, $style = NULL){
        $file = File::load($media_field);
        $url = $file->getFileUri();
        if ($style != NULL){
            $url = ImageStyle::load($style)->buildUrl($url);
        }
        return $url;
    }

    /**
     * load_url_file
     *
     * @param  int $media_field
     * @return string url
     */
    public function load_url_file($media_field){
        $file = File::load($media_field);
        $url = file_create_url($file->getFileUri());
        return $url;
    }
    
    /**
     * load_author
     *
     * @param  array $authors
     * @return array
     */
    public function load_author($authors){
        $expertos = [];
        foreach ($authors as $key => $author) {
            $user =   User::load($author['target_id']); 
            $experto = [
                'uid' => $user->get('uid')->getValue()[0]['value'],
                'name_author' => ucfirst($user->get('field_nombre')->getValue()[0]['value'])." ".ucfirst($user->get('field_apellidos')->getValue()[0]['value']),
                'picture_uri' => $this->load_image($user->get('user_picture')->getValue()[0]['target_id'],'98x98'),
                'uri' => \Drupal::service('path.alias_manager')->getAliasByPath('/user/'.$user->get('uid')->getValue()[0]['value']),
                'profile' => $user->get('field_perfil')->getValue()[0]['value'],
            ];
            array_push($expertos,$experto);
        }
        
        return $expertos;
    }
    
    /**
     * load_resource
     *
     * @param  array $resources
     * @return array
     */
    public function load_resource($resources){
        $recursos = [];
        foreach ($resources as $key => $resource) {
            $file = File::load($resource['target_id']);
            $url = file_create_url($file->getFileUri());
            $filename = $file->get('filename')->getValue()[0]['value'];
            $filenameArray = explode('.', $filename);
            array_pop($filenameArray);
            $title = implode('', $filenameArray);
            $typeFile = end(explode('.', $file->get('filename')->getValue()[0]['value']));
            $recurso = [
                'title' => $title,
                'description' => $resource['description'],
                'extension' => $typeFile,
                'url' => $url,
            ];
            array_push($recursos,$recurso);
        }
        return $recursos;
    }
    
    /**
     * load_module_course
     *
     * @param  mixed $paragraph
     * @return void
     */
    public function load_module_course($paragraph){
        $modules = [];
        $i = 1;
        foreach ( $paragraph as $element ) {
            $module = \Drupal\paragraphs\Entity\Paragraph::load( $element['target_id'] );
            $lessons = isset($module->get('field_leccion')->getValue()[0]['target_id']) ? $this->load_lesson_module($module->get('field_leccion')->getValue()) : NULL;
            array_push($modules, [
                'nidModule' => $module->get('parent_id')->getValue()[0]['value'],
                'numModule' => $i,
                'moduleId' => 'Modulo '. $i,
                'titleModule' => $module->get('field_titulo_del_modulo')->getValue()[0]['value'],
                'lessons' => $lessons,
            ]);
            $i++;
        }
        return $modules;
    }
    
    /**
     * load_lesson_module
     *
     * @param  mixed $lesson
     * @return void
     */
    public function load_lesson_module($lessons){
        $lessonByModule = [];
        if($lessons != NULL){
            foreach ($lessons as $key => $lesson) {
                $node = \Drupal\node\Entity\Node::load($lesson['target_id']);
                array_push($lessonByModule, [
                    'title' => $node->get('title')->getValue()[0]['value'],
                    'url' => \Drupal::service('path.alias_manager')->getAliasByPath('/node/'. $node->get('nid')->getValue()[0]['value']),
                    'nid' => $node->get('nid')->getValue()[0]['value'],
                ]);
            }
        }
        return $lessonByModule;
    }


}