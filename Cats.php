<?php

class Cats
{

    private $args;

    private function createCats($cats)
    {
        $res = array();
        if ($cats) {
            foreach ($cats as $cat) {
                $res[] = new Cat($cat);
            }
        }
        return $res;
    }

    /*
         Configuration de la fonction get_categories() :

         array(
        'type'                     => 'post',
        'child_of'                 => 0,
        'parent'                   => '',
        'orderby'                  => 'name',
        'order'                    => 'ASC',
        'hide_empty'               => 1,
        'hierarchical'             => 1,
        'exclude'                  => '',
        'include'                  => '',
        'number'                   => '',
        'taxonomy'                 => 'category',
        'pad_counts'               => false

        );
    */

    public function __construct()
    {
        $this->args = array(
            'type' => 'post',
        );

    }

    /**
     *Cette fontion permet d'obtenir des objets Cat
     * @param null $count
     * @return array|Cat
     */
    public function get($count = null)
    {
        if ((gettype($count)) == 'object') {
            return new Cat($count);
        }
        $cats = get_categories(['type' => 'post', 'number' => $count]);
        return $this->createCats($cats);
    }

    /**
     * Cette fonction permet d'obtenir une catégorie en fonction de son id
     * @param null $catId
     * @return Cat
     */
    public function getById($catId = null)
    {
        return new Cat(get_the_category_by_ID($catId));
    }

    /**
     * Cette fonction permet d'obtenir une catégorie en fonction de son slug
     * @param null $catSlug
     * @return Cat
     */
    public function getBySlug($catSlug = null)
    {
        return new Cat(get_category_by_slug($catSlug));
    }


    /**
     * Cette fonction permet d'obtenir les catégories enfants en se basant sur l'identifiant de la catégorie mère.
     * @param string $id
     * @param null $count
     * @return array
     */
    public function getByParentId($id = '', $count = null)
    {
        $args = array(
            'type' => 'post',
            'child_of' => $id,
            'hide_empty' => true,
            'hierarchical' => true,
            'exclude' => '1',
            'number' => $count,
            'orderby' => 'name',
            'order' => 'ASC'
        );
        $cats = get_categories($args);
        return $this->createCats($cats);
    }


}
