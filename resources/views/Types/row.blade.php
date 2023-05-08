<div class="{{ \Mayahkw\CMS\Facades\MyCms::checkClass($blocks->options->class) }}">
    @each('my_cms::part', $blocks->blocks, 'blocks')
</div>
