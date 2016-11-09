<?php

class Post{

    private $post = null;

    public function __construct($post = null){
        $this->post = (strtolower(get_class($post)) == 'wp_post') ? $post : null ;
    }

    /**
     * id
     * The ID of the post
     * @return int/null
     */
    public function id(){ return $this->post ? $this->post->ID : null; }

    /**
     * author
     * The post author's user ID (numeric string)
     * @return string/null
     */
    public function author(){ return $this->post ? $this->post->post_author : null; }

    /**
     * name
     * The post's slug
     * @return string/null
     */
    public function name(){ return $this->post ? $this->post->post_name : null; }

    /**
     * slug
     * The post's slug
     * @return string/null
     */
    public function slug(){ return $this->post ? $this->post->post_name : null; }

    /**
     * type
     * Le type de post
     *      - Post (Post Type: 'post')
     *      - Page (Post Type: 'page')
     *      - Attachment (Post Type: 'attachment')
     *      - Revision (Post Type: 'revision')
     *      - Navigation menu (Post Type: 'nav_menu_item')
     * @return string/null
     */
    public function type(){ return $this->post ? $this->post->post_type : null; }

    /**
     * title
     * The title of the post
     * @return string/null
     */
    public function title(){ return $this->post ? $this->post->post_title : null; }

    /**
     * menuItemTitle
     * Permet d'obtenir le titre d'un item du menu
     * @return null
     */
    public function menuItemTitle(){ return $this->post ? $this->post->title : null; }

    /**
     * date
     * La date de création du post
     *      - Format: 0000-00-00 00:00:00
     * @return string/null
     */
    public function date($formatDate = 'd/m/Y')
    {
        if($this->post){
            $dt = date($formatDate, strtotime($this->post->post_date));
        }else{
            $dt = null;
        }
        return $dt;

    }

    /**
     * content
     * The full content of the post
     * @return string/null
     */
    public function content(){ return $this->post ? $this->post->post_content : null; }

    /**
     * excerpt
     * User-defined post excerpt
     * @return string/null
     */
    public function excerpt(){ return $this->post ? $this->post->post_excerpt : null; }

    /**
     * status
     * The post status. Les status possibles sont :
     *      - 'publish' : A published post or page
     *      - 'pending' : post is pending review
     *      - 'draft' : a post in draft status
     *      - 'auto-draft' : a newly created post, with no content
     *      - 'future' : a post to publish in the future
     *      - 'private' : not visible to users who are not logged in
     *      - 'inherit' : a revision. see get_children.
     *      - 'trash' : post is in trashbin. added with Version 2.9.
     * @return string/false/null
     *
     */
    public function status(){ return $this->post ? $this->post->post_status : null; }

    /**
     * password
     * Returns empty string if no password
     * @return string/null
     */
    public function password(){ return $this->post ? $this->post->post_password : null; }

    /**
     * parent
     * Cette fonction permet d'obtenir l'objet Post parent correspondant.
     * @return Post/null
     */
    public function parent(){
        $id = $this->post ? $this->post->post_parent : null;
        return $id ? new Post(get_post($id)) : null ;
    }

    /**
     * modified
     * La date de modification du post
     *      - Format: 0000-00-00 00:00:00
     * @return string/null
     */
    public function modified(){ return $this->post ? $this->post->post_modified : null; }

    /**
     * commentStatus
     * Indique si les commentaires sont possibles (open) ou pas (closed)
     * @return string/null
     */
    public function commentStatus(){ return $this->post ? $this->post->comment_status : null; }

    /**
     * commentCount
     * Number of comments on post (numeric string)
     * @return string/null
     */
    public function commentCount(){ return $this->post ? $this->post->comment_count : null; }

    /**
     * link
     * Retrieve full permalink for current post
     * @return string/false/null
     */
    public function link(){ return $this->post ? get_permalink($this->post) : null; }

    // Voir la fonction $this->link();
    public function url(){ return $this->link(); }

    /**
     * image
     * Image à la une du post
     * @param null $width
     *      La largeur de l'image qu'on souhaite
     * @param null $height
     *      La hauteur de l'image qu'on souhaite
     * @return array|false|mixed|null
     */
    public function image($width = null, $height = null){
        if($this->post){
            $img = wp_get_attachment_image_src(get_post_thumbnail_id($this->id()));
            if($img){
                $repl = '.';
                if(preg_match('/\d+/', $width) && preg_match('/\d+/', $height)){ $repl = '-'.$width.'x'.$height.'.'; }
                $img = preg_replace("/\-\d+x\d+\./", $repl, $img[0]);
            }
            return $img ? $img : null;
        }
        return null;
    }
    // Voir la fonction $this->image
    public function thumbnail(){ return $this->image(); }

    public function hasImage(){
        if($this->post){
            return has_post_thumbnail($this->id());
        }
        return null;
    }

    /**
     * meta
     * Retrieve post meta field for a post.
     * @param $name
     *      Le nom de la donnée
     * @param int $count
     *      Un ou plusieurs
     * @return mixed
     *       Elle revoie un tableau si $count > 1 et un string si $count vaut 1.
     *      Si aucune valeur n'est trouvée, elle retourne false
     */
    public function meta($name, $count = 1){
        $val = get_post_meta($this->id(), $name, ($count == 1) ? true : false);
        return $val;
    }

    public function tags(){
        $args = array(
            'fields ' => 'names',
            'orderby' => 'name',
            'order' => 'ASC'
        );
        return wp_get_post_tags($this->id(), $args);
    }

    /**
     * cats
     * Cette fonction permet d'obtenir un tableau d'objets Cat correspondants aux catégories de cet post.
     * @return array/null
     */
    public function cats(){
        $cats = $this->post ? get_the_category($this->post) : null;
        if(!$cats){ return null; }
        $res =array();
        foreach($cats as $cat){ $res[] = new Cat($cat); }
        return $res ;
    }

    /**
     * categories
     * Cette fonction permet d'obtenir un tableau d'objets Cat correspondants aux catégories de cet post.
     * @return array/null
     */
    public function categories(){ return $this->cats(); }

    /**
     * guid
     * Cette fonction permet d'obtenir un tableau d'objets Cat correspondants aux catégories de cet post.
     * @return array/null
     */
    public function guid(){ return $this->post->guid; }


    public function getPermalink(){
        return get_permalink($this->post->ID);
    }


}
