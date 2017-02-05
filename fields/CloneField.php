<?php
if ( !class_exists( 'CloneField' ) ) { 
    require_once( plugin_dir_path( __FILE__ ) . '/BaseField.php' );
    require_once( plugin_dir_path( __FILE__ ) . '/../interfaces/iBaseField.php' );

    class CloneField extends BaseField implements iBaseField{
        // TODO: Account for name and display prefixing
        // TODO: Account for Group vs Seamless
        public function getCode(){
            foreach( $this->field['clone'] as $selector ) {
                // field group
                if( acf_is_field_group_key( $selector ) ) {
                    // vars
                    $field_group = acf_get_field_group( $selector );
                    $field_group_fields = acf_get_fields( $field_group );

                    if( !empty( $field_group_fields ) ){
                        foreach($field_group_fields as $clone_field){
                            $fieldTemplate = new ACFTemplateCode( $clone_field );
                            echo $fieldTemplate->get_code();
                        }
                    }
                    
                // field
                } elseif( acf_is_field_key( $selector ) ) {
                    $clone_field = acf_get_field( $selector );
                    $fieldTemplate = new ACFTemplateCode( $clone_field );
                    echo $fieldTemplate->get_code();
                }
                
            }
        }

    }
}
