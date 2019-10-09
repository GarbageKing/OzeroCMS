<div class="row">
    <div class="col-12">
        <h1>Menus</h1>
    </div>
</div>

<div class="row menu-items">
    <div class="col-12">
<?php 

    foreach($items as $item){
        
        echo $this->Form->create($item, ['url' => ['controller' => 'menus', 'action' => 'edit', $item->id]]); 
        echo '<div class="row">';
        echo '<div class="col-md-3">';
        echo $this->Form->control('name', ['class' => 'form-control']);
        echo '</div>';
        echo '<div class="col-md-3">';
        echo $this->Form->control('url', ['class' => 'form-control']);   
        echo '</div>';    
        echo '<div class="col-md-3">';                     
        echo $this->Form->input('placement', array(
            'type' => 'select',
            'options' => [0 => 'top', 1=>'side', 2=>'bottom'],         
            'name' => 'placement',
            'label' => 'Placement',
            'class' => 'form-control'
        ));      
        echo '</div>';  
        echo '<div class="col-md-3">';      
        echo $this->Form->input('new_tab', array(
            'type' => 'select',
            'options' => [0 => 'No', 1=>'Yes'],         
            'name' => 'new_tab',
            'label' => 'Open in a new tab',
            'class' => 'form-control'
        ));     
        echo '</div>';
        echo '<div class="col-12">';
        echo $this->Form->button(__('Save'), ['class' => 'btn btn-sm btn-success mt-2']);
        
        echo $this->Form->end();

        echo $this->Form->postLink(
        'Delete',
        ['controller' => 'menus', 'action' => 'delete', $item->id],
        ['class' => 'btn btn-sm btn-danger', 'confirm' => 'Are you sure?']);  
        echo '</div>';                  
        echo '</div>';
    }
?>
<br>
<h3>Add New Item</h3>
<?php 

    echo $this->Form->create($item_new, ['url' => ['controller' => 'menus', 'action' => 'add']]); 
    echo '<div class="row">';
    echo '<div class="col-md-3">';
    echo $this->Form->control('name', ['class' => 'form-control']);
    echo '</div>';
    echo '<div class="col-md-3">';
    echo $this->Form->control('url', ['class' => 'form-control']);       
    echo '</div>';    
    echo '<div class="col-md-3">';                 
    echo $this->Form->input('placement', array(
        'type' => 'select',
        'options' => [0 => 'top', 1=>'side', 2=>'bottom'],         
        'name' => 'placement',
        'label' => 'Placement',
        'class' => 'form-control'
    ));    
    echo '</div>';  
    echo '<div class="col-md-3">';     
    echo $this->Form->input('new_tab', array(
        'type' => 'select',
        'options' => [0 => 'No', 1=>'Yes'],         
        'name' => 'new_tab',
        'label' => 'Open in a new tab',
        'class' => 'form-control'
    ));  
    echo '</div>';
    echo '<div class="col-12">';
    echo $this->Form->button(__('Save'), ['class' => 'btn btn-sm btn-success mt-2']);
    echo $this->Form->end();
    echo '</div>';                  
    echo '</div>';

?>

    </div>
</div>

