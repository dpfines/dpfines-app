@props(['title'=>'Section','light'=>false,'id'=>null])
<?php use Illuminate\Support\Str; $panelId = $id ?? 'panel-'.Str::slug($title ?? 'section'); ?>
<section class="dashboard-section expandable {{ $light ? 'bg-light' : '' }}" id="{{ $panelId }}">
    <div class="container">
        <div class="expandable-header">
            <div class="section-header">
                <h2>{{ $title }}</h2>
            </div>
            <div class="expand-controls">
                <button class="expand-toggle" aria-expanded="true" aria-controls="{{ $panelId }}-body" id="toggle-{{ $panelId }}" aria-label="Collapse section">
                    <i class="fas fa-chevron-up" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        <div class="expandable-body" id="{{ $panelId }}-body" role="region" aria-labelledby="toggle-{{ $panelId }}">
            {{ $slot }}
        </div>
    </div>
</section>
