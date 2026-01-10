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
        
        blocks.push({ type: type, data: data });
        renderBlocks();
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
                renderBlocks();
            }
        } catch(e) { console.error(e); alert('Upload failed'); }
    }
</script>
