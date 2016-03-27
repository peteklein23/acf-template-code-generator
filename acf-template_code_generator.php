<?php
/**
 * @package ACF_Template_Code_Generator
 * @version 1.0
 */
/*
Plugin Name: Advanced Custom Fields: Template Code Generator
Plugin URI: http://peteklein.com/
Description: Creates the the base template code for an entire advanced custom field group.
Author: Pete Klein
Version: 1.0
Author URI: http://peteklein.com
*/
/*
phpinfo();`
die();
*/

add_action('admin_menu', 'acf_template_plugin_setup_menu');

function acf_template_plugin_setup_menu(){
    add_menu_page( 'Custom Fields Template Code Page', 'Custom Fields Template Code', 'manage_options', 'custom-fields-template-code-plugin', 'acf_template_code_init' );
}

class ACFFieldTemplate{
    public $name;
    public $label;
    public $fieldType;
    public $returnFormat;

    private $isIgnoredOutputType;
    private $ignoredOutputTypes = [
        'message',
        'tab',
    ];
    private $hasConditionalLogic;

    function __construct($field, $isSubfield = false){
        $this->field = $field;
        $this->getFunc = $isSubfield ? 'sub_field' : 'field';
        $this->name = $field['name'];
        $this->label = $field['label'];
        $this->fieldType = $field['type'];
        $this->returnFormat = $field['return_format'];
        $this->conditionalLogic = $field['conditional_logic'];

        $this->isIgnoredOutputType = in_array($this->fieldType, $this->ignoredOutputTypes);
        $this->hasConditionalLogic = is_array($this->conditionalLogic);
    } 

    public function get_code(){
        if(!$this->isIgnoredOutputType){
            switch($this->fieldType){
                case "image":
                    return $this->get_image_code();
                    break;
                case "true_false":
                    return $this->get_true_false_code();
                    break;
                case "file":
                    return $this->get_file_code();
                    break;
                case "url":
                    return $this->get_url_code();
                    break;
                case "gallery":
                    return $this->get_gallery_code();
                    break;
                case "oembed":
                    return $this->get_oembed_code();
                    break;
                case "date_picker":
                    return $this->get_date_picker_code();
                    break;
                case "date_time_picker":
                    return $this->get_date_time_picker_code();
                    break;
                case "color_picker":
                    return $this->get_color_picker_code();
                    break;
                case "user":
                    return $this->get_user_code();
                    break;
                case "post_object":
                    return $this->get_post_object_code();
                    break;
                case "relationship":
                    return $this->get_relationship_code();
                    break;
                case "taxonomy":
                    return $this->get_taxonomy_code();
                    break;
                case "page_link":
                    return $this->get_page_link_code();
                    break;
                case "repeater":
                    return $this->get_repeater_code();
                    break;
                case "flexible_content":
                    return $this->get_flexible_content_code();
                    break;

               default:
                    return $this->get_direct_output_code();
            }
        }
    }

    private function get_conditional_statement(){
        if($this->hasConditionalLogic){
            $conditionalStatement = "<?php if("; // begin if
        
            for($i = 0; $i < count($this->conditionalLogic); $i++){
                $conditionGroup = $this->conditionalLogic[$i];

                $conditionalStatement .= " ( ";

                for($ii = 0; $ii < count($conditionGroup); $ii++){
                    $condition = $conditionGroup[$ii];
                    $operator = $condition['operator'];
                    $value = $condition['value'];

                    $fieldInCondition = get_field_object($condition['field']);
                    if($fieldInCondition){
                        $fieldInConditionName = $fieldInCondition['name'];
                        $conditionalStatement .= "get_field('$fieldInConditionName') $operator '$value' ";
                    }
                    // output AND if not last one
                    if($ii + 1 != count($conditionGroup)){
                        $conditionalStatement .= 'AND ';
                    }
                }

                $conditionalStatement .= " )";
                
                // output OR if not last one
                if($i + 1 != count($this->conditionalLogic)){
                    $conditionalStatement .= ' OR';
                }
            }

            $conditionalStatement .= " ): ?>"; // end if
            return $conditionalStatement . "\n";
        }
        else{
            return "";
        }
    }

    private function get_conditional_close(){
        if($this->hasConditionalLogic){
            return "<?php endif; ?>\n";
        }
        else{
            return "";
        }
    }

