<?php

class Posts
{

    private $args;
    private $posts;

    private $defaultArgs = array(
        'posts_per_page' => 5, /* numberposts => 5 */
        'offset' => 0,
        'category' => '',
        'category_name' => '',
        'orderby' => 'date',
        'order' => 'DESC',
        'include' => '',
        'exclude' => '',
        'meta_key' => '',
        'meta_value' => '',
        'post_type' => 'post',
        'post_mime_type' => '',
        'post_parent' => '',
        'author' => '',
        'post_status' => 'publish',
        'suppress_filters' => true
    );

    private function createPosts($posts)
    {
        $res = array();
        if ($posts) {
            foreach ($posts as $post) {
                $res[] = new Post($post);
            }
        }
        return $res;
    }

    public function __construct()
    {
        $this->args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
        );
    }

    /**
     * Cette fontion permet d'obtenir des objets Post en fonction des objets WP_Post
     * @param int $count
     * @return array|Post
     *      - Si $count un est objet WP_Post, elle retourne un objet Post
     *      - Sinon, elle retourne un tableau content des objets Post. Elle limite la taille du tableau en fonction de $count
     */
    public function get($count = -1)
    {
        if ((gettype($count)) != 'integer') {
            return new Post($count);
        }
        $this->args["numberposts"] = $count;
        $posts = get_posts($this->args);
        return $this->posts = $this->createPosts($posts);
    }

    /**
     * Cette fonction permet d'obtenir un Post en fonction de son id
     * @param null $id
     * @return Post
     */
    public function getById($id = null)
    {
        return $this->posts = new Post(get_post($id));
    }

    /**
     * Cette fonction permet d'obtenir des Posts en fonction du slug
     * @param null $slug
     * @param int $count
     * @return array|Post
     *      - Si $count vaut 1, elle retourne un objet Post
     *      - Sinon elle retourne un tableau contenant des objets Post
     */
    public function getBySlug($slug = null, $count = -1, array $options)
    {
        if($options){ $this->args = $options; }
        $this->args["name"] = $slug;
        $this->args["numberposts"] = $count;
//        $posts = get_posts(['numberposts' => $count, 'category' => $catId, 'post_type' => 'post', 'post_status' => 'publish']);
        $posts = get_posts($this->args);
        return $this->posts = ($count == 1) ? (new Post($posts[0])) : ($this->createPosts($posts));
    }

    /**
     * Cette fonction permet d'obtenir des Posts en fonction du slug de la catégorie
     * @param null $catSlug
     * @param int $count
     * @return array|Post
     *      - Si $count vaut 1, elle retourne un objet Post
     *      - Sinon elle retourne un tableau contenant des objets Post
     */
    public function getByCategorySlug($catSlug = null, $count = -1)
    {
        $catId = get_category_by_slug($catSlug)->term_id;
        $this->args["category"] = $catId;
        $this->args["numberposts"] = $count;
        $posts = get_posts($this->args);
        return $this->posts = ($count == 1) ? (new Post($posts[0])) : ($this->createPosts($posts));
    }

    /**
     * Cette fonction permet d'obtenir des Posts en fonction de l'identifiant de la catégorie
     * @param null $catId
     * @param int $count
     * @return array|Post
     *      - Si $count vaut 1, elle retourne un objet Post
     *      - Sinon elle retourne un tableau contenant des objets Post
     */
    public function getByCategoryId($catId = null, $count = -1, Array $args = null)
    {
        if($args){
            $posts = get_posts($args);
        }else{
            $posts = get_posts(['numberposts' => $count, 'category' => $catId, 'post_type' => 'post', 'post_status' => 'publish']);
        }
        return $this->posts = ($count == 1) ? (new Post($posts[0])) : ($this->createPosts($posts));

    }

}
