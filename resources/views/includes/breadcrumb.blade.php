<nav class="container">
    <ol class="breadcrumb">
        <?php $i=0; ?>
        @foreach($breadcrumbs as $breadcrumb)
            <li class="breadcrumb-item {{ $i+1==count($breadcrumbs)?'active':'' }}">
                <a {{ $i+1==count($breadcrumbs)?'':'href='.$breadcrumb['url'] }}>
                  {{ $breadcrumb['title'] }}</a>
            </li>
            <?php $i++; ?>
        @endforeach
    </ol>
</nav>
