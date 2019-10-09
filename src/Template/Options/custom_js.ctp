<?php

	echo $this->Form->create(null, ['url'=>['controller' => 'options', 'action' => 'customJs']]);   
    echo $this->Form->input(null, array(
	    'type' => 'textarea',                  
	    'name' => 'userjs',
	    'label' => 'Custom JS',
	    'value' => $userjs->userjs,
	    'class' => 'form-control',
	    'rows' => 20
	));  
    echo $this->Form->button(__('Save'), ['class' => 'btn btn-success mt-2']);
    echo $this->Form->end();
?>
