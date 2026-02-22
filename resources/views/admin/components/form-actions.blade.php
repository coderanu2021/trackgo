{{-- 
    Admin Form Actions Component
    Usage: @include('admin.components.form-actions', [
        'formId' => 'my-form',
        'submitText' => 'Save Product',
        'cancelRoute' => route('admin.products.index'),
        'showPreview' => false,
        'previewRoute' => null
    ])
--}}

@php
    $formId = $formId ?? 'main-form';
    $submitText = $submitText ?? 'Save Changes';
    $cancelRoute = $cancelRoute ?? url()->previous();
    $showPreview = $showPreview ?? false;
    $previewRoute = $previewRoute ?? null;
@endphp

<div class="form-actions-bottom">
    <div class="form-actions-container">
        <div class="form-actions-left">
            <a href="{{ $cancelRoute }}" class="btn btn-secondary">
                <i class="fas fa-times"></i>
                Cancel
            </a>
        </div>
        
        <div class="form-actions-right">
            @if($showPreview && $previewRoute)
                <a href="{{ $previewRoute }}" target="_blank" class="btn btn-outline">
                    <i class="fas fa-eye"></i>
                    Preview
                </a>
            @endif
            
            <button form="{{ $formId }}" type="submit" class="btn btn-primary">
                <i class="fas fa-check"></i>
                {{ $submitText }}
            </button>
        </div>
    </div>
</div>

<style>
    .form-actions-bottom {
        position: sticky;
        bottom: 0;
        left: 0;
        right: 0;
        background: white;
        border-top: 2px solid #e5e7eb;
        padding: 1.5rem 2rem;
        margin: 2rem -2rem -2rem -2rem;
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
        z-index: 100;
    }

    .form-actions-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1400px;
        margin: 0 auto;
    }

    .form-actions-left,
    .form-actions-right {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #6b7280;
        border: 1px solid #e5e7eb;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
        color: #374151;
    }

    .btn-outline {
        background: white;
        color: var(--primary);
        border: 2px solid var(--primary);
    }

    .btn-outline:hover {
        background: var(--primary);
        color: white;
    }

    @media (max-width: 768px) {
        .form-actions-container {
            flex-direction: column;
            gap: 1rem;
        }

        .form-actions-left,
        .form-actions-right {
            width: 100%;
            justify-content: center;
        }

        .form-actions-bottom {
            padding: 1rem;
            margin: 1rem -1rem -1rem -1rem;
        }
    }
</style>
