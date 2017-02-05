<?php
if ( !class_exists( 'TrueFalseField' ) ) { 
    require_once( plugin_dir_path( __FILE__ ) . '/BaseField.php' );
    require_once( plugin_dir_path( __FILE__ ) . '/../interfaces/iBaseField.php' );

    class TrueFalseField extends BaseField implements iBaseField{

        public function getCode(){
            return $this->get_before_code() . "<?php echo ( get_$this->getFunc( '$this->name' ) ) ? 'True' : 'False' ?>" . $this->get_after_code();
        }

    }
}
