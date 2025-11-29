@props(['items','title'=>'title','compare'=>'count','color'=>'','stats'=>[],'id'=>null])
<div class="chart-bars-extended" @if($id) id="{{ $id }}" @endif>
    @if(empty($items) || $items->isEmpty())
        <p class="no-data">No data available</p>
    @else
        @foreach($items as $item)
            <div class="bar-item-extended">
                <div class="bar-info">
                    <div class="bar-title">{{ $item->{$title} ?? '' }}</div>
                    <div class="bar-stats">
                        @foreach($stats as $s)
                            <?php $val = $item->{$s['key']} ?? ''; $suffix = $s['suffix'] ?? ''; $cls = $s['class'] ?? ''; ?>
                            <span class="{{ $cls }}">{{ $val }}{{ $suffix }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="bar-bg">
                    <div class="bar-fill {{ $color }}" data-fill="{{ $item->percent ?? 0 }}"></div>
                </div>
            </div>
        @endforeach
    @endif
</div>
