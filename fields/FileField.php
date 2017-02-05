<?php
if ( !class_exists( 'FileField' ) ) { 
    require_once( plugin_dir_path( __FILE__ ) . '/BaseField.php' );
    require_once( plugin_dir_path( __FILE__ ) . '/../interfaces/iBaseField.php' );

    class FileField extends BaseField implements iBaseField{

        public function getCode(){
            if($this->returnFormat == 'array'){
                return $this->get_before_code(true) . "<a href='<?php echo get_$this->getFunc( '$this->name' )['url']?>'>$this->label</a>" . $this->get_after_code();
            }
            if($this->returnFormat == 'url'){
                return $this->get_before_code(true) . "<a href='<?php the_$this->getFunc( '$this->name' )?>'>$this->label</a>" . $this->get_after_code();
            }
            if($this->returnFormat == 'id'){
                return $this->get_before_code(true) . "File ID = <?php the_$this->getFunc( '$this->name' ) ?>" . $this->get_after_code();
            }
        }

    }
}
