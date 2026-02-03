<script>
    // Global scope protection
    (function() {
        let editors = {};
        let allBlocks = new Map();
        
        // Ensure blocks is initialized
        if (typeof window.blocks === 'undefined') {
            window.blocks = [];
        }
        
        // Helper to safely access nested properties
        function getSafe(obj, path, defaultValue = null) {
            return path.split('.').reduce((acc, part) => acc && acc[part], obj) || defaultValue;
        }

        // Expose functions to window for onclick handlers
        window.addBlock = function(type) {
            console.log('Adding block:', type);
            
            // Ensure blocks array exists
            if (typeof window.blocks === 'undefined' || !Array.isArray(window.blocks)) {
                console.warn('Initializing blocks array');
                window.blocks = [];
            }
            
            let data = {};
            if (type === 'columns') data = { columns: [{ blocks: [] }, { blocks: [] }] };
            else if (type === 'text') data = { content: '' };
            else if (type === 'image') data = { url: '', alt: '' };
            else if (type === 'button') data = { text: 'Click Me', url: '#' };
            else if (type === 'tabs') data = { tabs: [{ title: 'New Tab', content: 'Tab content...' }] };
            else if (type === 'features') data = { items: [{ title: 'New Feature', description: 'Feature description...' }] };
            else if (type === 'hero_stats') data = { title: '', description: '', image: '', stats: [{ value: '100+', label: 'Clients' }] };
            else if (type === 'timeline') data = { events: [{ year: '2024', title: 'New Event', badge: 'Milestone' }] };
            else if (type === 'split_content') data = { title: '', description: '', image: '', position: 'left', stats: [] };
            else if (type === 'table') data = { 
                headers: ['Column 1', 'Column 2'], 
                rows: [
                    ['Cell 1', 'Cell 2'],
                    ['Cell 3', 'Cell 4']
                ] 
            };
            else data = { title: '', description: '' };

            window.blocks.push({ 
                _id: 'b-' + Math.random().toString(36).substr(2, 9),
                type: type, 
                data: data, 
                settings: { bg_color: '#ffffff', text_color: '#334155', padding_top: '2', padding_bottom: '2', font_size: '16', border_radius: '12' } 
            });
            window.renderBlocks();
        };

        window.renderBlocks = function(container = document.getElementById('blocks-container'), blockList = null, isTopLevel = true) {
            if (!container) {
                console.warn('Blocks container not found');
                return;
            }
            
            // Use window.blocks if blockList is not provided
            if (blockList === null) {
                blockList = window.blocks || [];
            }
            
            if (isTopLevel) {
                ensureIds(blockList);
                
                // Clear and handle empty state
                const emptyState = document.getElementById('empty-state');
                
                // Destroy existing editors
                Object.values(editors).forEach(editor => {
                    if (editor && typeof editor.destroy === 'function') editor.destroy();
                });
                editors = {};
                
                // Clear container but keep empty state if needed
                container.innerHTML = '';
                
                if (!blockList || blockList.length === 0) {
                    if (emptyState) {
                        emptyState.style.display = 'block';
                        container.appendChild(emptyState);
                    }
                    if (document.getElementById('blocks-input')) {
                        document.getElementById('blocks-input').value = '[]';
                    }
                    return;
                } else if (emptyState) {
                    emptyState.style.display = 'none';
                }
            } else {
                container.innerHTML = '';
            }

            blockList.forEach((block, index) => {
                if (!block) return;
                
                const blockId = block._id || 'b-' + Math.random().toString(36).substr(2, 9);
                block._id = blockId;
                block.data = block.data || {}; // Ensure data object exists
                allBlocks.set(blockId, block);
                
                const el = document.createElement('div');
                el.className = 'card block-item';
                el.dataset.id = blockId;
                el.style.position = 'relative';
                el.style.borderLeft = '4px solid var(--primary)';
                el.style.marginBottom = '1.5rem';
                el.style.paddingLeft = '3rem';

                // Apply settings
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

                const dragHandle = document.createElement('div');
                dragHandle.className = 'drag-handle';
                dragHandle.innerHTML = '<i class="fas fa-grip-vertical"></i>';
                el.appendChild(dragHandle);

                let contentHtml = '';
                if (block.type === 'text') {
                    contentHtml = `<div class="block-label"><i class="fas fa-font"></i> Text Content</div><textarea id="editor-${blockId}">${block.data.content || ''}</textarea>`;
                } else if (block.type === 'image') {
                    contentHtml = `<div class="block-label"><i class="fas fa-image"></i> Image Asset</div>
                        <div class="form-row">
                            <div class="form-group mb-0 w-full">
                                <div style="display: flex; gap: 0.5rem; align-items: end;">
                                    <input class="form-control" id="image-url-${blockId}" value="${block.data.url || ''}" onchange="window.updateBlockById('${blockId}', 'data.url', this.value)" placeholder="Image URL or upload below" style="flex: 1;">
                                    <input type="file" id="image-upload-${blockId}" accept="image/*" style="display: none;" onchange="uploadImageForBlock('${blockId}', this)">
                                    <button type="button" onclick="document.getElementById('image-upload-${blockId}').click()" class="btn btn-secondary" style="white-space: nowrap; padding: 0.5rem 1rem;">
                                        <i class="fas fa-upload"></i> Upload
                                    </button>
                                </div>
                                <div style="margin-top: 0.5rem;">
                                    <input class="form-control" value="${block.data.alt || ''}" onchange="window.updateBlockById('${blockId}', 'data.alt', this.value)" placeholder="Alt text (optional)" style="font-size: 0.85rem;">
                                </div>
                                ${block.data.url ? `<div style="margin-top: 0.5rem;"><img src="${block.data.url}" alt="Preview" style="max-width: 150px; max-height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border);"></div>` : ''}
                            </div>
                        </div>`;
                } else if (block.type === 'button') {
                    contentHtml = `<div class="block-label"><i class="fas fa-link"></i> Button Block</div>
                        <div class="form-row">
                            <div class="form-group mb-0 w-full">
                                <div style="margin-bottom: 0.75rem;">
                                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.25rem; display: block;">Button Text</label>
                                    <input class="form-control" value="${block.data.text || 'Click Me'}" onchange="window.updateBlockById('${blockId}', 'data.text', this.value)" placeholder="Enter button text">
                                </div>
                                <div style="margin-bottom: 0.75rem;">
                                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.25rem; display: block;">Button Link</label>
                                    <input class="form-control" value="${block.data.url || '#'}" onchange="window.updateBlockById('${blockId}', 'data.url', this.value)" placeholder="Enter URL (e.g., https://example.com)">
                                </div>
                                <div style="padding: 0.75rem; background: var(--bg-main); border-radius: 8px; text-align: center;">
                                    <span style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.5rem; display: block;">Preview:</span>
                                    <button type="button" class="btn btn-primary" style="pointer-events: none;">
                                        ${block.data.text || 'Click Me'}
                                    </button>
                                </div>
                            </div>
                        </div>`;
                } else if (block.type === 'tabs') {
                    const tabs = block.data.tabs || [];
                    contentHtml = `<div class="block-label"><i class="fas fa-folder-tree"></i> Tabs Section</div>
                        <div class="tabs-editor-container" style="background: var(--bg-light); padding: 1rem; border-radius: 8px;">
                            ${tabs.map((tab, i) => `
                                <div class="tab-item" style="border: 1px solid var(--border-soft); padding: 1rem; margin-bottom: 0.5rem; border-radius: 8px; background: white;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <span style="font-weight: 700; font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted);">Tab ${i+1}</span>
                                        </div>
                                        ${tabs.length > 1 ? `<button type="button" onclick="window.removeTabItem('${blockId}', ${i})" class="btn-icon-sm text-red" style="width: 28px; height: 28px;" title="Remove Tab"><i class="fas fa-times"></i></button>` : ''}
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0.75rem;">
                                        <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">Tab Title</label>
                                        <input class="form-control" value="${tab.title || ''}" onchange="window.updateBlockById('${blockId}', 'data.tabs.${i}.title', this.value)" placeholder="e.g. Description">
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">Tab Content</label>
                                        <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">Tab Content</label>
                                        <textarea id="tab-editor-${blockId}-${i}" class="form-control" rows="3" placeholder="Enter content for this tab...">${tab.content || ''}</textarea>
                                    </div>
                                </div>
                            `).join('')}
                            <button type="button" onclick="window.addTabItem('${blockId}')" class="btn btn-secondary btn-sm" style="width: 100%; margin-top: 0.5rem;">
                                <i class="fas fa-plus"></i> Add Another Tab
                            </button>
                        </div>`;
                } else if (block.type === 'columns') {
                    const columns = block.data.columns || [];
                    contentHtml = `<div class="block-label"><i class="fas fa-columns"></i> Multi-Column Layout</div>
                        <div style="display: grid; grid-template-columns: repeat(${columns.length || 1}, 1fr); gap: 1rem;">
                            ${columns.map((col, i) => `
                                <div class="column-wrapper" style="border: 2px dashed var(--border-soft); border-radius: 12px; padding: 1rem; min-height: 120px; position: relative;">
                                    <div class="column-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border-soft);">
                                        <span style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase;">Column ${i + 1}</span>
                                        <div style="display: flex; gap: 0.25rem;">
                                            <button type="button" onclick="addContentToColumn('${blockId}', ${i}, 'text')" class="btn-icon-xs" title="Add Text">
                                                <i class="fas fa-font"></i>
                                            </button>
                                            <button type="button" onclick="addContentToColumn('${blockId}', ${i}, 'image')" class="btn-icon-xs" title="Add Image">
                                                <i class="fas fa-image"></i>
                                            </button>
                                            <button type="button" onclick="addContentToColumn('${blockId}', ${i}, 'button')" class="btn-icon-xs" title="Add Button">
                                                <i class="fas fa-link"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="nested-container" id="container-${blockId}-${i}" data-id="${blockId}" data-col="${i}" style="min-height: 60px;">
                                        ${col.blocks && col.blocks.length === 0 ? '<div style="text-align: center; color: var(--text-light); font-size: 0.8rem; padding: 1rem;">Click buttons above to add content</div>' : ''}
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                        <div style="margin-top: 1rem; text-align: center;">
                            <button type="button" onclick="addColumn('${blockId}')" class="btn btn-secondary btn-sm">
                                <i class="fas fa-plus"></i> Add Column
                            </button>
                            ${columns.length > 1 ? `<button type="button" onclick="removeColumn('${blockId}')" class="btn btn-outline-secondary btn-sm" style="margin-left: 0.5rem;">
                                <i class="fas fa-minus"></i> Remove Column
                            </button>` : ''}
                        </div>`;
                } else if (block.type === 'table') {
                    const headers = block.data.headers || [];
                    const rows = block.data.rows || [];
                    
                    // Helper to generate unique IDs for inputs to avoid focus issues
                    const tId = blockId; // short alias
                    
                    let headerHtml = headers.map((h, i) => `
                        <th>
                            <div class="flex gap-1">
                                <input type="text" class="form-control form-control-sm" value="${h}" onchange="window.updateTableData('${blockId}', 'header', ${i}, this.value)">
                                <button type="button" onclick="window.removeTableCol('${blockId}', ${i})" class="btn-icon-xs text-red" title="Remove Column"><i class="fas fa-times"></i></button>
                            </div>
                        </th>
                    `).join('');
                    
                    let rowsHtml = rows.map((row, rIndex) => {
                        let cellsHtml = row.map((cell, cIndex) => `
                            <td>
                                <input type="text" class="form-control form-control-sm" value="${cell}" onchange="window.updateTableData('${blockId}', 'cell', ${rIndex}, ${cIndex}, this.value)">
                            </td>
                        `).join('');
                        
                        return `
                            <tr>
                                ${cellsHtml}
                                <td style="width: 50px;">
                                    <button type="button" onclick="window.removeTableRow('${blockId}', ${rIndex})" class="btn-icon-xs text-red" title="Remove Row"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        `;
                    }).join('');

                    contentHtml = `<div class="block-label"><i class="fas fa-table"></i> Table Block</div>
                        <div class="table-responsive" style="background: white; padding: 1rem; border-radius: 8px; border: 1px solid var(--border-soft);">
                            <table class="table table-bordered mb-3">
                                <thead>
                                    <tr>
                                        ${headerHtml}
                                        <th style="width: 50px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${rowsHtml}
                                </tbody>
                            </table>
                            <div class="flex gap-2">
                                <button type="button" onclick="window.addTableRow('${blockId}')" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> Add Row</button>
                                <button type="button" onclick="window.addTableCol('${blockId}')" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> Add Column</button>
                            </div>
                        </div>`;
                } else {
                    contentHtml = `<div class="block-label"><i class="fas fa-cubes"></i> ${block.type} Block</div><p style="color:var(--text-muted); font-size:0.8rem;">Click settings to configure this section.</p>`;
                }
                
                // Hide Settings button for Table and Tabs as requested
                const showSettings = !['table', 'tabs'].includes(block.type);

                const controls = document.createElement('div');
                controls.className = 'block-controls';
                controls.innerHTML = `
                    ${showSettings ? `<button type="button" onclick="window.openSettings('${blockId}')" class="btn-icon-sm"><i class="fas fa-cog"></i></button>` : ''}
                    <button type="button" onclick="window.removeBlockById('${blockId}')" class="btn-icon-sm text-red"><i class="fas fa-trash"></i></button>
                `;

                el.innerHTML += contentHtml;
                el.appendChild(controls);
                container.appendChild(el);

                if (block.type === 'columns' && block.data.columns) {
                    block.data.columns.forEach((col, i) => {
                        window.renderBlocks(el.querySelector(`#container-${blockId}-${i}`), (col.blocks || []), false);
                    });
                }

            });
            
            // Post-render initialization for Editors (Text and Tabs)
            blockList.forEach(block => {
                 if (!block) return;
                 const blockId = block._id;
                 const el = container.querySelector(`.block-item[data-id="${blockId}"]`);
                 if (!el) return;

                 if (block.type === 'text' && typeof ClassicEditor !== 'undefined') {
                     ClassicEditor.create(el.querySelector(`#editor-${blockId}`)).then(editor => {
                         editors[blockId] = editor;
                         editor.model.document.on('change:data', () => {
                             window.updateBlockById(blockId, 'data.content', editor.getData());
                         });
                     }).catch(err => console.warn('CKEditor delay:', err));
                 }
                 
                 if (block.type === 'tabs' && typeof ClassicEditor !== 'undefined') {
                     const tabs = block.data.tabs || [];
                     tabs.forEach((tab, i) => {
                         const textarea = el.querySelector(`#tab-editor-${blockId}-${i}`);
                         if (textarea) {
                             ClassicEditor.create(textarea).then(editor => {
                                 // We need a unique key for each tab editor to track it
                                 const editorKey = `${blockId}-tab-${i}`;
                                 editors[editorKey] = editor;
                                 editor.model.document.on('change:data', () => {
                                     window.updateBlockById(blockId, `data.tabs.${i}.content`, editor.getData());
                                 });
                             }).catch(err => console.warn('CKEditor tab delay:', err));
                         }
                     });
                 }
            });

            if (isTopLevel) {
                if (document.getElementById('blocks-input')) {
                    document.getElementById('blocks-input').value = JSON.stringify(window.blocks);
                }
                initSortable();
            }
        };

        window.updateBlockById = function(id, key, value) {
            const block = allBlocks.get(id);
            if (block) {
                const parts = key.split('.');
                let curr = block;
                for (let i = 0; i < parts.length - 1; i++) {
                    if (!curr[parts[i]]) curr[parts[i]] = {};
                    curr = curr[parts[i]];
                }
                curr[parts[parts.length - 1]] = value;
                if (document.getElementById('blocks-input')) {
                    document.getElementById('blocks-input').value = JSON.stringify(window.blocks);
                }
            }
        };

        window.removeBlockById = function(id) {
            if (!confirm('Delete this block?')) return;
            const findAndRemove = (list) => {
                if (!list) return false;
                for (let i = 0; i < list.length; i++) {
                    if (list[i] && list[i]._id === id) { list.splice(i, 1); return true; }
                    if (list[i] && list[i].type === 'columns' && list[i].data && list[i].data.columns) {
                        for (let col of list[i].data.columns) { if (findAndRemove(col.blocks)) return true; }
                    }
                }
                return false;
            };
            findAndRemove(window.blocks);
            allBlocks.delete(id);
            window.renderBlocks();
        };

        function ensureIds(list) {
            if (!list || !Array.isArray(list)) return;
            list.forEach(b => {
                if (!b) return;
                if (!b._id) b._id = 'b-' + Math.random().toString(36).substr(2, 9);
                allBlocks.set(b._id, b);
                if (b.type === 'columns' && b.data && b.data.columns) {
                    b.data.columns.forEach(c => ensureIds(c.blocks));
                }
            });
        }

        function initSortable() {
            if (typeof Sortable === 'undefined') return;
            const containers = document.querySelectorAll('#blocks-container, .nested-container');
            containers.forEach(c => {
                if (c.sortable) c.sortable.destroy();
                c.sortable = new Sortable(c, {
                    group: 'blocks',
                    animation: 150,
                    handle: '.drag-handle',
                    onEnd: () => {
                        window.blocks = rebuildBlocksFromDOM(document.getElementById('blocks-container'));
                        window.renderBlocks();
                    }
                });
            });
        }

        function rebuildBlocksFromDOM(container) {
            if (!container) return [];
            const list = [];
            Array.from(container.children).forEach(el => {
                if (el.dataset.id) {
                    const block = allBlocks.get(el.dataset.id);
                    if (block) {
                        if (block.type === 'columns' && block.data && block.data.columns) {
                            block.data.columns.forEach((col, i) => {
                                const nested = el.querySelector(`#container-${block._id}-${i}`);
                                if (nested) col.blocks = rebuildBlocksFromDOM(nested);
                            });
                        }
                        list.push(block);
                    }
                }
            });
            return list;
        }

        window.openSettings = function(id) {
            const block = allBlocks.get(id);
            if (!block) {
                console.error('Block not found:', id);
                return;
            }
            
            window.activeBlockId = id;
            const s = block.settings || {};
            
            const fieldMap = {
                'set-bg-color': s.bg_color || '#ffffff',
                'set-text-color': s.text_color || '#334155',
                'set-padding-top': s.padding_top || '2',
                'set-padding-bottom': s.padding_bottom || '2',
                'set-margin-top': s.margin_top || '0',
                'set-margin-bottom': s.margin_bottom || '0',
                'set-font-size': s.font_size || '16',
                'set-border-radius': s.border_radius || '12'
            };

            Object.entries(fieldMap).forEach(([id, val]) => {
                const el = document.getElementById(id);
                if (el) el.value = val;
            });

            const modalEl = document.getElementById('settingsModal');
            if (modalEl) {
                // Destroy existing modal instance if any
                const existingModal = bootstrap.Modal.getInstance(modalEl);
                if (existingModal) {
                    existingModal.dispose();
                }
                
                // Create new modal instance with proper options
                const modal = new bootstrap.Modal(modalEl, {
                    backdrop: true,
                    keyboard: true,
                    focus: true
                });
                
                // Prevent page scrolling when modal opens
                modalEl.addEventListener('shown.bs.modal', function () {
                    document.body.style.overflow = 'hidden';
                });
                
                modalEl.addEventListener('hidden.bs.modal', function () {
                    document.body.style.overflow = 'auto';
                });
                
                modal.show();
            } else {
                console.error('Settings modal not found');
            }
        };

        window.saveSettings = function() {
            const block = allBlocks.get(window.activeBlockId);
            if (block) {
                block.settings = {
                    bg_color: document.getElementById('set-bg-color')?.value,
                    text_color: document.getElementById('set-text-color')?.value,
                    padding_top: document.getElementById('set-padding-top')?.value,
                    padding_bottom: document.getElementById('set-padding-bottom')?.value,
                    margin_top: document.getElementById('set-margin-top')?.value,
                    margin_bottom: document.getElementById('set-margin-bottom')?.value,
                    font_size: document.getElementById('set-font-size')?.value,
                    border_radius: document.getElementById('set-border-radius')?.value
                };
                window.renderBlocks();
                const modalEl = document.getElementById('settingsModal');
                if (modalEl) {
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                }
            }
        };

        // Column management functions
        window.addContentToColumn = function(blockId, columnIndex, contentType) {
            const block = allBlocks.get(blockId);
            if (!block || !block.data.columns || !block.data.columns[columnIndex]) {
                console.error('Column not found');
                return;
            }
            
            let data = {};
            if (contentType === 'text') data = { content: 'Enter your text here...' };
            else if (contentType === 'image') data = { url: '', alt: '' };
            else if (contentType === 'button') data = { text: 'Click Me', url: '#' };
            
            const newBlock = {
                _id: 'b-' + Math.random().toString(36).substr(2, 9),
                type: contentType,
                data: data,
                settings: { bg_color: '#ffffff', text_color: '#334155', padding_top: '1', padding_bottom: '1', font_size: '16', border_radius: '8' }
            };
            
            block.data.columns[columnIndex].blocks.push(newBlock);
            window.renderBlocks();
        };
        
        window.addColumn = function(blockId) {
            const block = allBlocks.get(blockId);
            if (!block || !block.data.columns) {
                console.error('Block not found');
                return;
            }
            
            block.data.columns.push({ blocks: [] });
            window.renderBlocks();
        };
        
        window.removeColumn = function(blockId) {
            const block = allBlocks.get(blockId);
            if (!block || !block.data.columns || block.data.columns.length <= 1) {
                console.error('Cannot remove column');
                return;
            }
            
            if (confirm('Remove the last column? This will delete all content in it.')) {
                block.data.columns.pop();
                window.renderBlocks();
            }
        };

        // Tabs management functions
        window.addTabItem = function(blockId) {
            console.log('Adding tab to block:', blockId);
            const block = allBlocks.get(blockId);
            
            if (!block) {
                console.error('Block not found in allBlocks map:', blockId);
                alert('Error: Could not find block. Please save and refresh the page.');
                return;
            }
            
            // Ensure data object exists
            if (!block.data) {
                block.data = {};
            }
            
            // Ensure tabs array exists
            if (!Array.isArray(block.data.tabs)) {
                console.warn('Initializing tabs array for block:', blockId);
                block.data.tabs = [];
            }
            
            block.data.tabs.push({ title: 'New Tab', content: 'Tab content...' });
            console.log('Tab added, current tabs:', block.data.tabs.length);
            
            // Force save to input
            if (document.getElementById('blocks-input')) {
                document.getElementById('blocks-input').value = JSON.stringify(window.blocks);
            }
            
            window.renderBlocks();
        };

        window.removeTabItem = function(blockId, index) {
            console.log('Removing tab from block:', blockId, 'Index:', index);
            const block = allBlocks.get(blockId);
            
            if (!block) {
                console.error('Block not found:', blockId);
                return;
            }
            
            if (!block.data || !Array.isArray(block.data.tabs)) {
                console.warn('No tabs to remove for block:', blockId);
                return;
            }
            
            block.data.tabs.splice(index, 1);
            
            // Force save to input
            if (document.getElementById('blocks-input')) {
                document.getElementById('blocks-input').value = JSON.stringify(window.blocks);
            }
            
            window.renderBlocks();
        };

        // Table functions
        window.updateTableData = function(blockId, type, ...args) {
            const block = allBlocks.get(blockId);
            if (!block) return;
            
            if (type === 'header') {
                const [index, value] = args;
                if (!block.data.headers) block.data.headers = [];
                block.data.headers[index] = value;
            } else if (type === 'cell') {
                const [rowIndex, colIndex, value] = args;
                if (!block.data.rows) block.data.rows = [];
                if (!block.data.rows[rowIndex]) block.data.rows[rowIndex] = [];
                block.data.rows[rowIndex][colIndex] = value;
            }
            
            // Sync to input
            if (document.getElementById('blocks-input')) {
                document.getElementById('blocks-input').value = JSON.stringify(window.blocks);
            }
        };

        window.addTableCol = function(blockId) {
            const block = allBlocks.get(blockId);
            if (!block) return;
            
            if (!block.data.headers) block.data.headers = [];
            block.data.headers.push('New Column');
            
            if (!block.data.rows) block.data.rows = [];
            block.data.rows.forEach(row => row.push(''));
            
            window.renderBlocks();
        };

        window.addTableRow = function(blockId) {
            const block = allBlocks.get(blockId);
            if (!block) return;
            
            const colCount = block.data.headers ? block.data.headers.length : 1;
            if (!block.data.rows) block.data.rows = [];
            block.data.rows.push(new Array(colCount).fill(''));
            
            window.renderBlocks();
        };

        window.removeTableCol = function(blockId, index) {
            const block = allBlocks.get(blockId);
            if (!block) return;
            
            if (block.data.headers && block.data.headers.length > 1) {
                block.data.headers.splice(index, 1);
                if (block.data.rows) {
                    block.data.rows.forEach(row => row.splice(index, 1));
                }
                window.renderBlocks();
            }
        };

        window.removeTableRow = function(blockId, index) {
            const block = allBlocks.get(blockId);
            if (!block) return;
            
            if (block.data.rows) {
                block.data.rows.splice(index, 1);
                window.renderBlocks();
            }
        };

        // Image upload function for blocks
        window.uploadImageForBlock = function(blockId, input) {
            if (input.files && input.files[0]) {
                const formData = new FormData();
                formData.append('image', input.files[0]);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');

                // Show loading state
                const uploadBtn = input.parentElement.querySelector('button');
                const originalText = uploadBtn.innerHTML;
                uploadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
                uploadBtn.disabled = true;

                fetch('{{ route("admin.pages.upload") }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.url) {
                        // Update the block data
                        window.updateBlockById(blockId, 'data.url', data.url);
                        
                        // Update the input field
                        const urlInput = document.getElementById(`image-url-${blockId}`);
                        if (urlInput) {
                            urlInput.value = data.url;
                        }
                        
                        // Show success message
                        uploadBtn.innerHTML = '<i class="fas fa-check"></i> Uploaded!';
                        uploadBtn.style.background = '#10b981';
                        
                        // Re-render the block to show preview
                        setTimeout(() => {
                            window.renderBlocks();
                            uploadBtn.innerHTML = originalText;
                            uploadBtn.style.background = '';
                            uploadBtn.disabled = false;
                        }, 1500);
                    } else {
                        throw new Error(data.error || 'Upload failed');
                    }
                })
                .catch(error => {
                    console.error('Upload error:', error);
                    alert('Upload failed: ' + error.message);
                    uploadBtn.innerHTML = originalText;
                    uploadBtn.disabled = false;
                });
            }
        };

        // Banner image upload function
        window.uploadBannerImage = function(input) {
            if (input.files && input.files[0]) {
                const formData = new FormData();
                formData.append('image', input.files[0]);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');

                // Show loading state
                const uploadBtn = input.parentElement.querySelector('button');
                const originalText = uploadBtn.innerHTML;
                uploadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
                uploadBtn.disabled = true;

                fetch('{{ route("admin.pages.upload") }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.url) {
                        document.getElementById('hero_image').value = data.url;
                        // Show success message
                        uploadBtn.innerHTML = '<i class="fas fa-check"></i> Uploaded!';
                        uploadBtn.style.background = '#10b981';
                        setTimeout(() => {
                            uploadBtn.innerHTML = originalText;
                            uploadBtn.style.background = '';
                            uploadBtn.disabled = false;
                        }, 2000);
                    } else {
                        throw new Error(data.error || 'Upload failed');
                    }
                })
                .catch(error => {
                    console.error('Upload error:', error);
                    alert('Upload failed: ' + error.message);
                    uploadBtn.innerHTML = originalText;
                    uploadBtn.disabled = false;
                });
            }
        };

        // Form submission handler
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('page-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    try {
                        // Serialize blocks data
                        const blocksInput = document.getElementById('blocks-input');
                        if (blocksInput && window.blocks) {
                            blocksInput.value = JSON.stringify(window.blocks);
                            console.log('Serialized blocks:', window.blocks);
                        }
                    } catch (error) {
                        console.error('Error serializing blocks:', error);
                        alert('Error saving page data. Please try again.');
                        e.preventDefault();
                    }
                });
            }
        });
    })();
</script>

<style>
    .block-item { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); z-index: 1; }
    .block-item:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); z-index: 10; }
    .drag-handle {
        position: absolute; left: 0; top: 0; bottom: 0; width: 3rem;
        display: flex; align-items: center; justify-content: center;
        background: var(--bg-main); border-right: 1px solid var(--border-soft);
        cursor: grab; color: var(--text-light); border-radius: 12px 0 0 12px;
    }
    .drag-handle:hover { color: var(--primary); background: var(--border-soft); }
    .block-label { font-size: 0.7rem; font-weight: 800; color: var(--primary); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; }
    .block-controls { position: absolute; top: 1.5rem; right: 1.5rem; display: flex; gap: 0.5rem; }
    .btn-icon-sm { width: 36px; height: 36px; border-radius: 10px; border: 1px solid var(--border-soft); background: white; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; }
    .btn-icon-sm:hover { border-color: var(--primary); color: var(--primary); background: var(--bg-main); }
    .btn-icon-sm.text-red:hover { border-color: #ef4444; color: #ef4444; background: #fee2e2; }
</style>
