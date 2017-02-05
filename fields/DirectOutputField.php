<?php
if ( !class_exists( 'DirectOutputField' ) ) { 
    require_once( plugin_dir_path( __FILE__ ) . '/BaseField.php' );
    require_once( plugin_dir_path( __FILE__ ) . '/../interfaces/iBaseField.php' );

    class DirectOutputField extends BaseField implements iBaseField{

        public function getCode(){
            return $this->get_before_code() . "<?php the_$this->getFunc( '$this->name' ) ?>" . $this->get_after_code();
        }

    }
}
