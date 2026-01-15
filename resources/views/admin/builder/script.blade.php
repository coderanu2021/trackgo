<script>
    let editors = {};
    let allBlocks = new Map(); // Flat map for ID-based lookup

    function generateId() {
        return 'b-' + Math.random().toString(36).substr(2, 9);
    }

    function ensureIds(blockList) {
        blockList.forEach(block => {
            if (!block._id) block._id = generateId();
            allBlocks.set(block._id, block);
            if (block.type === 'columns' && block.data.columns) {
                block.data.columns.forEach(col => ensureIds(col.blocks || []));
            }
        });
    }

    function renderBlocks(container = document.getElementById('blocks-container'), blockList = blocks, isTopLevel = true) {
        if (!container) return;
        
        if (isTopLevel) {
            ensureIds(blocks);
            const emptyState = document.getElementById('empty-state');
            // Destroy existing editors before re-rendering
            Object.values(editors).forEach(editor => {
                if (editor && typeof editor.destroy === 'function') {
                    editor.destroy();
                }
            });
            editors = {};
            
            container.innerHTML = '';
            if (!blockList || blockList.length === 0) {
                if(emptyState) {
                    container.appendChild(emptyState);
                    emptyState.style.display = 'block';
                }
                document.getElementById('blocks-input').value = '[]';
                return;
            }
            if(emptyState) emptyState.style.display = 'none';
        } else {
            container.innerHTML = '';
        }

        blockList.forEach((block, index) => {
            const blockId = block._id;
            
            const el = document.createElement('div');
            el.className = 'card block-item';
            el.dataset.id = blockId;
            el.style.position = 'relative';
            el.style.borderLeft = '4px solid var(--primary-soft)';
            el.style.transition = 'all 0.3s ease';
            el.style.paddingLeft = '3rem';

            // Apply block-specific styles
            if (block.settings) {
                const s = block.settings;
                if (s.bg_color) el.style.backgroundColor = s.bg_color;
                if (s.text_color) el.style.color = s.text_color;
                if (s.padding_top) el.style.paddingTop = s.padding_top + 'rem';
                if (s.padding_bottom) el.style.paddingBottom = s.padding_bottom + 'rem';
                if (s.margin_top) el.style.marginTop = s.margin_top + 'rem';
                if (s.margin_bottom) el.style.marginBottom = s.margin_bottom + 'rem';
                if (s.font_size) el.style.fontSize = s.font_size + 'px';
                if (s.border_radius) el.style.borderRadius = s.border_radius + 'px';
            }

            // Drag Handle
            const dragHandle = document.createElement('div');
            dragHandle.className = 'drag-handle';
            dragHandle.innerHTML = '<i class="fas fa-grip-vertical" style="opacity: 0.3;"></i>';
            el.appendChild(dragHandle);

            let contentHtml = '';
            
            if (block.type === 'text') {
                contentHtml = `
                    <div class="block-label"><i class="fas fa-align-left"></i> Text Block</div>
                    <div class="form-group mb-0"><textarea id="editor-${blockId}">${block.data.content || ''}</textarea></div>
                `;
            } 
            else if (block.type === 'image') {
                contentHtml = `
                    <div class="block-label"><i class="fas fa-image"></i> Image Block</div>
                    <div class="form-row">
                        <div class="form-group"><label>Source URL</label><div class="flex gap-2">
                            <input type="url" onchange="updateBlockById('${blockId}', 'url', this.value)" value="${block.data.url || ''}" class="form-control" style="flex:1;">
                            <label class="btn btn-secondary m-0 cursor-pointer p-0 h-10 w-10 flex items-center justify-center rounded-xl">
                                <i class="fas fa-upload"></i> <input type="file" onchange="uploadImageByPath(this, '${blockId}')" accept="image/*" style="display:none;">
                            </label>
                        </div></div>
                        <div class="form-group"><label>Alt Text</label><input type="text" onchange="updateBlockById('${blockId}', 'alt', this.value)" value="${block.data.alt || ''}" class="form-control"></div>
                    </div>
                `;
            }
            else if (block.type === 'button') {
                contentHtml = `
                    <div class="block-label"><i class="fas fa-link"></i> Button Block</div>
                    <div class="form-row">
                        <div class="form-group"><label>Label</label><input value="${block.data.text || ''}" onchange="updateBlockById('${blockId}', 'text', this.value)" class="form-control"></div>
                        <div class="form-group"><label>URL</label><input value="${block.data.url || ''}" onchange="updateBlockById('${blockId}', 'url', this.value)" class="form-control"></div>
                    </div>
                `;
            }
            else if (block.type === 'columns') {
                contentHtml = `
                    <div class="block-label"><i class="fas fa-columns"></i> Multi-Column Layout</div>
                    <div class="columns-grid" style="display: grid; grid-template-columns: repeat(${block.data.columns.length}, 1fr); gap: 1.5rem; margin-top: 1rem;">
                        ${block.data.columns.map((col, colIndex) => `
                            <div class="column-container" style="border: 1px dashed var(--border-soft); border-radius: var(--radius-md); padding: 1rem; min-height: 100px; background: rgba(0,0,0,0.02);">
                                <div class="column-header" style="font-size: 0.65rem; font-weight: 800; color: var(--text-light); margin-bottom: 0.5rem; display: flex; justify-content: space-between;">
                                    COLUMN ${colIndex + 1}
                                    <button type="button" onclick="addNestedBlock('${blockId}', ${colIndex})" class="btn-icon-sm" title="Add Block to Column"><i class="fas fa-plus"></i></button>
                                </div>
                                <div id="container-${blockId}-${colIndex}" class="nested-container" data-id="${blockId}" data-col="${colIndex}"></div>
                            </div>
                        `).join('')}
                    </div>
                `;
            }
            else if (block.type === 'tabs') {
                contentHtml = `
                    <div class="block-label"><i class="fas fa-folder"></i> Tabs Block</div>
                    <div class="form-group"><label>Tabs</label>
                        <div class="mb-2">
                            ${(block.data.tabs || []).map((tab, idx) => `
                                <div class="card p-2 mb-2" style="background:var(--bg-main); border:1px solid var(--border-soft);">
                                    <div class="flex justify-between mb-2">
                                        <input class="form-control form-control-sm" style="font-weight:bold;" value="${tab.title}" onchange="updateBlockById('${blockId}', 'data.tabs.${idx}.title', this.value)">
                                        <button class="btn btn-sm text-red" onclick="removeArrayItem('${blockId}', 'tabs', ${idx})"><i class="fas fa-times"></i></button>
                                    </div>
                                    <textarea class="form-control form-control-sm" rows="2" onchange="updateBlockById('${blockId}', 'data.tabs.${idx}.content', this.value)">${tab.content}</textarea>
                                </div>
                            `).join('')}
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="addArrayItem('${blockId}', 'tabs')"><i class="fas fa-plus"></i> Add Tab</button>
                    </div>
                `;
            }
            else if (block.type === 'features') {
                contentHtml = `
                    <div class="block-label"><i class="fas fa-th-large"></i> Features Block</div>
                    <div class="form-group">
                        ${(block.data.items || []).map((item, idx) => `
                            <div class="card p-2 mb-2" style="background:var(--bg-main); border:1px solid var(--border-soft);">
                                <div class="flex justify-between mb-2">
                                    <input class="form-control form-control-sm" style="font-weight:bold;" value="${item.title}" onchange="updateBlockById('${blockId}', 'data.items.${idx}.title', this.value)">
                                    <button class="btn btn-sm text-red" onclick="removeArrayItem('${blockId}', 'items', ${idx})"><i class="fas fa-times"></i></button>
                                </div>
                                <input class="form-control form-control-sm" value="${item.description}" onchange="updateBlockById('${blockId}', 'data.items.${idx}.description', this.value)">
                            </div>
                        `).join('')}
                        <button type="button" class="btn btn-secondary btn-sm" onclick="addArrayItem('${blockId}', 'items')"><i class="fas fa-plus"></i> Add Feature</button>
                    </div>
                `;
            }
            else if (block.type === 'hero_stats') {
                contentHtml = `
                    <div class="block-label"><i class="fas fa-chart-line"></i> Hero Stats</div>
                    <div class="form-row">
                        <div class="form-group col-md-6"><label>Title</label><input class="form-control" value="${block.data.title || ''}" onchange="updateBlockById('${blockId}', 'data.title', this.value)"></div>
                        <div class="form-group col-md-6"><label>Image URL</label><input class="form-control" value="${block.data.image || ''}" onchange="updateBlockById('${blockId}', 'data.image', this.value)"></div>
                    </div>
                    <div class="form-group"><label>Stats</label>
                        <div class="grid grid-cols-2 gap-2">
                        ${(block.data.stats || []).map((stat, idx) => `
                            <div class="card p-2" style="background:var(--bg-main); border:1px solid var(--border-soft);">
                                <div class="flex justify-between"><label style="font-size:10px;">Stat ${idx+1}</label><button class="btn btn-sm p-0 text-red" onclick="removeArrayItem('${blockId}', 'stats', ${idx})"><i class="fas fa-times"></i></button></div>
                                <input class="form-control form-control-sm mb-1" placeholder="Value" value="${stat.value}" onchange="updateBlockById('${blockId}', 'data.stats.${idx}.value', this.value)">
                                <input class="form-control form-control-sm" placeholder="Label" value="${stat.label}" onchange="updateBlockById('${blockId}', 'data.stats.${idx}.label', this.value)">
                            </div>
                        `).join('')}
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="addArrayItem('${blockId}', 'stats')"><i class="fas fa-plus"></i> Add Stat</button>
                    </div>
                `;
            }
            else if (block.type === 'timeline') {
                contentHtml = `
                    <div class="block-label"><i class="fas fa-clock"></i> Timeline</div>
                    <div class="form-group">
                        ${(block.data.events || []).map((ev, idx) => `
                            <div class="card p-2 mb-2" style="background:var(--bg-main); border:1px solid var(--border-soft);">
                                <div class="flex justify-between mb-2">
                                    <div class="flex gap-2" style="flex:1;">
                                        <input class="form-control form-control-sm" style="width:70px;" placeholder="Year" value="${ev.year}" onchange="updateBlockById('${blockId}', 'data.events.${idx}.year', this.value)">
                                        <input class="form-control form-control-sm" placeholder="Title" value="${ev.title}" onchange="updateBlockById('${blockId}', 'data.events.${idx}.title', this.value)">
                                    </div>
                                    <button class="btn btn-sm text-red" onclick="removeArrayItem('${blockId}', 'events', ${idx})"><i class="fas fa-times"></i></button>
                                </div>
                                <input class="form-control form-control-sm" placeholder="Badge" value="${ev.badge}" onchange="updateBlockById('${blockId}', 'data.events.${idx}.badge', this.value)">
                            </div>
                        `).join('')}
                        <button type="button" class="btn btn-secondary btn-sm" onclick="addArrayItem('${blockId}', 'events')"><i class="fas fa-plus"></i> Add Event</button>
                    </div>
                `;
            }
            else if (block.type === 'split_content') {
                contentHtml = `
                    <div class="block-label"><i class="fas fa-columns"></i> Split Content</div>
                    <div class="form-row">
                        <div class="form-group col-md-6"><label>Title</label><input class="form-control" value="${block.data.title || ''}" onchange="updateBlockById('${blockId}', 'data.title', this.value)"></div>
                        <div class="form-group col-md-3"><label>Position</label>
                            <select class="form-control" onchange="updateBlockById('${blockId}', 'data.position', this.value)">
                                <option value="left" ${block.data.position === 'left' ? 'selected' : ''}>Image Left</option>
                                <option value="right" ${block.data.position === 'right' ? 'selected' : ''}>Image Right</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3"><label>Image URL</label><input class="form-control" value="${block.data.image || ''}" onchange="updateBlockById('${blockId}', 'data.image', this.value)"></div>
                    </div>
                `;
            }
            else {
                contentHtml = `<div class="block-label"><i class="fas fa-cubes"></i> ${block.type.toUpperCase()} Block</div><p style="font-size:0.8rem; color:var(--text-light);">Traditional content block. Edit settings for styling.</p>`;
            }

            const controls = document.createElement('div');
            controls.className = 'block-controls';
            controls.innerHTML = `
                <button type="button" onclick="openSettings('${blockId}')" class="btn-icon-sm" title="Settings"><i class="fas fa-cog"></i></button>
                <button type="button" onclick="removeBlockById('${blockId}')" class="btn-icon-sm text-red" title="Delete"><i class="fas fa-trash-can"></i></button>
            `;

            el.innerHTML += contentHtml;
            el.appendChild(controls);
            container.appendChild(el);

            // Recursive call for columns
            if (block.type === 'columns') {
                block.data.columns.forEach((col, colIndex) => {
                    const colContainer = el.querySelector(`#container-${blockId}-${colIndex}`);
                    renderBlocks(colContainer, col.blocks, false);
                });
            }

            // Initialize CKEditor
            if (block.type === 'text') {
                ClassicEditor.create(el.querySelector(`#editor-${blockId}`)).then(editor => {
                    editors[blockId] = editor;
                    editor.model.document.on('change:data', () => {
                        updateBlockById(blockId, 'data.content', editor.getData());
                    });
                }).catch(e => console.error(e));
            }
        });

        if (isTopLevel) {
            document.getElementById('blocks-input').value = JSON.stringify(blocks);
            initSortable();
        }
    }

    function updateBlockById(id, key, value) {
        const block = allBlocks.get(id);
        if (block) {
            const parts = key.split('.');
            let current = block;
            for (let i = 0; i < parts.length - 1; i++) {
                if (!current[parts[i]]) current[parts[i]] = {};
                current = current[parts[i]];
            }
            current[parts[parts.length - 1]] = value;
            document.getElementById('blocks-input').value = JSON.stringify(blocks);
        }
    }

    function removeBlockById(id) {
        if (!confirm('Remove this block?')) return;
        
        function removeFromList(list) {
            for (let i = 0; i < list.length; i++) {
                if (list[i]._id === id) {
                    list.splice(i, 1);
                    return true;
                }
                if (list[i].type === 'columns') {
                    for (let col of list[i].data.columns) {
                        if (removeFromList(col.blocks)) return true;
                    }
                }
            }
            return false;
        }

        removeFromList(blocks);
        allBlocks.delete(id);
        renderBlocks();
    }

    function addBlock(type) {
        let data = {};
        if (type === 'columns') data = { columns: [{ blocks: [] }, { blocks: [] }] };
        else if (type === 'text') data = { content: '' };
        else if (type === 'image') data = { url: '', alt: '' };
        else if (type === 'button') data = { text: 'Click Me', url: '#' };
        else data = { title: '', description: '' };

        blocks.push({ 
            _id: generateId(),
            type: type, 
            data: data, 
            settings: { bg_color: '#ffffff', text_color: '#334155', padding_top: '2', padding_bottom: '2', font_size: '16', border_radius: '0' } 
        });
        renderBlocks();
    }

    function addNestedBlock(parentId, colIndex) {
        const block = allBlocks.get(parentId);
        if (block && block.type === 'columns') {
            block.data.columns[colIndex].blocks.push({ 
                _id: generateId(),
                type: 'text', 
                data: { content: 'New nested text...' },
                settings: { font_size: '14' }
            });
            renderBlocks();
        }
    }

    let activeId = null;
    function openSettings(id) {
        activeId = id;
        const block = allBlocks.get(id);
        const s = block.settings || {};
        
        document.getElementById('set-bg-color').value = s.bg_color || '#ffffff';
        document.getElementById('set-text-color').value = s.text_color || '#334155';
        document.getElementById('set-padding-top').value = s.padding_top || '2';
        document.getElementById('set-padding-bottom').value = s.padding_bottom || '2';
        document.getElementById('set-margin-top').value = s.margin_top || '0';
        document.getElementById('set-margin-bottom').value = s.margin_bottom || '0';
        document.getElementById('set-font-size').value = s.font_size || '16';
        document.getElementById('set-border-radius').value = s.border_radius || '0';
        
        new bootstrap.Modal(document.getElementById('settingsModal')).show();
    }

    function saveSettings() {
        const block = allBlocks.get(activeId);
        if (block) {
            block.settings = {
                bg_color: document.getElementById('set-bg-color').value,
                text_color: document.getElementById('set-text-color').value,
                padding_top: document.getElementById('set-padding-top').value,
                padding_bottom: document.getElementById('set-padding-bottom').value,
                margin_top: document.getElementById('set-margin-top').value,
                margin_bottom: document.getElementById('set-margin-bottom').value,
                font_size: document.getElementById('set-font-size').value,
                border_radius: document.getElementById('set-border-radius').value
            };
            renderBlocks();
            bootstrap.Modal.getInstance(document.getElementById('settingsModal')).hide();
        }
    }

    function initSortable() {
        const containers = document.querySelectorAll('#blocks-container, .nested-container');
        containers.forEach(container => {
            new Sortable(container, {
                group: 'shared',
                animation: 150,
                handle: '.drag-handle',
                onEnd: function() {
                    // This is complex. For now, let's rebuild blocks from DOM
                    blocks = rebuildBlocksFromDOM(document.getElementById('blocks-container'));
                    renderBlocks();
                }
            });
        });
    }

    function rebuildBlocksFromDOM(container) {
        const list = [];
        Array.from(container.children).forEach(el => {
            if (el.classList.contains('block-item')) {
                const id = el.dataset.id;
                const block = allBlocks.get(id);
                if (block) {
                    if (block.type === 'columns') {
                        block.data.columns.forEach((col, idx) => {
                            const colContainer = el.querySelector(`#container-${id}-${idx}`);
                            col.blocks = rebuildBlocksFromDOM(colContainer);
                        });
                    }
                    list.push(block);
                }
            }
        });
        return list;
    }

    async function uploadImageByPath(input, path) {
        const file = input.files[0];
        if (!file) return;
        const formData = new FormData();
        formData.append('image', file);
        formData.append('_token', '{{ csrf_token() }}');
        try {
            const res = await fetch('{{ route('admin.builder.upload') }}', { method: 'POST', body: formData });
            const data = await res.json();
            if (data.url) {
                updateBlockById(path, 'data.url', data.url);
                renderBlocks();
            }
        } catch(e) { console.warn(e); }
    }

    function addArrayItem(id, listKey) {
        const block = allBlocks.get(id);
        if (block) {
            if (!block.data[listKey]) block.data[listKey] = [];
            let newItem = {};
            if (listKey === 'tabs') newItem = { title: 'New Tab', content: 'Tab content...' };
            else if (listKey === 'items') newItem = { title: 'New Feature', description: 'Feature description...' };
            else if (listKey === 'stats') newItem = { value: '100+', label: 'Happy Clients' };
            else if (listKey === 'events') newItem = { year: '2024', title: 'New Event', badge: 'Company' };
            
            block.data[listKey].push(newItem);
            renderBlocks();
        }
    }

    function removeArrayItem(id, listKey, index) {
        const block = allBlocks.get(id);
        if (block && block.data[listKey]) {
            block.data[listKey].splice(index, 1);
            renderBlocks();
        }
    }
</script>

<style>
    .sortable-ghost {
        opacity: 0.4;
        background-color: var(--primary-soft) !important;
        border: 2px dashed var(--primary) !important;
    }
    .drag-handle {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: grab;
        background: var(--bg-main);
        border-right: 1px solid var(--border-soft);
        transition: all 0.2s;
    }
    .drag-handle:hover {
        background: var(--border-soft) !important;
    }
    .drag-handle:hover i {
        opacity: 1 !important;
        color: var(--primary);
    }
    .block-label {
        font-size: 0.75rem;
        font-weight: 800;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .btn-icon-sm {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-soft);
        background: white;
        color: var(--text-main);
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-icon-sm:hover {
        background: var(--bg-main);
        border-color: var(--primary);
        color: var(--primary);
    }
    .btn-icon-sm.text-red { color: #ef4444; }
    .btn-icon-sm.text-red:hover { background: #fee2e2; border-color: #ef4444; }

    .column-header {
        background: var(--bg-main);
        padding: 0.25rem 0.5rem;
        border-bottom: 1px solid var(--border-soft);
    }
    .nested-container {
        min-height: 50px;
    }
</style>
