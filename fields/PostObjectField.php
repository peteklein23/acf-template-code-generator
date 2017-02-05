<?php
if ( !class_exists( 'PostObjectField' ) ) { 
    require_once( plugin_dir_path( __FILE__ ) . '/BaseField.php' );
    require_once( plugin_dir_path( __FILE__ ) . '/../interfaces/iBaseField.php' );

    class PostObjectField extends BaseField implements iBaseField{

        public function getCode(){
            // TODO: Account for multiple posts
            // TODO: show post thumbnail
            if($this->returnFormat == 'object'){
                return $this->get_before_code() . "<?php echo get_$this->getFunc( '$this->name' )->post_title ?>" . $this->get_after_code();
            }
            if($this->returnFormat == 'id'){
                return $this->get_before_code() . "Post ID = <?php the_$this->getFunc( '$this->name' ) ?>" . $this->get_after_code();
            }
        }

    }
}
