<?php   
if ( !class_exists( 'ACFTemplateCode' ) ) { 
    class ACFTemplateCode{
        public $fieldType;

        public $isIgnoredOutputType;
        public $ignoredOutputTypes = [
            'message',
            'tab',
        ];

        function __construct( $field, $isSubfield = false ){

            define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
            require_once( MY_PLUGIN_PATH . '/fields/DirectOutputField.php' );
            require_once( MY_PLUGIN_PATH . '/fields/ImageField.php' );
            require_once( MY_PLUGIN_PATH . '/fields/TrueFalseField.php' );
            require_once( MY_PLUGIN_PATH . '/fields/FileField.php' );
            require_once( MY_PLUGIN_PATH . '/fields/UrlField.php' );
            require_once( MY_PLUGIN_PATH . '/fields/GalleryField.php' );
            require_once( MY_PLUGIN_PATH . '/fields/OEmbedField.php' );
            require_once( MY_PLUGIN_PATH . '/fields/ColorPickerField.php' );
            require_once( MY_PLUGIN_PATH . '/fields/UserField.php' );
            require_once( MY_PLUGIN_PATH . '/fields/PostObjectField.php' );
            require_once( MY_PLUGIN_PATH . '/fields/RelationshipField.php' );
            require_once( MY_PLUGIN_PATH . '/fields/TaxonomyField.php' );
            require_once( MY_PLUGIN_PATH . '/fields/PageLinkField.php' );
            require_once( MY_PLUGIN_PATH . '/fields/RepeaterField.php' );
            require_once( MY_PLUGIN_PATH . '/fields/FlexibleContentField.php' );
            require_once( MY_PLUGIN_PATH . '/fields/CloneField.php' );

            $this->field = $field;
            $this->fieldType = $field['type'];

            $this->isIgnoredOutputType = in_array( $this->fieldType, $this->ignoredOutputTypes );
        } 

        public function get_code(){
            $field = false;
            if( !$this->isIgnoredOutputType ){
                switch( $this->fieldType ){
                    case "image":
                        $field = new ImageField( $this->field );
                        break;
                    case "true_false":
                        $field = new TrueFalseField( $this->field );
                        break;
                    case "file":
                        $field = new FileField( $this->field );
                        break;
                    case "url":
                        $field = new UrlField( $this->field );
                        break;
                    case "gallery":
                        $field = new GalleryField( $this->field );
                        break;
                    case "oembed":
                        $field = new OEmbedField( $this->field );
                        break;
                    case "color_picker":
                        $field = new ColorPickerField( $this->field );
                        break;
                    case "user":
                        $field = new UserField( $this->field );
                        break;
                    case "post_object":
                        $field = new PostObjectField( $this->field );
                        break;
                    case "relationship":
                        $field = new RelationshipField( $this->field );
                        break;
                    case "taxonomy":
                        $field = new TaxonomyField( $this->field );
                        break;
                    case "page_link":
                        $field = new PageLinkField( $this->field );
                        break;
                    case "repeater":
                        $field = new RepeaterField( $this->field );
                        break;
                    case "flexible_content":
                        $field = new FlexibleContentField( $this->field );
                        break;
                    case "clone":
                        $field = new CloneField( $this->field );
                        break;
                    default:
                        $field = new DirectOutputField( $this->field );
                }
                if( $field ){
                    return $field->getCode();
                }
            }
        }
    }
}
?>