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
            el.style.marginBottom = '1.5rem';
            el.style.borderLeft = '4px solid var(--primary)';

            let contentHtml = '';
            
            // --- TEXT BLOCK ---
            if (block.type === 'text') {
                contentHtml = `
                    <div style="margin-bottom:1rem; font-weight:700; color:var(--primary); font-size:0.8rem; text-transform:uppercase;">
                        <i class="fas fa-align-left"></i> Text Content
                    </div>
                    <textarea id="editor-${index}">${block.data.content || ''}</textarea>
                `;
            } 
            // --- IMAGE BLOCK ---
            else if (block.type === 'image') {
                contentHtml = `
                    <div style="margin-bottom:1rem; font-weight:700; color:var(--primary); font-size:0.8rem; text-transform:uppercase;">
                        <i class="fas fa-image"></i> Image Block
                    </div>
                    <div style="display:grid; gap:1rem;">
                        <div style="display:flex; gap:0.5rem;">
                            <input type="url" onchange="updateBlock(${index}, 'url', this.value)" value="${block.data.url || ''}" class="form-control" style="flex:1;" placeholder="Image URL">
                            <label class="btn btn-secondary" style="margin:0; cursor:pointer; padding:0.75rem;">
                                <i class="fas fa-upload"></i> <input type="file" onchange="uploadImage(this, ${index})" accept="image/*" style="display:none;">
                            </label>
                        </div>
                        <input type="text" onchange="updateBlock(${index}, 'alt', this.value)" value="${block.data.alt || ''}" class="form-control" placeholder="Alt Text (SEO)">
                    </div>
                `;
            }
            // --- BUTTON BLOCK ---
            else if (block.type === 'button') {
                contentHtml = `
                    <div style="margin-bottom:1rem; font-weight:700; color:var(--primary); font-size:0.8rem; text-transform:uppercase;">
                        <i class="fas fa-link"></i> Button / Call to Action
                    </div>
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:0.75rem;">
                        <div class="form-group">
                            <label class="form-label">Button Text</label>
                            <input value="${block.data.text || ''}" onchange="updateBlock(${index}, 'text', this.value)" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Target URL</label>
                            <input value="${block.data.url || ''}" onchange="updateBlock(${index}, 'url', this.value)" class="form-control">
                        </div>
                    </div>
                    <div style="background:var(--bg-main); padding:0.75rem; border-radius:var(--radius-md); margin-top:0.5rem;">
                        <div style="font-size:0.7rem; font-weight:700; color:var(--text-muted); margin-bottom:0.5rem; text-transform:uppercase;">
                            <i class="fas fa-globe"></i> Meta Link Options
                        </div>
                        <div style="display:flex; gap:1.5rem;">
                            <label style="display:flex; align-items:center; gap:0.4rem; font-size:0.8rem; cursor:pointer;">
                                <input type="checkbox" ${block.data.rel_nofollow ? 'checked' : ''} onchange="updateBlock(${index}, 'rel_nofollow', this.checked)"> No-Follow
                            </label>
                            <label style="display:flex; align-items:center; gap:0.4rem; font-size:0.8rem; cursor:pointer;">
                                <input type="checkbox" ${block.data.target_blank ? 'checked' : ''} onchange="updateBlock(${index}, 'target_blank', this.checked)"> New Tab
                            </label>
                        </div>
                    </div>
                `;
            }

            // --- CONTROLS ---
            const controls = document.createElement('div');
            controls.style.position = 'absolute';
            controls.style.top = '1rem';
            controls.style.right = '1rem';
            controls.style.display = 'flex';
            controls.style.gap = '0.4rem';
            
            const moveUpBtn = `<button type="button" onclick="moveBlock(${index}, -1)" class="btn btn-secondary" style="padding:0.25rem 0.5rem; font-size:0.7rem;"><i class="fas fa-arrow-up"></i></button>`;
            const moveDownBtn = `<button type="button" onclick="moveBlock(${index}, 1)" class="btn btn-secondary" style="padding:0.25rem 0.5rem; font-size:0.7rem;"><i class="fas fa-arrow-down"></i></button>`;
            const deleteBtn = `<button type="button" onclick="removeBlock(${index})" class="btn btn-danger" style="padding:0.25rem 0.5rem; font-size:0.7rem;"><i class="fas fa-times"></i></button>`;
            
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
