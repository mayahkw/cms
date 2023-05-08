<div id="carousel {{ $blocks->id }}" class="{{ \Mayahkw\CMS\Facades\MyCms::checkClass($blocks->options->class) }}"
    data-bs-ride="carousel">
    @if ($blocks->options->options[2]->default == true)
        <div class="carousel-indicators">
            @php
                $i = 0;
            @endphp
            @foreach ($blocks->value->value as $scr)
                @php
                    $current = $i == 0 ? 'aria-current="true"' : '';
                    $active = $i == 0 ? 'class="active"' : '';
                    $i++;
                @endphp
                <button type="button" data-bs-target="#carousel{{ $blocks->id }}" data-bs-slide-to="{{ $i }}"
                    {!! $active !!} {!! $current !!} aria-label="Slide {{ $i }}">
                </button>
            @endforeach
        </div>
    @endif


    <div class="carousel-inner">
        @php
            $i = 0;
        @endphp
        @foreach ($blocks->value->value as $src)
            @php
                $current = $i == 0 ? true : false;
                $active = $i == 0 ? 'active' : '';
                $i++;
            @endphp
            <div class="carousel-item {{ $active }}">
                @if (count($src->img) > 0)
                    <img src="/{{ $src->img[0]->dir }}/{{ $src->img[0]->name }}" class="d-block w-100"
                        alt="{{ $src->description }}" />
                @endif
                @if ($blocks->options->options[0]->default == true || $blocks->options->options[1]->default == true)
                    <div class="carousel-caption d-none d-md-block">
                        @if ($blocks->options->options[0]->default == true)
                            <h5> {{ $src->title }} </h5>
                        @endif
                        @if ($blocks->options->options[1]->default === true)
                            <p> {{ $src->description }} </p>
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $blocks->id }}"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $blocks->id }}"
        data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>

    @each('my_cms::part', $blocks->blocks, 'blocks')
</div>
