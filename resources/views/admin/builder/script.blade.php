<script>
    let editors = {}; // Store CKEditor instances

    function renderBlocks() {
        const container = document.getElementById('blocks-container');
        const emptyState = document.getElementById('empty-state');
        const input = document.getElementById('blocks-input');
        
        // Destroy existing editors before re-rendering
        Object.values(editors).forEach(editor => editor.destroy());
        editors = {};

        if (!blocks || blocks.length === 0) {
            container.innerHTML = '';
            if(emptyState) {
                container.appendChild(emptyState);
                emptyState.style.display = 'block';
            }
            input.value = '[]';
            return;
        }
        
        if(emptyState) emptyState.style.display = 'none';
        container.innerHTML = '';

        blocks.forEach((block, index) => {
            const el = document.createElement('div');
            el.className = 'card';
            el.style.position = 'relative';
            el.style.borderLeft = '4px solid var(--primary-soft)';
            el.style.transition = 'all 0.3s ease';

            let contentHtml = '';
            
            // --- TEXT BLOCK ---
            if (block.type === 'text') {
                contentHtml = `
                    <div class="flex items-center gap-2 mb-4" style="color:var(--primary); font-weight:700; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.05em;">
                        <i class="fas fa-align-left"></i> Text Narrative Block
                    </div>
                    <div class="form-group mb-0">
                        <textarea id="editor-${index}">${block.data.content || ''}</textarea>
                    </div>
                `;
            } 
            // --- IMAGE BLOCK ---
            else if (block.type === 'image') {
                contentHtml = `
                    <div class="flex items-center gap-2 mb-4" style="color:var(--primary); font-weight:700; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.05em;">
                        <i class="fas fa-image"></i> Visual Media Block
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Source URL</label>
                            <div class="flex gap-2">
                                <input type="url" onchange="updateBlock(${index}, 'url', this.value)" value="${block.data.url || ''}" class="form-control" style="flex:1;" placeholder="https://...">
                                <label class="btn btn-secondary" style="margin:0; cursor:pointer; padding:0 1rem; height:48px; display:flex; align-items:center; border-radius:12px;">
                                    <i class="fas fa-upload"></i> <input type="file" onchange="uploadImage(this, ${index})" accept="image/*" style="display:none;">
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Alternative Text (SEO)</label>
                            <input type="text" onchange="updateBlock(${index}, 'alt', this.value)" value="${block.data.alt || ''}" class="form-control" placeholder="Describe this image...">
                        </div>
                    </div>
                `;
            }
            // --- BUTTON BLOCK ---
            else if (block.type === 'button') {
                contentHtml = `
                    <div class="flex items-center gap-2 mb-4" style="color:var(--primary); font-weight:700; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.05em;">
                        <i class="fas fa-link"></i> Call to Action Block
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Button Label</label>
                            <input value="${block.data.text || ''}" onchange="updateBlock(${index}, 'text', this.value)" class="form-control" placeholder="e.g. Get Started">
                        </div>
                        <div class="form-group">
                            <label>Destination URL</label>
                            <input value="${block.data.url || ''}" onchange="updateBlock(${index}, 'url', this.value)" class="form-control" placeholder="https://...">
                        </div>
                    </div>
                    <div style="background:var(--bg-main); padding:1.25rem; border-radius:var(--radius-md); border:1px solid var(--border-soft); margin-top:0.5rem;">
                        <div style="font-size:0.7rem; font-weight:700; color:var(--text-muted); margin-bottom:1rem; text-transform:uppercase; letter-spacing:0.05em;">
                            <i class="fas fa-cog"></i> Interaction Settings
                        </div>
                        <div class="flex gap-6">
                            <div class="form-check">
                                <input type="checkbox" id="nofollow-${index}" ${block.data.rel_nofollow ? 'checked' : ''} onchange="updateBlock(${index}, 'rel_nofollow', this.checked)">
                                <label for="nofollow-${index}">No-Follow</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="newtab-${index}" ${block.data.target_blank ? 'checked' : ''} onchange="updateBlock(${index}, 'target_blank', this.checked)">
                                <label for="newtab-${index}">Open in New Tab</label>
                            </div>
                        </div>
                    </div>
                `;
            }
            // --- HERO STATS BLOCK ---
            else if (block.type === 'hero_stats') {
                let statsHtml = (block.data.stats || []).map((s, si) => `
                    <div class="flex gap-2 mb-2">
                        <input type="text" placeholder="Value (e.g. 10k+)" onchange="updateNestedBlock(${index}, 'stats', ${si}, 'value', this.value)" value="${s.value || ''}" class="form-control form-control-sm">
                        <input type="text" placeholder="Label" onchange="updateNestedBlock(${index}, 'stats', ${si}, 'label', this.value)" value="${s.label || ''}" class="form-control form-control-sm">
                        <button type="button" onclick="removeNestedItem(${index}, 'stats', ${si})" class="btn btn-secondary btn-sm" style="padding:0 0.5rem;"><i class="fas fa-times"></i></button>
                    </div>
                `).join('');

                contentHtml = `
                    <div class="flex items-center gap-2 mb-4" style="color:var(--primary); font-weight:700; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.05em;">
                        <i class="fas fa-chart-line"></i> Hero Stats Block
                    </div>
                    <div class="form-group"><label>Title</label><input type="text" onchange="updateBlock(${index}, 'title', this.value)" value="${block.data.title || ''}" class="form-control"></div>
                    <div class="form-group"><label>Description</label><textarea onchange="updateBlock(${index}, 'description', this.value)" class="form-control" rows="2">${block.data.description || ''}</textarea></div>
                    <div class="form-group">
                        <label>Hero Image URL</label>
                        <div class="flex gap-2">
                            <input type="url" onchange="updateBlock(${index}, 'image', this.value)" value="${block.data.image || ''}" class="form-control" placeholder="https://...">
                            <label class="btn btn-secondary" style="margin:0; cursor:pointer; padding:0 1rem; height:48px; display:flex; align-items:center; border-radius:12px;">
                                <i class="fas fa-upload"></i> <input type="file" onchange="uploadImage(this, ${index}, 'image')" accept="image/*" style="display:none;">
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="display:flex; justify-content:space-between; align-items:center;">Stats <button type="button" onclick="addNestedItem(${index}, 'stats')" class="btn btn-secondary" style="padding:0.25rem 0.5rem; font-size:0.7rem;"><i class="fas fa-plus"></i></button></label>
                        <div id="stats-container-${index}">${statsHtml}</div>
                    </div>
                `;
            }
            // --- TIMELINE BLOCK ---
            else if (block.type === 'timeline') {
                let eventsHtml = (block.data.events || []).map((e, ei) => `
                    <div class="card mb-2 p-3" style="background:#f8fafc; border:1px solid #e2e8f0;">
                         <div class="form-row mb-2">
                            <input type="text" placeholder="Year/Date" onchange="updateNestedBlock(${index}, 'events', ${ei}, 'year', this.value)" value="${e.year || ''}" class="form-control">
                            <input type="text" placeholder="Badge/Status" onchange="updateNestedBlock(${index}, 'events', ${ei}, 'badge', this.value)" value="${e.badge || ''}" class="form-control">
                         </div>
                         <input type="text" placeholder="Event Title" onchange="updateNestedBlock(${index}, 'events', ${ei}, 'title', this.value)" value="${e.title || ''}" class="form-control mb-2">
                         <div class="flex justify-end"><button type="button" onclick="removeNestedItem(${index}, 'events', ${ei})" class="btn btn-secondary btn-sm" style="color:#ef4444;"><i class="fas fa-trash"></i> Remove Event</button></div>
                    </div>
                `).join('');

                contentHtml = `
                    <div class="flex items-center gap-2 mb-4" style="color:var(--primary); font-weight:700; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.05em;">
                        <i class="fas fa-clock-rotate-left"></i> Timeline Block
                    </div>
                    <div class="form-group">
                        <label style="display:flex; justify-content:space-between; align-items:center;">Timeline Events <button type="button" onclick="addNestedItem(${index}, 'events', {year:'', title:'', badge:''})" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> Add Event</button></label>
                        <div id="events-container-${index}">${eventsHtml}</div>
                    </div>
                `;
            }
            // --- SPLIT CONTENT BLOCK ---
            else if (block.type === 'split_content') {
                 let statsHtml = (block.data.stats || []).map((s, si) => `
                    <div class="flex gap-2 mb-2">
                        <input type="text" placeholder="Value" onchange="updateNestedBlock(${index}, 'stats', ${si}, 'value', this.value)" value="${s.value || ''}" class="form-control form-control-sm">
                        <input type="text" placeholder="Label" onchange="updateNestedBlock(${index}, 'stats', ${si}, 'label', this.value)" value="${s.label || ''}" class="form-control form-control-sm">
                        <button type="button" onclick="removeNestedItem(${index}, 'stats', ${si})" class="btn btn-secondary btn-sm" style="padding:0 0.5rem;"><i class="fas fa-times"></i></button>
                    </div>
                `).join('');

                contentHtml = `
                    <div class="flex items-center gap-2 mb-4" style="color:var(--primary); font-weight:700; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.05em;">
                        <i class="fas fa-columns"></i> Split Content Block
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>Title</label><input type="text" onchange="updateBlock(${index}, 'title', this.value)" value="${block.data.title || ''}" class="form-control"></div>
                        <div class="form-group">
                            <label>Image Position</label>
                            <select onchange="updateBlock(${index}, 'position', this.value)" class="form-control">
                                <option value="left" ${block.data.position === 'left' ? 'selected' : ''}>Image Left</option>
                                <option value="right" ${block.data.position === 'right' ? 'selected' : ''}>Image Right</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group"><label>Description</label><textarea onchange="updateBlock(${index}, 'description', this.value)" class="form-control" rows="2">${block.data.description || ''}</textarea></div>
                    <div class="form-group">
                        <label>Feature Image URL</label>
                        <div class="flex gap-2">
                            <input type="url" onchange="updateBlock(${index}, 'image', this.value)" value="${block.data.image || ''}" class="form-control" placeholder="https://...">
                            <label class="btn btn-secondary" style="margin:0; cursor:pointer; padding:0 1rem; height:48px; display:flex; align-items:center; border-radius:12px;">
                                <i class="fas fa-upload"></i> <input type="file" onchange="uploadImage(this, ${index}, 'image')" accept="image/*" style="display:none;">
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                         <label style="display:flex; justify-content:space-between; align-items:center;">Mini Stats <button type="button" onclick="addNestedItem(${index}, 'stats')" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i></button></label>
                         <div id="stats-container-${index}">${statsHtml}</div>
                    </div>
                `;
            }
            // --- FEATURES BLOCK ---
            else if (block.type === 'features') {
                let itemsHtml = (block.data.items || []).map((it, iti) => `
                    <div class="card mb-2 p-3" style="background:#f8fafc; border:1px solid #e2e8f0;">
                         <input type="text" placeholder="Feature Title" onchange="updateNestedBlock(${index}, 'items', ${iti}, 'title', this.value)" value="${it.title || ''}" class="form-control mb-2">
                         <textarea placeholder="Feature Description" onchange="updateNestedBlock(${index}, 'items', ${iti}, 'description', this.value)" class="form-control mb-2" rows="2">${it.description || ''}</textarea>
                         <div class="flex justify-end"><button type="button" onclick="removeNestedItem(${index}, 'items', ${iti})" class="btn btn-secondary btn-sm" style="color:#ef4444;"><i class="fas fa-trash"></i> Remove</button></div>
                    </div>
                `).join('');

                contentHtml = `
                    <div class="flex items-center gap-2 mb-4" style="color:var(--primary); font-weight:700; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.05em;">
                        <i class="fas fa-list-check"></i> Features Grid Block
                    </div>
                    <div class="form-group">
                        <label style="display:flex; justify-content:space-between; align-items:center;">Features <button type="button" onclick="addNestedItem(${index}, 'items', {title:'', description:''})" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> Add Feature</button></label>
                        <div id="items-container-${index}">${itemsHtml}</div>
                    </div>
                `;
            }
            // --- TABS BLOCK ---
            else if (block.type === 'tabs') {
                 let tabsHtml = (block.data.tabs || []).map((t, ti) => `
                    <div class="card mb-2 p-3" style="background:#f8fafc;">
                         <input type="text" placeholder="Tab Title" onchange="updateNestedBlock(${index}, 'tabs', ${ti}, 'title', this.value)" value="${t.title || ''}" class="form-control mb-2">
                         <textarea placeholder="Tab Content" onchange="updateNestedBlock(${index}, 'tabs', ${ti}, 'content', this.value)" class="form-control mb-2" rows="3">${t.content || ''}</textarea>
                        <div class="flex justify-end"><button type="button" onclick="removeNestedItem(${index}, 'tabs', ${ti})" class="btn btn-secondary btn-sm" style="color:#ef4444;"><i class="fas fa-trash"></i> Remove Tab</button></div>
                    </div>
                `).join('');

                contentHtml = `
                    <div class="flex items-center gap-2 mb-4" style="color:var(--primary); font-weight:700; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.05em;">
                        <i class="fas fa-folder-tree"></i> Interactive Tabs Block
                    </div>
                    <div class="form-group">
                         <label style="display:flex; justify-content:space-between; align-items:center;">Tabs <button type="button" onclick="addNestedItem(${index}, 'tabs', {title:'', content:''})" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> Add Tab</button></label>
                         <div id="tabs-container-${index}">${tabsHtml}</div>
                    </div>
                `;
            }

            // --- CONTROLS ---
            const controls = document.createElement('div');
            controls.style.position = 'absolute';
            controls.style.top = '1.25rem';
            controls.style.right = '1.25rem';
            controls.style.display = 'flex';
            controls.style.gap = '0.5rem';
            
            const moveUpBtn = `<button type="button" onclick="moveBlock(${index}, -1)" class="btn btn-secondary" style="width:32px; height:32px; justify-content:center; padding:0; border-radius:8px;"><i class="fas fa-chevron-up" style="font-size:0.7rem;"></i></button>`;
            const moveDownBtn = `<button type="button" onclick="moveBlock(${index}, 1)" class="btn btn-secondary" style="width:32px; height:32px; justify-content:center; padding:0; border-radius:8px;"><i class="fas fa-chevron-down" style="font-size:0.7rem;"></i></button>`;
            const deleteBtn = `<button type="button" onclick="removeBlock(${index})" class="btn" style="width:32px; height:32px; justify-content:center; padding:0; border-radius:8px; background:rgba(239, 68, 68, 0.05); color:#ef4444;"><i class="fas fa-trash-can" style="font-size:0.7rem;"></i></button>`;
            
            controls.innerHTML = moveUpBtn + moveDownBtn + deleteBtn;

            el.innerHTML = contentHtml;
            el.appendChild(controls);
            container.appendChild(el);

            // Initialize CKEditor for text blocks
            if (block.type === 'text') {
                ClassicEditor
                    .create(document.querySelector(`#editor-${index}`))
                    .then(editor => {
                        editors[index] = editor;
                        editor.model.document.on('change:data', () => {
                            updateBlock(index, 'content', editor.getData());
                        });
                    })
                    .catch(error => console.error(error));
            }
        });

        input.value = JSON.stringify(blocks);
    }

    function addBlock(type) {
        if (!blocks) blocks = [];
        let data = {};
        
        if (type === 'text') data = { content: 'Enter your content here...' };
        else if (type === 'image') data = { url: '', alt: '' };
        else if (type === 'button') data = { text: 'Learn More', url: '#', rel_nofollow: false, target_blank: false };
        else if (type === 'hero_stats') data = { title: '', description: '', image: '', stats: [] };
        else if (type === 'timeline') data = { events: [] };
        else if (type === 'split_content') data = { title: '', description: '', image: '', position: 'left', stats: [] };
        else if (type === 'features') data = { items: [] };
        else if (type === 'tabs') data = { tabs: [] };
        
        blocks.push({ type: type, data: data });
        renderBlocks();
    }

    function addNestedItem(blockIndex, key, defaultData = {value: '', label: ''}) {
        if(!blocks[blockIndex].data[key]) blocks[blockIndex].data[key] = [];
        blocks[blockIndex].data[key].push(defaultData);
        renderBlocks();
    }

    function removeNestedItem(blockIndex, key, itemIndex) {
        blocks[blockIndex].data[key].splice(itemIndex, 1);
        renderBlocks();
    }

    function updateNestedBlock(blockIndex, key, itemIndex, field, value) {
        blocks[blockIndex].data[key][itemIndex][field] = value;
        document.getElementById('blocks-input').value = JSON.stringify(blocks);
    }

    function removeBlock(index) {
        if(confirm('Are you sure you want to remove this block?')) {
            blocks.splice(index, 1);
            renderBlocks();
        }
    }

    function moveBlock(index, direction) {
        if (index + direction < 0 || index + direction >= blocks.length) return;
        const temp = blocks[index];
        blocks[index] = blocks[index + direction];
        blocks[index + direction] = temp;
        renderBlocks();
    }

    function updateBlock(index, key, value) {
        blocks[index].data[key] = value;
        document.getElementById('blocks-input').value = JSON.stringify(blocks);
    }

    // Image Upload
    async function uploadImage(input, index, key = 'url') {
        const file = input.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('image', file);
        formData.append('_token', '{{ csrf_token() }}');

        try {
            const res = await fetch('{{ route('admin.builder.upload') }}', { method: 'POST', body: formData });
            const data = await res.json();
            
            if (data.url) {
                blocks[index].data[key] = data.url;
                renderBlocks();
            }
        } catch(e) { console.error(e); alert('Upload failed'); }
    }
</script>
