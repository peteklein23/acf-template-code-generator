<?php
if ( !class_exists( 'UrlField' ) ) { 
    require_once( plugin_dir_path( __FILE__ ) . '/BaseField.php' );
    require_once( plugin_dir_path( __FILE__ ) . '/../interfaces/iBaseField.php' );

    class UrlField extends BaseField implements iBaseField{

        public function getCode(){
            return $this->get_before_code() . "<a href='<?php the_$this->getFunc( '$this->name' )?>'>$this->label</a>" . $this->get_after_code();
        }

    }
}