    private function get_before_code($isArray = false){
        $conditionalStatement = $this->get_conditional_statement();
        if($isArray == true){
            return "$conditionalStatement<strong>$this->label</strong>\n<br>\n<?php if(!empty(get_$this->getFunc('$this->name'))): ?>\n";
        }
        else{
            return "$conditionalStatement<strong>$this->label</strong>\n<br>\n<?php if(get_$this->getFunc('$this->name')): ?>\n";
        }
    }

    private function get_after_code(){
        $conditionalClose = $this->get_conditional_close();
        return "\n    <br>\n<?php endif; ?>\n<hr>\n\n$conditionalClose";
    }

    private function get_direct_output_code(){
        return $this->get_before_code() . "    <?php the_$this->getFunc('$this->name') ?>" . $this->get_after_code();
    }

    private function get_true_false_code(){
        return $this->get_before_code() . "    <?php echo (get_$this->getFunc('$this->name')) ? 'True' : 'False' ?>" . $this->get_after_code();
    }

    private function get_image_code(){
        if($this->returnFormat == 'array'){
            return $this->get_before_code(true) . "    <img src='<?php echo get_$this->getFunc('$this->name')['url']?>' alt='<?php the_$this->getFunc('$this->name')['alt']?>' />" . $this->get_after_code();
        }
        if($this->returnFormat == 'url'){
            return $this->get_before_code() . "    <img src='<?php the_$this->getFunc('$this->name')?>' alt='' />" . $this->get_after_code();
        }
        if($this->returnFormat == 'id'){
            return $this->get_before_code() . "    <?php the_$this->getFunc('$this->name') ?>" . $this->get_after_code();
        }
    }

    private function get_file_code(){
        if($this->returnFormat == 'array'){
            return $this->get_before_code(true) . "    <a href='<?php echo get_$this->getFunc('$this->name')['url']?>'>$this->label</a>" . $this->get_after_code();
        }
        if($this->returnFormat == 'url'){
            return $this->get_before_code(true) . "    <a href='<?php the_$this->getFunc('$this->name')?>'>$this->label</a>" . $this->get_after_code();
        }
        if($this->returnFormat == 'id'){
            return $this->get_before_code(true) . "    File ID = <?php the_$this->getFunc('$this->name') ?>" . $this->get_after_code();
        }
    }

    private function get_url_code(){
        return $this->get_before_code() . "    <a href='<?php the_$this->getFunc('$this->name')?>'>$this->label</a>" . $this->get_after_code();
    }

    private function get_gallery_code(){
        return $this->get_before_code() . "    <?php foreach( get_$this->getFunc('$this->name') as \$image ): ?>
        <a href='<?php echo \$image['url']; ?>'>
            <img src='<?php echo \$image['sizes']['thumbnail']; ?>' alt='<?php echo \$image['alt']; ?>' />
        </a>
        <br>
    <?php endforeach; ?>" . $this->get_after_code();
    }

