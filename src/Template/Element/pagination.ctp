<nav aria-label="Page navigation">
    <ul class="pagination">
        <?php
        $this->Paginator->templates([
            'prevActive' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>'
        ]);
        $this->Paginator->templates([
            'prevDisabled' => '' //<li class="page-item disabled"><a class="page-link" href="{{url}}">{{text}}</a></li>
        ]);
        ?>
        <?= $this->Paginator->prev('<') ?>
        <?php
        $this->Paginator->templates([
            'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
            'current' => '<li class="page-item active"><a class="page-link" href="{{url}}">{{text}}</a></li>',
        ]);
        ?>
        <?= $this->Paginator->numbers() ?>
        <?php
        $this->Paginator->templates([
            'nextActive' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>'
        ]);
        $this->Paginator->templates([
            'nextDisabled' => '' //<li class="page-item disabled"><a class="page-link" href="{{url}}">{{text}}</a></li> 
        ]);
        ?>
        <?= $this->Paginator->next('>') ?>
    </ul>
</nav>