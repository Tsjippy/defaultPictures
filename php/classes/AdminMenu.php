<?php
namespace TSJIPPY\DEFAULTPICTURES;
use TSJIPPY;
use TSJIPPY\ADMIN;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AdminMenu extends ADMIN\SubAdminMenu{

    public function __construct($settings, $name){
        parent::__construct($settings, $name);
    }

    public function settings($parent){
        //Get all post types
        $args = array(
            'public'   => true,
            '_builtin' => false
        );

        $postTypes = array_merge(get_post_types( $args, 'names', 'and' ), ['post']);

        foreach($postTypes as $postType){
            if($postType == 'post'){
                $tax	= 'category';
            }else{
                $tax	= $postType.'type';
            }

            TSJIPPY\addElement('h3', $parent, [], "Default pictures for {$postType}s");
            TSJIPPY\addElement('h4', $parent, [], "Default picture for $postType");
            $this->pictureSelector($postType, ucfirst($postType), $parent);            

            $categories	= get_terms(['hide_empty' => false, 'taxonomy' => $tax]);

            if(!empty($categories)){
                TSJIPPY\addElement('h4', $parent, [], "Default pictures per category for {$postType}s");
                foreach($categories as $category){
                    $this->pictureSelector($category->slug, $category->name, $parent);
                    TSJIPPY\addElement('br', $parent);
                }
                TSJIPPY\addElement('br', $parent);
                TSJIPPY\addElement('br', $parent);
            }
        }

        return true;
    }

    public function emails($parent){
        return false;
    }

    public function data($parent){
        return false;
    }

    public function functions($parent){
        return false;
    }

}