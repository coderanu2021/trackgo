<script>
    // Global block state
    // 'blocks' variable must be initialized in the parent view

    function renderBlocks() {
        const container = document.getElementById('blocks-container');
        const emptyState = document.getElementById('empty-state');
        const input = document.getElementById('blocks-input');
        
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
            el.className = 'glass';
            el.style.padding = '1rem';
            el.style.marginBottom = '1rem';
            el.style.position = 'relative';

            let contentHtml = '';
            
            // --- TEXT BLOCK ---
            if (block.type === 'text') {
                contentHtml = `
                    <div style="margin-bottom:0.5rem; font-weight:600;">Text Block</div>
                    <div style="margin-bottom:0.5rem; background: #f3f4f6; padding:0.25rem; border-radius:4px; display:flex; gap:0.5rem;">
                        <button type="button" onclick="execCmd('bold')" style="font-weight:bold; padding:0.25rem 0.5rem;">B</button>
                        <button type="button" onclick="execCmd('italic')" style="font-style:italic; padding:0.25rem 0.5rem;">I</button>
                    </div>
                    <div class="rich-editor" contenteditable="true" oninput="updateBlock(${index}, 'content', this.innerHTML)" style="width:100%; padding:0.5rem; border:1px solid #d1d5db; border-radius:4px; min-height:100px; background:white;">${block.data.content || ''}</div>
                `;
            } 
            // --- IMAGE BLOCK ---
            else if (block.type === 'image') {
                contentHtml = `
                    <div style="margin-bottom:0.5rem; font-weight:600;">Image Block</div>
                    <div style="display:flex; gap:1rem; align-items:center;">
                        <input type="url" onchange="updateBlock(${index}, 'url', this.value)" value="${block.data.url || ''}" style="flex:1; padding:0.5rem; border:1px solid #d1d5db; border-radius:4px;" placeholder="Image URL">
                        <input type="file" onchange="uploadImage(this, ${index})" accept="image/*">
                    </div>
                `;
            } 
            // --- FEATURES BLOCK (Dynamic) ---
            else if (block.type === 'features') {
                const items = block.data.items || [];
                let itemsHtml = items.map((item, i) => `
                    <div style="margin-bottom:0.5rem; padding:0.5rem; border:1px solid #eee; border-radius:4px;">
                        <div style="display:flex; justify-content:space-between; margin-bottom:0.5rem;">
                            <strong>Feature ${i+1}</strong>
                            <button type="button" onclick="removeItem(${index}, 'items', ${i})" style="color:red; border:none; background:none;">&times;</button>
                        </div>
                        <input placeholder="Title" value="${item.title || ''}" onchange="updateItem(${index}, 'items', ${i}, 'title', this.value)" style="width:100%; margin-bottom:0.25rem; padding:0.25rem;">
                        <textarea placeholder="Description" onchange="updateItem(${index}, 'items', ${i}, 'description', this.value)" style="width:100%; padding:0.25rem;">${item.description || ''}</textarea>
                    </div>
                `).join('');

                contentHtml = `
                    <div style="margin-bottom:0.5rem; font-weight:600;">Features Grid</div>
                    ${itemsHtml}
                    <button type="button" onclick="addItem(${index}, 'items', {title:'', description:''})" style="color:var(--primary); background:none; border:none; cursor:pointer;">+ Add Feature</button>
                `;
            }
            // --- HERO STATS BLOCK ---
            else if (block.type === 'hero_stats') {
                const stats = block.data.stats || [];
                let statsHtml = stats.map((stat, i) => `
                    <div style="display:flex; gap:0.5rem; margin-bottom:0.25rem;">
                        <input placeholder="Value (e.g. 100+)" value="${stat.value || ''}" onchange="updateItem(${index}, 'stats', ${i}, 'value', this.value)" style="flex:1; padding:0.25rem;">
                        <input placeholder="Label (e.g. Cities)" value="${stat.label || ''}" onchange="updateItem(${index}, 'stats', ${i}, 'label', this.value)" style="flex:1; padding:0.25rem;">
                        <button type="button" onclick="removeItem(${index}, 'stats', ${i})" style="color:red; border:none; background:none;">&times;</button>
                    </div>
                `).join('');

                contentHtml = `
                    <div style="margin-bottom:0.5rem; font-weight:600;">Hero Stats Block</div>
                    <input placeholder="Title" value="${block.data.title || ''}" onchange="updateBlock(${index}, 'title', this.value)" style="width:100%; margin-bottom:0.5rem; padding:0.5rem; border:1px solid #ddd;">
                    <textarea placeholder="Description" onchange="updateBlock(${index}, 'description', this.value)" style="width:100%; margin-bottom:0.5rem; padding:0.5rem; border:1px solid #ddd;">${block.data.description || ''}</textarea>
                    <input placeholder="Image URL" value="${block.data.image || ''}" onchange="updateBlock(${index}, 'image', this.value)" style="width:100%; margin-bottom:0.5rem; padding:0.5rem; border:1px solid #ddd;">
                    <div style="margin-top:0.5rem;">
                        <strong>Stats:</strong>
                        ${statsHtml}
                        <button type="button" onclick="addItem(${index}, 'stats', {value:'', label:''})">+ Add Stat</button>
                    </div>
                `;
            }
            // --- TIMELINE BLOCK ---
            else if (block.type === 'timeline') {
                const events = block.data.events || [];
                let eventsHtml = events.map((ev, i) => `
                    <div style="margin-bottom:0.5rem; padding:0.5rem; border:1px solid #eee; background:#f9f9f9;">
                        <div style="display:flex; justify-content:space-between;">
                            <span>Event ${i+1}</span>
                            <button type="button" onclick="removeItem(${index}, 'events', ${i})" style="color:red; border:none; background:none;">&times;</button>
                        </div>
                        <input placeholder="Year" value="${ev.year || ''}" onchange="updateItem(${index}, 'events', ${i}, 'year', this.value)" style="width:30%; margin-right:2%;">
                        <input placeholder="Title" value="${ev.title || ''}" onchange="updateItem(${index}, 'events', ${i}, 'title', this.value)" style="width:65%;">
                        <input placeholder="Badge (e.g. 24k Cameras)" value="${ev.badge || ''}" onchange="updateItem(${index}, 'events', ${i}, 'badge', this.value)" style="width:100%; margin-top:0.25rem;">
                    </div>
                `).join('');

                contentHtml = `
                    <div style="margin-bottom:0.5rem; font-weight:600;">Timeline Block</div>
                    ${eventsHtml}
                    <button type="button" onclick="addItem(${index}, 'events', {year:'', title:'', badge:''})">+ Add Event</button>
                `;
            }
            // --- SPLIT CONTENT BLOCK ---
            else if (block.type === 'split_content') {
               const stats = block.data.stats || [];
               let statsHtml = stats.map((stat, i) => `
                    <div style="display:flex; gap:0.5rem; margin-bottom:0.25rem;">
                        <input placeholder="Value" value="${stat.value || ''}" onchange="updateItem(${index}, 'stats', ${i}, 'value', this.value)" style="flex:1; padding:0.25rem;">
                        <input placeholder="Label" value="${stat.label || ''}" onchange="updateItem(${index}, 'stats', ${i}, 'label', this.value)" style="flex:1; padding:0.25rem;">
                        <button type="button" onclick="removeItem(${index}, 'stats', ${i})" style="color:red; border:none; background:none;">&times;</button>
                    </div>
                `).join('');

                contentHtml = `
                    <div style="margin-bottom:0.5rem; font-weight:600;">Split Content (Img + Text)</div>
                    <select onchange="updateBlock(${index}, 'position', this.value)" style="margin-bottom:0.5rem;">
                        <option value="left" ${block.data.position === 'left' ? 'selected' : ''}>Image Left</option>
                        <option value="right" ${block.data.position === 'right' ? 'selected' : ''}>Image Right</option>
                    </select>
                    <input placeholder="Image URL" value="${block.data.image || ''}" onchange="updateBlock(${index}, 'image', this.value)" style="width:100%; margin-bottom:0.5rem; padding:0.5rem; border:1px solid #ddd;">
                    <input placeholder="Title" value="${block.data.title || ''}" onchange="updateBlock(${index}, 'title', this.value)" style="width:100%; margin-bottom:0.5rem; padding:0.5rem; border:1px solid #ddd;">
                    <textarea placeholder="Description" onchange="updateBlock(${index}, 'description', this.value)" style="width:100%; margin-bottom:0.5rem; padding:0.5rem; border:1px solid #ddd; min-height:80px;">${block.data.description || ''}</textarea>
                    <div style="margin-top:0.5rem;">
                        <strong>Stats:</strong>
                        ${statsHtml}
                        <button type="button" onclick="addItem(${index}, 'stats', {value:'', label:''})">+ Add Stat</button>
                    </div>
                `;
            }
            // ... (keep legacy blocks like tabs/table simpler or update if needed)

            // --- CONTROLS ---
            const controls = document.createElement('div');
            controls.style.position = 'absolute';
            controls.style.top = '0.5rem';
            controls.style.right = '0.5rem';
            
            const moveUpBtn = `<button type="button" onclick="moveBlock(${index}, -1)" style="margin-right:0.5rem; cursor:pointer; background:none; border:none;">↑</button>`;
            const moveDownBtn = `<button type="button" onclick="moveBlock(${index}, 1)" style="margin-right:0.5rem; cursor:pointer; background:none; border:none;">↓</button>`;
            const deleteBtn = `<button type="button" onclick="removeBlock(${index})" style="color:#ef4444; cursor:pointer; background:none; border:none; font-size:1.2rem;">&times;</button>`;
            
            controls.innerHTML = moveUpBtn + moveDownBtn + deleteBtn;

            el.innerHTML = contentHtml;
            el.appendChild(controls);
            container.appendChild(el);
        });

        input.value = JSON.stringify(blocks);
    }

    // --- ACTIONS ---

    function addBlock(type) {
        if (!blocks) blocks = [];
        let data = {};
        
        if (type === 'features') data = { items: [{title:'Feature 1', description:'Desc'}] };
        else if (type === 'hero_stats') data = { title:'Hero Title', description:'Hero desc', stats:[{value:'100+', label:'Items'}] };
        else if (type === 'timeline') data = { events:[{year:'2025', title:'Event', badge:'Info'}] };
        else if (type === 'split_content') data = { position:'left', title:'Section Title', description:'...', stats:[{value:'50', label:'Units'}] };
        else if (type === 'text') data = { content: 'Enter text here...' };
        else if (type === 'image') data = { url: '' };
        else if (type === 'button') data = { text: 'Click Me', url: '#' };
        else if (type === 'table') data = { rows: [['H1', 'H2'], ['D1', 'D2']] };
        else if (type === 'tabs') data = { tabs: [{title:'Tab 1', content:'Content'}] };
        
        blocks.push({ type: type, data: data });
        renderBlocks();
    }

    function removeBlock(index) {
        if(confirm('Delete this block?')) {
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

    // --- GENERIC ITEM HELPERS (for Features, Stats, Timeline) ---
    function addItem(blockIndex, arrayKey, emptyObj) {
        if (!blocks[blockIndex].data[arrayKey]) blocks[blockIndex].data[arrayKey] = [];
        blocks[blockIndex].data[arrayKey].push(emptyObj);
        renderBlocks();
    }
    
    function removeItem(blockIndex, arrayKey, itemIndex) {
        blocks[blockIndex].data[arrayKey].splice(itemIndex, 1);
        renderBlocks();
    }
    
    function updateItem(blockIndex, arrayKey, itemIndex, key, value) {
        blocks[blockIndex].data[arrayKey][itemIndex][key] = value;
        document.getElementById('blocks-input').value = JSON.stringify(blocks);
    }

    // Rich Text Command
    function execCmd(command) {
        document.execCommand(command, false, null);
    }

    // Image Upload
    async function uploadImage(input, index) {
        const file = input.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('image', file);
        formData.append('_token', '{{ csrf_token() }}');

        try {
            const res = await fetch('{{ route('admin.builder.upload') }}', { method: 'POST', body: formData });
            const data = await res.json();
            
            if (data.url) {
                blocks[index].data.url = data.url;
                if(blocks[index].type === 'hero_stats' || blocks[index].type === 'split_content') {
                    blocks[index].data.image = data.url;
                }
                renderBlocks();
            }
        } catch(e) { console.error(e); alert('Upload failed'); }
    }
</script>
