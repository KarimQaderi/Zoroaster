<div class="metrics-body" data-class="{{ str_replace('\\','-',$class) }}">
    <span uk-icon="load"></span>
    <script>
        $(document).ready(function () {
            metrics('{{ $class }}', '{{ is_array($ranges)?key($ranges ): '' }}');
        });
    </script>
</div>