    private function get_oembed_code(){
        return $this->get_before_code(true) . "    <div class='embed-container'>
    <div class='embed-container'>
        <?php the_$this->getFunc('$this->name'); ?>
    </div>
    <style>
        .embed-container { 
            position: relative; 
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            max-width: 100%;
            height: auto;
        } 

        .embed-container iframe,
        .embed-container object,
        .embed-container embed { 
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>" . $this->get_after_code();
    }

    private function get_date_picker_code(){
        return $this->get_before_code() . "    <?php the_$this->getFunc('$this->name') ?>" . $this->get_after_code();
    }

    private function get_date_time_picker_code(){
        return $this->get_before_code() . "    <?php echo date('l, F jS, g:ia', get_$this->getFunc('$this->name')) ?>" . $this->get_after_code();
    }

    private function get_color_picker_code(){
        return $this->get_before_code() . "    <span style='color:<?php the_$this->getFunc('$this->name') ?>'>
        <?php the_$this->getFunc('$this->name') ?>
    </span>" . $this->get_after_code();
    }

    private function get_user_code(){
        return $this->get_before_code() . "    <?php echo get_$this->getFunc('$this->name')['user_nicename'] ?>" . $this->get_after_code();
    }

    private function get_post_object_code(){
        if($this->returnFormat == 'object'){
            return $this->get_before_code() . "    <?php echo get_$this->getFunc('$this->name')->post_title ?>" . $this->get_after_code();
        }
        if($this->returnFormat == 'id'){
            return $this->get_before_code() . "    Post ID = <?php the_$this->getFunc('$this->name') ?>" . $this->get_after_code();
        }
    }

    private function get_relationship_code(){
        //return $this->get_before_code() . "  
        if($this->returnFormat == 'object'){
            return $this->get_before_code() . "    <?php \$posts = get_$this->getFunc('$this->name'); ?>
    <?php foreach( \$posts as \$post): ?>
        <?php setup_postdata(\$post); ?>
        <a href='<?php the_permalink(); ?>'><?php the_title(); ?></a>
        <span>Custom field from \$post: <?php the_$this->getFunc('author'); ?></span>
        <br>
    <?php endforeach; ?>
    <?php wp_reset_postdata(); ?>" . $this->get_after_code();
        }
        if($this->returnFormat == 'id'){
            return $this->get_before_code() . "    <?php foreach( get_$this->getFunc('$this->name') as \$postID): ?>
        Relationship ID = <?= \$postID ?>
        <br>
    <?php endforeach; ?>" . $this->get_after_code();
        }
    }

    private function get_taxonomy_code(){
        //return $this->get_before_code() . "  
        if($this->returnFormat == 'object'){
            return $this->get_before_code() . "    <?php foreach( get_$this->getFunc('$this->name') as \$term ): ?>
        <?php echo \$term->name; ?>
        <br>
        <?php echo \$term->description; ?>
        <a href='<?php echo get_term_link( \$term ); ?>'>View all '<?php echo \$term->name; ?>' posts</a>

    <?php endforeach; ?>" . $this->get_after_code();
        }
        if($this->returnFormat == 'id'){
            return $this->get_before_code() . "    <?php foreach( get_$this->getFunc('$this->name') as \$postID): ?>
        Taxonomy ID = <?= \$postID ?>
        <br>
    <?php endforeach; ?>" . $this->get_after_code();
        }
    }

    private function get_page_link_code(){
        return $this->get_before_code() . "    <a href='<?php the_$this->getFunc('$this->name')?>'>$this->label</a>" . $this->get_after_code();
    }

    private function get_repeater_code(){
        // get list of subfields
        $subfields = $this->field['sub_fields'];
        $returnText = '';

        $returnText .= $this->get_before_code() . "    <?php if( have_rows('$this->name') ): ?>
        <?php while ( have_rows('$this->name') ) : the_row(); ?>";
        foreach($subfields as $subfield){
            $subfieldObj = new ACFFieldTemplate($subfield, true);
            $returnText .= $subfieldObj->get_code();
        }
        $returnText .= "
        <?php endwhile;?>
    <?php endif;?>
        " . $this->get_after_code();

        return $returnText;
    }

    private function get_flexible_content_code(){
        // get layouts
        $layouts = $this->field['layouts'];
        $returnText = '';

        $returnText .= $this->get_before_code() . "    <?php if( have_rows('$this->name') ): ?>
        <?php while ( have_rows('$this->name') ) : the_row(); ?>";
        foreach($layouts as $layout){
            $returnText .= "
            <?php if(get_row_layout() == '" . $layout['name'] . "') : ?>";
            $subfields = $layout['sub_fields'];
            foreach($subfields as $subfield){
                $subfieldObj = new ACFFieldTemplate($subfield, true);
                $returnText .= $subfieldObj->get_code();
            }
            $returnText .= "
            <?php endif; ?>";
        }
        $returnText .= "
        <?php endwhile;?>
    <?php endif;?>
        " . $this->get_after_code();

        return $returnText;
    }
}

// contains if statement and conditional logic

function get_field_template_code($field){

    // TODO: Google Maps

    // TODO: Flexible Content


}

function acf_template_code_init(){

    $groups = acf_get_field_groups();

    if(count($groups) > 0){
        foreach($groups as $group){
            echo "<h2>" . $group['title'] . "</h2>";
            echo $group['ID'];
            $fields = acf_get_fields($group['ID']);

            //if(count($fields) > 0 && $group['ID'] == 18744){
                /*echo "<pre>";
                print_r($fields);
                echo "</pre>";
                die();*/

                echo "<textarea style='display:block; width:100%; height:500px; font-family:courier new'>";
                foreach($fields as $field){
                    $fieldTemplate = new ACFFieldTemplate($field);
                    echo $fieldTemplate->get_code();
                }
                echo "</textarea>";
            //}
        }
    }
}

?>
