<?php
if ( !class_exists( 'UserField' ) ) { 
    require_once( plugin_dir_path( __FILE__ ) . '/BaseField.php' );
    require_once( plugin_dir_path( __FILE__ ) . '/../interfaces/iBaseField.php' );

    class UserField extends BaseField implements iBaseField{

        public function getCode(){
            // TODO: Account for multiple users
            // show user thumbnail
            return $this->get_before_code() . "<?php echo get_$this->getFunc( '$this->name' )['user_nicename'] ?>" . $this->get_after_code();
        }

    }
}
