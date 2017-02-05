<?php
if ( !class_exists( 'FlexibleContentField' ) ) { 
    require_once( plugin_dir_path( __FILE__ ) . '/BaseField.php' );
    require_once( plugin_dir_path( __FILE__ ) . '/../interfaces/iBaseField.php' );

    class FlexibleContentField extends BaseField implements iBaseField{

        public function getCode(){
            // get layouts
            $layouts = $this->field['layouts'];
            $returnText = '';

            $returnText .= $this->get_before_code() . "<?php if( have_rows( '$this->name' ) ): ?>;\n<?php while ( have_rows( '$this->name' ) ) : the_row(); ?>";
            foreach($layouts as $layout){
                $returnText .= "\n<?php if( get_row_layout() == '" . $layout['name'] . "' ) : ?>";
                $subfields = $layout['sub_fields'];
                foreach( $subfields as $subfield ){
                    $subfieldObj = new ACFTemplateCode( $subfield, true );
                    $returnText .= $subfieldObj->get_code();
                }
                $returnText .= "\n<?php endif; ?>";
            }
            $returnText .= "\n<?php endwhile;?>\n<?php endif;?>
            " . $this->get_after_code();

            return $returnText;
        }

    }
}
