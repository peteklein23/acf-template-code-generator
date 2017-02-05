<?php
if ( !class_exists( 'GalleryField' ) ) { 
    require_once( plugin_dir_path( __FILE__ ) . '/BaseField.php' );
    require_once( plugin_dir_path( __FILE__ ) . '/../interfaces/iBaseField.php' );

    class GalleryField extends BaseField implements iBaseField{

        public function getCode(){
            return $this->get_before_code() . "<?php foreach( get_$this->getFunc( '$this->name' ) as \$image ): ?>
<a href='<?php echo \$image['url']; ?>'>
<img src='<?php echo \$image['sizes']['thumbnail']; ?>' alt='<?php echo \$image['alt']; ?>' />
</a>
<br>
<?php endforeach; ?>" . $this->get_after_code();
        }

    }
}
