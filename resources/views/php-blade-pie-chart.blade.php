@php
$colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];
$totalPercentage = 0;
@endphp
<svg viewBox="-1 -1 2 2" style="transform: rotate(-90deg)">
    @forelse ($foodTypePercentages as $type => $percentage)
        @php
        $startAngle = $totalPercentage * 3.6;
        $endAngle = ($totalPercentage + $percentage) * 3.6;
        $largeArcFlag = $endAngle - $startAngle <= 180 ? 0 : 1;
        $startX = cos(deg2rad($startAngle));
        $startY = sin(deg2rad($startAngle));
        $endX = cos(deg2rad($endAngle));
        $endY = sin(deg2rad($endAngle));
        $color = $colors[$loop->index % count($colors)];
        $totalPercentage += $percentage;
        @endphp
        <path d="M {{ $startX }} {{ $startY }} A 1 1 0 {{ $largeArcFlag }} 1 {{ $endX }} {{ $endY }} L 0 0" 
              fill="{{ $color }}" stroke="white" stroke-width="0.01" />
    @empty
        <circle cx="0" cy="0" r="1" fill="#CCCCCC" />
    @endforelse
</svg>