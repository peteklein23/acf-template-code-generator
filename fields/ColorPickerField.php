<?php
if ( !class_exists( 'ColorPickerField' ) ) { 
    require_once( plugin_dir_path( __FILE__ ) . '/BaseField.php' );
    require_once( plugin_dir_path( __FILE__ ) . '/../interfaces/iBaseField.php' );

    class ColorPickerField extends BaseField implements iBaseField{

        public function getCode(){
            return $this->get_before_code() . "<span style='color:<?php the_$this->getFunc( '$this->name' ) ?>'>
<?php the_$this->getFunc( '$this->name' ) ?>
</span>" . $this->get_after_code();
        }

    }
}
