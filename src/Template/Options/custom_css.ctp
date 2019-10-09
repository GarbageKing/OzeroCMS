<?php

	echo $this->Form->create(null, ['url'=>['controller' => 'options', 'action' => 'customCss']]);   
    echo $this->Form->input(null, array(
	    'type' => 'textarea',                  
	    'name' => 'usercss',
	    'label' => 'Custom CSS',
	    'value' => $usercss->usercss,
	    'class' => 'form-control',
	    'rows' => 20
	));  
    echo $this->Form->button(__('Save'), ['class' => 'btn btn-success mt-2']);
    echo $this->Form->end();
?>
