@if (View::exists('my_cms::Types/' . $blocks->block->type))
    @include('my_cms::Types/' . $blocks->block->type)
@else
    <small> {{ $blocks->block->type }} no se puede renderizar</small> <br>
    @each('my_cms::part', $blocks->blocks, 'blocks')
@endif

@php
    /*
    function renderBlock($block)
    {
        $class = checkClass($block->options->class);
    
        echo '<div class="' . $class . '">';
        echo '<small>' . $block->id . ' ' . $block->block->name . '</small><br />';
        if (count($block->blocks) > 0) {
            foreach ($block->blocks as $b) {
                renderBlock($b);
            }
        }
        echo '</div>';
    }
    
    */
@endphp
