

	<h1>Register User</h1>
	<?php
	    echo $this->Form->create($user);  
	    echo $this->Form->control('username', ['class' => 'form-control']);  
	    echo $this->Form->control('email', ['class' => 'form-control']);   
	    echo $this->Form->control('password', ['class' => 'form-control']);
	    echo $this->Form->button(__('Save'), ['class' => 'btn btn-success mt-2']);
	    echo $this->Form->end();
	?>

	