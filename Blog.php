<?php
require_once "requirements.php";
class Blog{

    private $Posts;
    private $Cats;

    public function __construct(){
        $this->Posts = new Posts();
        $this->Cats = new Cats();
    }

    public function Posts(){ return $this->Posts = new Posts(); }
    public function Cats(){ return $this->Cats = new Cats(); }

    /**
     * name
     *
     * Elle retourne le titre du site
     *
     * @Return string
     */
    public function name(){ return bloginfo('name'); }

    /**
     * title
     *
     * Elle retourne le titre du site
     *
     * @Return string
     */
    public function title(){ return bloginfo('title'); }

    /**
     * description
     *
     * Elle retourne le slogan du site
     *
     * @Return string
     */
    public function description(){ return bloginfo('description'); }

    /**
     * Raccourci de la fonction description
     */
    public function desc(){ return bloginfo('description'); }

    /**
     * url
     *
     * Elle retourne l'adresse du site web
     *
     * @Return string
     */
    public function url(){ return bloginfo('url'); }

    /**
     * email
     *
     * Elle retourne l'adresse de messagerie  l'administarteur
     *
     * @Return string
     */
    public function email(){ return bloginfo('admin_email'); }

    /**
     * charset
     *
     * Displays the "Encoding for pages and feeds"
     *
     * @Return string
     */
    public function charset(){ return bloginfo('charset'); }

    /**
     * version
     *
     * Displays the WordPress Version you use
     *
     * @Return string
     */
    public function version(){ return bloginfo('version'); }

    /**
     * lang
     *
     * Displays the language of WordPress.
     *
     * @Return string
     */
    public function lang() { return strtolower(substr(get_bloginfo('language'),-2)); }

    /**
     * language
     *
     * Displays the language of WordPress.
     *
     * @Return string
     */
    public function language(){ return $this->lang(); }

    /**
     * style
     *
     * Returns URL of current theme stylesheet.
     *
     * @Return string
     */
    public function style(){ return get_stylesheet_uri(); }

    /**
     * css
     *
     * Returns URL of current theme stylesheet.
     *
     * @Return string
     */
    public function css(){ return get_stylesheet_uri(); }

    /**
     * path
     *
     * Retrieve template directory URI for the current theme. Does not return a trailing slash following the directory address.
     *
     * @Return string
     */
    public function path($path = null){
        $p = "/wp-content/themes";
        if(!$path){ return $p; }
        return $p.'/'.trim($path, "/");
    }

    /**
     * image
     *
     * Renvoie le chemin complet de l'image indiqué. Si on ne spécifie pas d'image, elle renvoie le chemin du dossier images
     *
     * @Return string
     */
    public function image($img = null){ return $this->path(($img) ? '/img/'.$img : '/img'); }


    public function menuItems($menuName = null){
        $args = array(
            'order'                  => 'ASC',
            'orderby'                => 'menu_order',
            'post_type'              => 'nav_menu_item',
            'post_status'            => 'publish',
//            'output'                 => ARRAY_A,
            'output_key'             => 'menu_order',
            'nopaging'               => true,
            'update_post_term_cache' => false );
        $items = wp_get_nav_menu_items( $menuName, $args );
        if(!$items){ return null; }
        $res = array();
        foreach($items as $item){
            $res[] = new Post($item);
        }

        return $res;
    }


    public function sortByMeta(array $posts, $meta, $isDesc)
    {
        usort($posts, function ($a, $b) use ($meta, $isDesc) {

            $a = trim($a->meta($meta), " ");
            if($a == ""){ $a = 1000000; }
            $a = (int) $a;

            $b = trim($b->meta($meta), " ");
            if($b == ""){ $b = 1000000; }
            $b = (int) $b;

            if ($a == $b) { return 0; }
            return ($a > $b) ? ($isDesc ? -1 : 1) : ($isDesc ? 1 : -1);
        });
        return $posts;
    }

    public function replaceTag($strTag){
        return preg_replace_callback("/\[(.+)\]/", function($matches){
            return "<span class='tag'>$matches[1]</span>";
        }, $strTag);
    }

    public function host(){
        return $_SERVER["HTTP_HOST"];
    }

    public function serverName(){
        return $_SERVER["SERVER_NAME"];
    }

    public function requestUri(){
        return $_SERVER["REQUEST_URI"];
    }


}
