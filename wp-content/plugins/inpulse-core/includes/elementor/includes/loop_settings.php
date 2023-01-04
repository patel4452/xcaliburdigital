<?php

namespace WglAddons\Includes;

use Elementor\Plugin;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
* Wgl Elementor Loop Settings
*
*
* @class        Wgl_Loop_Settings
* @version      1.0
* @category Class
* @author       WebGeniusLab
*/

if (!class_exists('Wgl_Loop_Settings')) {
    class Wgl_Loop_Settings{

        private static $instance = null;
        public static function get_instance( ) {
            if ( null == self::$instance ) {
                self::$instance = new self( );
            }

            return self::$instance;
        }

        public static function buildQuery($query){
            $query_builder = new Wgl_Query_Builder( $query );
            return $query_builder->build();
        }

        public static function init($self, $array = array()){
            
            if( !$self )
                return;

	        $self->start_controls_section(
	            'query_section',
	            array(
	                'label'      => esc_html__('Query', 'inpulse-core' ),
	                'tab'   => Controls_Manager::TAB_SETTINGS
	            )
	        );

	        $self->add_control(
	            'number_of_posts',
	            array(
	                'label'       => esc_html__('Post count', 'inpulse-core'),
	                'type'        => Controls_Manager::NUMBER,
	                'default'     => '12',
	                'min'         => 1,
	                'step'        => 1
	            )
	        );


	        $self->add_control(
	            'order_by',
	            array(
	                'label'       => esc_html__('Order by', 'inpulse-core'),
	                'type'        => Controls_Manager::SELECT,
	                'default'     => 'date',
	                'options'     => array(
	                    'date'            => esc_html__('Date', 'inpulse-core'),
	                    'title'           => esc_html__('Title', 'inpulse-core'),
	                    'author'          => esc_html__('Author', 'inpulse-core'),
	                    'modified'        => esc_html__('Modified', 'inpulse-core'),
	                    'rand'            => esc_html__('Random', 'inpulse-core'),
	                    'comment_count'   => esc_html__('Comments', 'inpulse-core'),
	                    'menu_order'      => esc_html__('Menu Order', 'inpulse-core'),                    	                    
	                ),
	            )
	        );

	        $self->add_control(
	            'order',
	            array(
	                'label'       => esc_html__('Order', 'inpulse-core'),
	                'type'        => Controls_Manager::SELECT,
	                'default'     => 'DESC',
	                'options'     => array(
	                    'DESC'          => esc_html__('Descending', 'inpulse-core'),
	                    'ASC'           => esc_html__('Ascending', 'inpulse-core'),
	                ),
	            )
	        );


            if(!isset($array['hide_cats'])){            
                $self->add_control(
                    'hr_cats',
                    array(
                        'type' => Controls_Manager::DIVIDER,
                    )
                );
                $self->add_control('categories',
                    array(
                        'label'         => esc_html__( 'Filter By Category Slug', 'inpulse-core' ),
                        'type'          => Controls_Manager::SELECT2,
                        
                        'multiple'      => true,
                        'label_block'   => true,
                        'options'       => self::categories_suggester(),       
                    )
                );
                $self->add_control(
                    'exclude_categories',
                    array(
                        'label'        => esc_html__('Exclude These Categories','inpulse-core' ),
                        'type'         => Controls_Manager::SWITCHER,
                        'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                        'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                        'return_value' => 'yes',
                        'description'   => esc_html__('Leave empty for all','inpulse-core'),
                    )
                );  
            }	        

            if(!isset($array['hide_tags'])){

                $self->add_control(
                    'hr_tags',
                    array(
                        'type' => Controls_Manager::DIVIDER,
                    )
                );
                $self->add_control('tags',
                    array(
                        'label'         => esc_html__( 'Filter By Tags Slug', 'inpulse-core' ),
                        'type'          => Controls_Manager::SELECT2,
                        'multiple'      => true,
                        'label_block'   => true,
                        'options'       => self::tags_suggester(),       
                    )
                );
                $self->add_control(
                    'exclude_tags',
                    array(
                        'label'        => esc_html__('Exclude These Tags','inpulse-core' ),
                        'type'         => Controls_Manager::SWITCHER,
                        'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                        'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                        'return_value' => 'yes',
                        'description'   => esc_html__('Leave empty for all','inpulse-core'),
                    )
                );  
	        }

            $self->add_control(
                'hr_tax',
                array(
                    'type' => Controls_Manager::DIVIDER,
                )
            );
            $self->add_control('taxonomies',
                array(
                    'label'         => esc_html__( 'Taxonomies', 'inpulse-core' ),
                    'type'          => Controls_Manager::SELECT2,        
                    'multiple'      => true,
                    'label_block'   => true,
                    'options'       => self::taxonomies_suggester(),       
                )
            );
            $self->add_control(
                'exclude_taxonomies',
                array(
                    'label'        => esc_html__('Exclude These Taxonomies','inpulse-core' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                    'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                    'return_value' => 'yes',
                    'description'   => esc_html__('Filter output by custom taxonomies categories, enter category names here.','inpulse-core'),
                )
            ); 

            if(!isset($array['hide_individual_posts'])){
                $self->add_control(
                    'hr_posts',
                    array(
                        'type' => Controls_Manager::DIVIDER,
                    )
                );

                $self->add_control('by_posts',
                    array(
                        'label'         => esc_html__( 'Individual Posts/Pages/Custom Post Types', 'inpulse-core' ),
                        'type'          => Controls_Manager::SELECT2,
                        'multiple'      => true,
                        'label_block'   => true,
                        'options'       => self::by_posts_suggester($array),       
                    )
                );
                $self->add_control(
                    'exclude_any',
                    array(
                        'label'        => esc_html__('Exclude These Posts/Pages/Custom Post Types','inpulse-core' ),
                        'type'         => Controls_Manager::SWITCHER,
                        'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                        'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                        'return_value' => 'yes',
                        'description'   => esc_html__('Individual Posts/Pages/Custom Post Types','inpulse-core'),
                    )
                );  
            }

            $self->add_control(
                'hr_author',
                array(
                    'type' => Controls_Manager::DIVIDER,
                )
            );

            $self->add_control('author',
                array(
                    'label'         => esc_html__( 'Author', 'inpulse-core' ),
                    'type'          => Controls_Manager::SELECT2,
                    'multiple'      => true,
                    'label_block'   => true,
                    'options'       => self::by_author_suggester(),       
                )
            );
            $self->add_control(
                'exclude_author',
                array(
                    'label'        => esc_html__('Exclude Author','inpulse-core' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                    'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                    'return_value' => 'yes',
                    'description'   => esc_html__('Filter by author name','inpulse-core'),
                )
            );


	        $self->end_controls_section();
        }

        /**
         * @param $taxonomy
         * @param $helper
         *
         * @since 1.0
         */
        public static function get_term_parents_list( $term_id, $taxonomy, $args = array() ) {
            $list = '';
            $term = get_term( $term_id, $taxonomy );
    
            if ( is_wp_error( $term ) ) {
                return $term;
            }
    
            if ( ! $term ) {
                return $list;
            }
    
            $term_id = $term->term_id;
    
            $defaults = array(
                    'format'    => 'name',
                    'separator' => '/',
                    'inclusive' => true,
            );
    
            $args = wp_parse_args( $args, $defaults );
    
            foreach ( array(  'inclusive' ) as $bool ) {
                $args[ $bool ] = wp_validate_boolean( $args[ $bool ] );
            }
    
            $parents = get_ancestors( $term_id, $taxonomy, 'taxonomy' );
            
            if ( $args['inclusive'] ) {
                array_unshift( $parents, $term_id );
            }
        
            $a = count($parents) - 1;
            foreach ( array_reverse( $parents ) as $index => $term_id ) {
                $parent = get_term( $term_id, $taxonomy );
                $temp_sep = $args['separator'];
                $lastElement = reset($parents);
                $first = end($parents);
                
                if($index == $a - 1){
                    $temp_sep = '';
                }
                if( $term_id != $lastElement){
                    $name   = $parent->name;
                    $list .= $name . $temp_sep;  
                }         
            }
    
            return $list;
        }  

        public static function categories_suggester() {
            $content = array();

            $categories = get_categories();
            foreach ( $categories as $cat ) {
                $args = array(
                  'separator' => ' > ',
                  'format'    => 'name',          
                );
                $parent = self::get_term_parents_list( $cat->cat_ID, 'category', array());
                
                $content[(string) $cat->slug] = $cat->cat_name.(!empty($parent) ? esc_html__(' (Parent categories: (', 'inpulse-core') .$parent.'))' : "");
            }
            return $content;  
        }



        /**
         * @param query tags
         *
         * @since 1.0
         * @return array
         */
        public static function tags_suggester(){

            $content = array();
            $tags = get_tags();
            foreach ( $tags as $tag ) {                
                $content[(string) $tag->slug] = $tag->name;
            }

            return $content;           
        }


        public static function getTaxonomies(){
            $taxonomy_exclude = (array) apply_filters( 'get_categories_taxonomy', 'category' );
            $taxonomy_exclude[] = 'post_tag';
            $taxonomies = array();

            foreach ( get_taxonomies() as $taxonomy ) {
                if ( ! in_array( $taxonomy, $taxonomy_exclude ) ) {
                    $taxonomies[] = $taxonomy;
                }
            }
            return $taxonomies;           
        }
        
        /**
         * @param query taxonomies
         *
         * @since 1.0
         * @return array
         */
        public static function taxonomies_suggester(){
            $content = array();
            $args = array();
            $tags = get_terms( self::getTaxonomies(), $args );

            foreach ( $tags as $tag ) {
                $args = array(
                    'separator' => ' > ',
                    'format'    => 'name',          
                );
                $parent = self::get_term_parents_list( $tag->term_id, $tag->taxonomy, $args);
                $content[ $tag->taxonomy.":".$tag->slug ] = $tag->name . ' (' . $tag->taxonomy . ')'.(!empty($parent) ? esc_html__(' (Parent categories: (', 'inpulse-core') .$parent.'))' : "");

            }
            return $content;
        }


        /**
         * @param query posts
         *
         * @since 1.0
         * @return array
         */
        public static function by_posts_suggester( $array ) {
            $content = array();
            $args = array();

            if(!isset($array['post_type'])){
                $args['post_type'] = 'any';
            }else{
                $args['post_type'] = $array['post_type'];
            }
            
            $args['numberposts'] = -1;
            $posts = get_posts( $args );
            foreach ( $posts as $post ) {
                $content[$post->post_name] = $post->post_title;
            }
            return $content;
        }        

        /**
         * @param query posts
         *
         * @since 1.0
         * @return array
         */
        public static function by_author_suggester(  ) {
            $content = array();
            $users = get_users();
            foreach ( $users as $user ) {
                $content[(string) $user->ID] = (string) $user->data->user_nicename;
            }
            return $content;
        }
        
        
    }
    new Wgl_Loop_Settings();
}

/**
* Wgl Query Builder
*
*
* @class        Wgl_Query_Builder
* @version      1.0
* @category Class
* @author       WebGeniusLab
*/
if(!class_exists('Wgl_Query_Builder')){
    class Wgl_Query_Builder{
        /**
         * @since 1.0
         * @var array
         */
        private $args = array(
            'post_status' => 'publish', // show only published posts #1098
        );

        private $data_attr = array();

        private static $instance = null;
        public static function get_instance( ) {
            if ( null == self::$instance ) {
                self::$instance = new self( );
            }

            return self::$instance;
        }

        function __construct( $data ) {
            //Include Item
            foreach ( $data as $key => $value ) {
                $method = 'parse_' . $key;
                if(stripos($key,'exclude_') === false){
                    if ( method_exists( $this, $method ) ) {
                        if(!empty($value)){
                            $this->$method( $value );
                        }
                        
                    }
                }

            }

            //Exclude Item
            foreach ($data as $k => $v) {
                $method = 'parse_' . $k;
                if(stripos($k,'exclude_') !== false){
                    if ( method_exists( $this, $method ) ) {
                        if(!empty($v)){
                            $this->$method( $v );
                        }
                    }
                }
            }
        }    

        /**
         * Pages count
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_number_of_posts( $value ) {
            $this->args['posts_per_page'] = 'All' === $value ? - 1 : (int) $value;
        }

        /**
         * Sorting field
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_order_by( $value ) {
            $this->args['orderby'] = $value;
        }

        /**
         * Sorting order
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_order( $value ) {
            $this->args['order'] = $value;
        }

        /**
         * By author
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_author( $value ) {

            $value = implode(',', $value);
            $this->data_attr['author_id'] = $value;
            $this->args['author'] = $value;
        }        

        /**
         * Exclude author
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_exclude_author( $value ) {
            if(!isset($this->data_attr['author_id'])){
                return;
            }
            if(isset($this->args['author'])){
                unset($this->args['author']);
            }
            $author_id = array();
            $author_id[] = $this->data_attr['author_id'];
            $this->args['author__not_in'] = $author_id;
        }

        /**
         * By categories
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_categories( $value ) {
            if(empty($value)){
                return;
            }
            
            $this->args['category_name'] = implode(", ", (array) $value);
        }        

        /**
         * Exclude categories
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_exclude_categories( $value ) {
            if(!isset($this->args['category_name'])){
                return;
            }

            $list = explode(", ", $this->args['category_name']);

            $id_list = array();
            foreach ($list as $key => $value) {
                $idObj = get_category_by_slug($value); 
                $id_list[] = '-'.$idObj->term_id;
            }
            $id_list = implode(",", $id_list);
            $this->args['cat'] = $id_list;
            unset($this->args['category_name']);
        }

        /**
         * Get Taxonomies
         * @since 1.0
         *
         * @param $value
         */
        private function get_tax( $value ){

            $terms = (array) $value;
            $this->args['tax_query'] = array( 'relation' => 'AND' );

            $item = $id_list = array();

            $taxonomies = get_terms( Wgl_Loop_Settings::getTaxonomies() );
            foreach ($terms as $key => $value) {
                $item_t = explode(":", $value);
                if(isset($item_t[1])){
                    $idObj = get_term_by('slug', $item_t[1], $item_t[0]); 
                    $id_list[] = $idObj->term_id;  
                }
            }

            $terms = get_terms( Wgl_Loop_Settings::getTaxonomies(),
                array( 'include' => array_map( 'abs', $id_list ) ) );
            foreach ( $terms as $t ) {
                $item[ $t->taxonomy ][] = $t->slug;
            }

            return $item;
        }

        /**
         * By taxonomies
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_taxonomies( $value ) {
            if(empty($value)){
                return;
            }

            $this->data_attr['taxonomies'] = $value;
            
            $item = $this->get_tax($value);

            foreach ( $item as $taxonomy => $terms ) {
                $this->args['tax_query'][] = array(
                    'field' => 'slug',
                    'taxonomy' => $taxonomy,
                    'terms' => $terms,
                    'operator' => 'IN',
                );
            }
        }        

        /**
         * Exclude tax slugs
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_exclude_taxonomies() {
            if(!isset($this->data_attr['taxonomies'])){
                return;
            }
            if(isset($this->args['tax_query'])){
                unset($this->args['tax_query']);
            }           
            
            $value = $this->data_attr['taxonomies'];  
                
            $item = $this->get_tax($value);

            foreach ( $item as $taxonomy => $terms ) {
                $this->args['tax_query'][] = array(
                    'field' => 'slug',
                    'taxonomy' => $taxonomy,
                    'terms' => $terms,
                    'operator' => 'NOT IN',
                );
            }
        }

        /**
         * By tags slugs
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_tags( $value ) {
            if(empty($value)){
                return;
            }
            $this->data_attr['tags'] = $value;
            $in = $not_in = array();
            $tags_slugs = $value;
            foreach ( $tags_slugs as $tag ) {
                $in[] = $tag;
            }
            $this->args['tag_slug__in'] = $in;
        }

        /**
         * Exclude tags slugs
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_exclude_tags( $value ) {
            if(!isset($this->data_attr['tags'])){
                return;
            }

            $list = $this->data_attr['tags'];
            $id_list = array();
            foreach ($list as $key => $value) {
                $idObj = get_term_by('slug', $value,'post_tag');
                $id_list[] = (int) $idObj->term_id;

            }

            $this->args['tag__not_in'] = $id_list;

            unset($this->args['tag_slug__in']);
        }

        /**
         * By posts slugs
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_by_posts( $value ) {
            $in = array();
            $this->data_attr['posts_in'] = $value;
            $slugs = $value;
            if(!empty($slugs)){
                foreach ( $slugs as $slug ) {
                    $in[] = $slug;
                }
                $this->args['post_name__in'] = $in;                
            }

        }        

        /**
         * Exclude posts slugs
         * @since 1.0
         *
         * @param $value
         */
        protected function parse_exclude_any( $value ) {
            global $post;
            if(!isset($this->data_attr['posts_in'])){
                return;
            }
            if(isset($this->args['post_name__in'])){
                unset($this->args['post_name__in']);
            }

            $options = array();
            $value = $this->data_attr['posts_in'];     
            
            $list = new \WP_Query(array( 
                'post_type'             => 'any',
                'post_name__in'         => $value,
            ));
            foreach ( $list->posts as $obj ) {
                $options[] = $obj->ID;
            }
            $this->args['post__not_in'] = $options;       
        }

        /**
         * @since 1.0
         *
         * @param $id
         */
        public function excludeId( $id ) {
            if ( ! isset( $this->args['post__not_in'] ) ) {
                $this->args['post__not_in'] = array();
            }
            if ( is_array( $id ) ) {
                $this->args['post__not_in'] = array_merge( $this->args['post__not_in'], $id );
            } else {
                $this->args['post__not_in'][] = $id;
            }
        }
 
        public function build(){
            return array( $this->args, new \WP_Query( $this->args ) );
        }       
    }
}
?>