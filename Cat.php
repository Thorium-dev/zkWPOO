<?php

class Cat{
    private $cat = null;

    private function createCats($cats){
        $res = array();
        if($cats){
            foreach($cats as $cat){
                $res[] = new Cat($cat);
            }
        }
        return $res;
    }

    public function __construct($cat = null){
        $this->cat = (strtolower(gettype($cat)) == 'object') ? $cat : null ;
    }

    /**
     * id
     * The ID of the category
     * @return int/null
     */
    public function id(){ return $this->cat ? $this->cat->term_id : null; }

    /**
     * name
     * The category's slug
     * @return string/null
     */
    public function name(){ return $this->cat ? $this->cat->name : null; }

    /**
     * slug
     * The category's slug
     * @return string/null
     */
    public function slug(){ return $this->cat ? $this->cat->slug : null; }

    /**
     * taxonomy
     * La taxonomy du category
     * @return string/null
     */
    public function taxonomy(){ return $this->cat ? $this->cat->taxonomy : null; }

    /**
     * description
     * The description of the category
     * @return string/null
     */
    public function description(){ return $this->cat ? $this->cat->description : null; }

    /**
     * desc
     * The description of the category
     * @return string/null
     */
    public function desc(){ return $this->cat ? $this->cat->description : null; }

    /**
     * count
     * The number of post existing in this category
     * @return int/null
     */
    public function count(){ return $this->cat ? $this->cat->count : null; }


    /**
     * nicename
     * Le nom stylisé (sans les accents, ...)
     * @return string/null
     */
    public function nicename(){ return $this->cat ? $this->cat->category_nicename : null; }

    /**
     * url
     * Returns the correct url for this Category.
     * @return string/null
     */
    public function url(){ return $this->cat ? get_category_link($this->id()) : null; }

    /**
     * link
     * Returns the correct url for this Category.
     * @return string/null
     */
    public function link(){ return $this->url(); }

    /**
     * parent
     * Cette fonction permet d'obtenir l'objet Cat correspondant au parent cette catégorie.
     * @return Cat/Array/null
     */
    public function parent($count = 1){

//        $cat = get_the_category_by_ID($this->cat->parent);
        $cat = get_categories( array(
                'type'                     => 'post',
                'include'                  => $this->cat->parent,
                'number'                   => 1,
                'taxonomy'                 => 'category',
                'pad_counts'               => false

            )
        );
        if(is_wp_error($cat)){ return null; }
        if ($count == 1) {
            return new Cat($cat[0]);
        }else{
            return $this->createCats($cat);
        }

//        return is_wp_error($cat) ? null : new Cat($cat) ;
        return null;
    }

    /**
     * Cette fonction permet d'obtenir les Posts de cette catégorie
     * @param int $count
     * @return array|Post
     *      - Si $count vaut 1, elle retourne un objet Post
     *      - Sinon elle retourne un tableau contenant des objets Post
     */
    public function posts($count = -1){ return (new Posts())->getByCategoryId($this->id(), $count); }


}
