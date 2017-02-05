<?php
if ( !class_exists( 'ImageField' ) ) { 
    require_once( plugin_dir_path( __FILE__ ) . '/BaseField.php' );
    require_once( plugin_dir_path( __FILE__ ) . '/../interfaces/iBaseField.php' );

    class ImageField extends BaseField implements iBaseField{

        public function getCode(){
            if($this->returnFormat == 'array'){
                return $this->get_before_code(true) . "<img src='<?php echo get_$this->getFunc( '$this->name' )['url']?>' alt='<?php the_$this->getFunc('$this->name')['alt']?>' />" . $this->get_after_code();
            }
            if($this->returnFormat == 'url'){
                return $this->get_before_code() . "<img src='<?php the_$this->getFunc( '$this->name' )?>' alt='' />" . $this->get_after_code();
            }
            if($this->returnFormat == 'id'){
                return $this->get_before_code() . "<?php the_$this->getFunc( '$this->name' ) ?>" . $this->get_after_code();
            }
        }

    }
}
