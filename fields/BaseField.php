<?php
if ( !class_exists( 'BaseField' ) ) { 
    class BaseField{
        function __construct( $field, $isSubfield = false ){

            $this->field = $field;
            $this->getFunc = $isSubfield ? 'sub_field' : 'field';
            $this->name = $field['name'];
            $this->label = $field['label'];
            $this->fieldType = $field['type'];
            $this->returnFormat = $field['return_format'];
            $this->conditionalLogic = $field['conditional_logic'];

            $this->hasConditionalLogic = is_array( $this->conditionalLogic );
        } 

        public function get_conditional_statement(){
            if( $this->hasConditionalLogic ){
                $conditionalStatement = "<?php if( "; // begin if
            
                for($i = 0; $i < count( $this->conditionalLogic ); $i++ ){
                    $conditionGroup = $this->conditionalLogic[$i];

                    $conditionalStatement .= " ( ";

                    for($ii = 0; $ii < count( $conditionGroup ); $ii++ ){
                        $condition = $conditionGroup[$ii];
                        $operator = $condition['operator'];
                        $value = $condition['value'];

                        $fieldInCondition = get_field_object( $condition['field'] );
                        if( $fieldInCondition ){
                            $fieldInConditionName = $fieldInCondition['name'];
                            $conditionalStatement .= "get_field('$fieldInConditionName') $operator '$value' ";
                        }
                        // output AND if not last one
                        if( $ii + 1 != count( $conditionGroup ) ){
                            $conditionalStatement .= 'AND ';
                        }
                    }

                    $conditionalStatement .= " )";
                    
                    // output OR if not last one
                    if( $i + 1 != count( $this->conditionalLogic ) ){
                        $conditionalStatement .= ' OR';
                    }
                }

                $conditionalStatement .= " ): ?>"; // end if
                return $conditionalStatement . "\n";
            }
            return "";
        }

        public function get_conditional_close(){
            if( $this->hasConditionalLogic ){
                return "<?php endif; ?>\n";
            }
            return "";
        }

        public function get_before_code($isArray = false){
            $conditionalStatement = $this->get_conditional_statement();
            if( $isArray == true ){
                return "\n\n<?php //$this->label ?>\n$conditionalStatement\n<?php if( !empty( get_$this->getFunc('$this->name' ) ) ):\n<div class='$this->name'> ?>\n";
            }
            else{
                return "\n\n<?php //$this->label ?>\n$conditionalStatement\n<?php if( get_$this->getFunc( '$this->name' ) ): ?>\n<div class='$this->name'>\n";
            }
        }

        public function get_after_code(){
            $conditionalClose = $this->get_conditional_close();
            return "\n</div><!-- .$this->name -->\n<?php endif; ?>$conditionalClose\n\n";
        }
    }
}