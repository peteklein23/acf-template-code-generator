<?php
if ( !class_exists( 'RelationshipField' ) ) { 
    require_once( plugin_dir_path( __FILE__ ) . '/BaseField.php' );
    require_once( plugin_dir_path( __FILE__ ) . '/../interfaces/iBaseField.php' );

    class RelationshipField extends BaseField implements iBaseField{

        public function getCode(){
            if($this->returnFormat == 'object'){
                return $this->get_before_code() . "<?php \$posts = get_$this->getFunc( '$this->name' ); ?>
<?php foreach( \$posts as \$post): ?>
<?php setup_postdata(\$post); ?>
<a href='<?php the_permalink(); ?>'><?php the_title(); ?></a>
<span>Custom field from \$post: <?php the_$this->getFunc( 'author' ); ?></span>
<br>
<?php endforeach; ?>
<?php wp_reset_postdata(); ?>" . $this->get_after_code();
            }
            if($this->returnFormat == 'id'){
                return $this->get_before_code() . "<?php foreach( get_$this->getFunc( '$this->name' ) as \$postID): ?>
Relationship ID = <?= \$postID ?>
<br>
<?php endforeach; ?>" . $this->get_after_code();
            }
        }

    }
}
