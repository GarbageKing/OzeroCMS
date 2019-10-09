<div class="row mb-3">
    <div class="col-12">
        <h1>Options</h1>
    </div>
</div>

<div class="row">
<?php 

    foreach($options as $option){ 

        if($option->id == 12){
            echo '<div class="col-12"><h3>General:</h3></div>';
        }
        if($option->id == 4){
            echo '<div class="col-12"><h3>Articles:</h3></div>';
        }
        if($option->id == 6){
            echo '<div class="col-12"><h3>Sidebar:</h3></div>';
        }
        if($option->id == 2){
            echo '<div class="col-12"><h3>Public Settings:</h3></div>';
        }
        if($option->id == 15){
            echo '<div class="col-12"><h3>Footer:</h3></div>';
        }
       
        echo '<div class="col-md-6 mb-3">';
        echo $this->Form->create($option, ['url' => ['controller' => 'options', 'action' => 'edit', $option->id]]);   
        if($option->id == 1) { 
                           
            echo $this->Form->input('value', array(
                'type' => 'select',
                'options' => $fpages,              
                'name' => 'value',
                'label' => $option->name,
                'empty' => 'Articles List',
                'class' => 'form-control',
                'required' => false
            ));  
            
            
        }

        if($option->id == 2 || $option->id == 3 || $option->id == 6 || $option->id == 14 || $option->id == 15){
                             
            echo $this->Form->input('value', array(
                'type' => 'select',
                'options' => [0 => 'No', 1=>'Yes'],                
                'name' => 'value',
                'label' => $option->name,
                'class' => 'form-control'
            ));  
           
        }     
        if($option->id == 4){
                             
            echo $this->Form->input('value', array(
                'type' => 'select',
                'options' => [0 => 'List', 1=>'Grid'],                
                'name' => 'value',
                'label' => $option->name,
                'class' => 'form-control'
            ));  
           
        }     
        if($option->id == 5 || $option->id == 13){
                             
            echo $this->Form->input('value', array(
                'type' => 'number',                  
                'name' => 'value',
                'label' => $option->name . ' ' . $option->additional,
                'class' => 'form-control'
            ));  
           
        } 
        if($option->id == 7 || $option->id == 11){
                             
            if($option->id == 11){
                echo '<h4>Widget </h4>';
            }
                             
            echo $this->Form->input('value', array(
                'type' => 'textarea',                  
                'name' => 'value',
                'label' => $option->name,
                'class' => 'form-control'
            ));  
           
        } 
        if($option->id == 8 || $option->id == 9){
            
            echo '<h4>Widget </h4>';         
            echo $this->Form->input('value', array(
                'type' => 'select',
                'options' => [0 => 'Hide', 1=>'Show'],              
                'name' => 'value',
                'label' => $option->name,
                'class' => 'form-control'
            ));  
            echo $this->Form->input('additional', array(
                'type' => 'number',                  
                'name' => 'additional',
                'label' => 'Number of '.$option->name.' to show',
                'class' => 'form-control'
            )); 
           
        } 

        if($option->id == 10){
            
            echo '<h4>Widget </h4>';         
            echo $this->Form->input('value', array(
                'type' => 'select',
                'options' => [0 => 'Hide', 1=>'Show'],              
                'name' => 'value',
                'label' => $option->name,
                'class' => 'form-control'
            ));  
            echo $this->Form->input('additional', array(
                'type' => 'select',
                'options' => [0 => 'Hide', 1=>'Show'],              
                'name' => 'additional',
                'label' => 'Display tags with no posts',
                'class' => 'form-control'
            ));  
           
        } 

        if($option->id == 12){
                        
            echo $this->Form->input('value', array(
                'type' => 'text',                          
                'name' => 'value',
                'label' => $option->name,
                'class' => 'form-control'
            ));  
           
        }

        if($option->id == 16){
                        
            echo $this->Form->input('value', array(
                'type' => 'text',                              
                'name' => 'value',
                'label' => 'Receiver',
                'class' => 'form-control'
            ));  
            echo $this->Form->input('additional', array(
                'type' => 'select',
                'options' => [0 => 'No', 1=>'Yes'],              
                'name' => 'additional',
                'label' => 'Enable emailing',
                'class' => 'form-control'
            ));  
           
        }
        
        echo $this->Form->button(__('Save'), ['class' => 'btn btn-success mt-2']);
        echo $this->Form->end();
        
        echo '</div>';
        if($option->id == 6 || $option->id == 1 || $option->id == 13){
            echo '<div class="col-md-6 mb-3"></div>';
        }
    }

?>

</div>
