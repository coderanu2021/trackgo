<script>
    // Global scope protection
    (function() {
        let editors = {};
        let allBlocks = new Map();
        
        // Helper to safely access nested properties
        function getSafe(obj, path, defaultValue = null) {
            return path.split('.').reduce((acc, part) => acc && acc[part], obj) || defaultValue;
        }

        // Expose functions to window for onclick handlers
        window.addBlock = function(type) {
            console.log('Adding block:', type);
            if (typeof window.blocks === 'undefined') {
                console.error('Blocks variable is not defined!');
                return;
            }
            
            let data = {};
            if (type === 'columns') data = { columns: [{ blocks: [] }, { blocks: [] }] };
            else if (type === 'text') data = { content: '' };
            else if (type === 'image') data = { url: '', alt: '' };
            else if (type === 'button') data = { text: 'Click Me', url: '#' };
            else if (type === 'tabs') data = { tabs: [{ title: 'New Tab', content: 'Tab content...' }] };
            else if (type === 'features') data = { items: [{ title: 'New Feature', description: 'Feature description...' }] };
            else if (type === 'hero_stats') data = { title: '', stats: [{ value: '100+', label: 'Clients' }] };
            else if (type === 'timeline') data = { events: [{ year: '2024', title: 'New Event' }] };
            else if (type === 'split_content') data = { title: '', image: '', position: 'left' };
            else data = { title: '', description: '' };

            window.blocks.push({ 
                _id: 'b-' + Math.random().toString(36).substr(2, 9),
                type: type, 
                data: data, 
                settings: { bg_color: '#ffffff', text_color: '#334155', padding_top: '2', padding_bottom: '2', font_size: '16', border_radius: '12' } 
            });
            window.renderBlocks();
        };

        window.renderBlocks = function(container = document.getElementById('blocks-container'), blockList = (typeof window.blocks !== 'undefined' ? window.blocks : []), isTopLevel = true) {
            if (!container) return;
            
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
                        <div class="form-row"><div class="form-group mb-0 w-full"><input class="form-control" value="${block.data.url || ''}" onchange="window.updateBlockById('${blockId}', 'data.url', this.value)" placeholder="Image URL"></div></div>`;
                } else if (block.type === 'columns') {
                    const columns = block.data.columns || [];
                    contentHtml = `<div class="block-label"><i class="fas fa-columns"></i> Multi-Column Layout</div>
                        <div style="display: grid; grid-template-columns: repeat(${columns.length || 1}, 1fr); gap: 1rem;">
                            ${columns.map((col, i) => `<div class="nested-container" id="container-${blockId}-${i}" data-id="${blockId}" data-col="${i}" style="border: 2px dashed var(--border-soft); border-radius: 12px; padding: 1rem; min-height: 80px;"></div>`).join('')}
                        </div>`;
                } else {
                    contentHtml = `<div class="block-label"><i class="fas fa-cubes"></i> ${block.type} Block</div><p style="color:var(--text-muted); font-size:0.8rem;">Click settings to configure this section.</p>`;
                }

                const controls = document.createElement('div');
                controls.className = 'block-controls';
                controls.innerHTML = `
                    <button type="button" onclick="window.openSettings('${blockId}')" class="btn-icon-sm"><i class="fas fa-cog"></i></button>
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

                if (block.type === 'text' && typeof ClassicEditor !== 'undefined') {
                    ClassicEditor.create(el.querySelector(`#editor-${blockId}`)).then(editor => {
                        editors[blockId] = editor;
                        editor.model.document.on('change:data', () => {
                            window.updateBlockById(blockId, 'data.content', editor.getData());
                        });
                    }).catch(err => console.warn('CKEditor delay:', err));
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
            if (!block) return;
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
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
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
