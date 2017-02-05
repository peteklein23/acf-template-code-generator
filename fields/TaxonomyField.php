<?php
if ( !class_exists( 'TaxonomyField' ) ) { 
    require_once( plugin_dir_path( __FILE__ ) . '/BaseField.php' );
    require_once( plugin_dir_path( __FILE__ ) . '/../interfaces/iBaseField.php' );

    class TaxonomyField extends BaseField implements iBaseField{

        public function getCode(){
            if($this->returnFormat == 'object'){
                return $this->get_before_code() . "<?php foreach( get_$this->getFunc( '$this->name' ) as \$term ): ?>
<?php echo \$term->name; ?>
<br>
<?php echo \$term->description; ?>
<a href='<?php echo get_term_link( \$term ); ?>'>View all '<?php echo \$term->name; ?>' posts</a>

<?php endforeach; ?>" . $this->get_after_code();
            }
            if($this->returnFormat == 'id'){
                return $this->get_before_code() . "<?php foreach( get_$this->getFunc( '$this->name' ) as \$postID): ?>
Taxonomy ID = <?= \$postID ?>
<br>
<?php endforeach; ?>" . $this->get_after_code();
            }
        }

    }
}
