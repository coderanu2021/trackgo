{{-- Category Dropdown Component --}}
<div class="cat-dropdown-list">
    @foreach($categories as $category)
        @if($category->parent_id == null)
            <div class="category-item" style="position: relative;">
                <a href="{{ route('category.show', $category->slug) }}" class="cat-link">
                    <span style="display:flex; align-items:center; gap:0.75rem;">
                        @if($category->icon) 
                            <i class="{{ $category->icon }}" style="width:20px; text-align:center;"></i> 
                        @endif
                        {{ $category->name }}
                    </span>
                    @if($category->children->count() > 0)
                        <i class="fas fa-chevron-right category-arrow" style="font-size: 0.7rem; color: #ccc; transition: all 0.3s ease;"></i>
                    @endif
                </a>
                
                @if($category->children->count() > 0)
                    <div class="subcategory-dropdown">
                        @foreach($category->children as $child)
                            <a href="{{ route('category.show', $child->slug) }}" class="cat-link" style="border-bottom: 1px solid var(--border-soft); font-size: 0.85rem;">
                                <span style="display:flex; align-items:center; gap:0.75rem;">
                                    @if($child->icon)
                                        <i class="{{ $child->icon }}" style="width:16px; text-align:center; color: var(--primary);"></i>
                                    @else
                                        <i class="fas fa-arrow-right" style="width:16px; text-align:center; color: var(--text-muted); font-size: 0.6rem;"></i>
                                    @endif
                                    {{ $child->name }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    @endforeach
</div>
