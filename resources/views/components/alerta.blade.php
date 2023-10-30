<div class="alert alert-{{ $type }} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    @if ($title !== "")
    <h5>
        @switch($type)
            @case("danger")
                <i class="icon fas fa-ban"></i>
                @break

            @case("alert")
                <i class="icon fas fa-info"></i>
                @break

            @case("warning")
                <i class="icon fas fa-exclamation-triangle"></i>
                @break

            @case("success")
                <i class="icon fas fa-check"></i>
                @break
            @default
                
        @endswitch
        
        {{ $title }}
    </h5>
    @endif

    {{ $description }}
</div>