<div id="{{ $blocks->id }}" class="{{ \Mayahkw\CMS\Facades\MyCms::checkClass($blocks->options->class) }}">
    {!! $blocks->value->value !!}
    @each('my_cms::part', $blocks->blocks, 'blocks')
</div>
