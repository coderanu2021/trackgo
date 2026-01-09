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
                        <button type="button" onclick="execCmd('insertUnorderedList')" style="padding:0.25rem 0.5rem;">• List</button>
                    </div>
                    <div 
                        contenteditable="true" 
                        oninput="updateBlock(${index}, 'content', this.innerHTML)" 
                        style="width:100%; padding:0.5rem; border:1px solid #d1d5db; border-radius:4px; min-height:100px; background:white;"
                    >${block.data.content || ''}</div>
                `;
            } 
            // --- IMAGE BLOCK ---
            else if (block.type === 'image') {
                contentHtml = `
                    <div style="margin-bottom:0.5rem; font-weight:600;">Image Block</div>
                    <div style="display:flex; gap:1rem; align-items:center;">
                        <div style="flex:1;">
                            <input 
                                type="url" 
                                onchange="updateBlock(${index}, 'url', this.value)" 
                                value="${block.data.url || ''}" 
                                style="width:100%; padding:0.5rem; border:1px solid #d1d5db; border-radius:4px; margin-bottom:0.5rem;" 
                                placeholder="Image URL"
                                id="img-url-${index}"
                            >
                            <input type="file" onchange="uploadImage(this, ${index})" accept="image/*" style="font-size:0.875rem;">
                        </div>
                        <div style="width:100px; height:100px; background:#f3f4f6; border-radius:4px; overflow:hidden; display:flex; align-items:center; justify-content:center;">
                            ${block.data.url ? `<img src="${block.data.url}" style="width:100%; height:100%; object-fit:cover;">` : '<span style="color:#9ca3af; font-size:0.75rem;">Preview</span>'}
                        </div>
                    </div>
                `;
            } 
            // --- FEATURES BLOCK (Legacy) ---
            else if (block.type === 'features') {
                 contentHtml = `
                    <div style="margin-bottom:0.5rem; font-weight:600;">Features Grid (3 items)</div>
                    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:0.5rem;">
                        <input onchange="updateBlock(${index}, 'title1', this.value)" value="${block.data.title1 || ''}" placeholder="Title 1" style="padding:0.5rem; border:1px solid #d1d5db; border-radius:4px; width:100%; box-sizing:border-box;">
                        <input onchange="updateBlock(${index}, 'title2', this.value)" value="${block.data.title2 || ''}" placeholder="Title 2" style="padding:0.5rem; border:1px solid #d1d5db; border-radius:4px; width:100%; box-sizing:border-box;">
                        <input onchange="updateBlock(${index}, 'title3', this.value)" value="${block.data.title3 || ''}" placeholder="Title 3" style="padding:0.5rem; border:1px solid #d1d5db; border-radius:4px; width:100%; box-sizing:border-box;">
                    </div>
                `;
            }
            // --- BUTTON BLOCK ---
            else if (block.type === 'button') {
                contentHtml = `
                    <div style="margin-bottom:0.5rem; font-weight:600;">Button Block</div>
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1rem;">
                        <div>
                            <label style="display:block; font-size:0.8rem; color:#6b7280;">Button Text</label>
                            <input type="text" onchange="updateBlock(${index}, 'text', this.value)" value="${block.data.text || ''}" style="width:100%; padding:0.5rem; border:1px solid #d1d5db; border-radius:4px;">
                        </div>
                        <div>
                            <label style="display:block; font-size:0.8rem; color:#6b7280;">Link URL</label>
                            <input type="url" onchange="updateBlock(${index}, 'url', this.value)" value="${block.data.url || ''}" style="width:100%; padding:0.5rem; border:1px solid #d1d5db; border-radius:4px;">
                        </div>
                    </div>
                `;
            }
            // --- TABLE BLOCK ---
            else if (block.type === 'table') {
                const rows = block.data.rows || [['Header 1', 'Header 2'], ['Row 1, Col 1', 'Row 1, Col 2']];
                
                let tableHtml = '<table style="width:100%; border-collapse:collapse; margin-top:0.5rem;">';
                rows.forEach((row, rIndex) => {
                    tableHtml += '<tr>';
                    row.forEach((cell, cIndex) => {
                        tableHtml += `
                            <td style="padding:0; border:1px solid #d1d5db;">
                                <input 
                                    value="${cell}" 
                                    onchange="updateTableCell(${index}, ${rIndex}, ${cIndex}, this.value)"
                                    style="width:100%; padding:0.5rem; border:none; box-sizing:border-box;"
                                >
                            </td>
                        `;
                    });
                    tableHtml += `
                        <td style="width:30px; text-align:center;">
                            <button type="button" onclick="removeTableRow(${index}, ${rIndex})" style="color:red; border:none; background:none; cursor:pointer;">&times;</button>
                        </td>
                    `;
                    tableHtml += '</tr>';
                });
                tableHtml += '</table>';
                
                contentHtml = `
                    <div style="margin-bottom:0.5rem; font-weight:600;">Table Block</div>
                    ${tableHtml}
                    <button type="button" onclick="addTableRow(${index})" style="margin-top:0.5rem; font-size:0.875rem; color:var(--primary-color); background:none; border:none; cursor:pointer;">+ Add Row</button>
                `;
            }
            // --- TABS BLOCK ---
            else if (block.type === 'tabs') {
                const tabs = block.data.tabs || [{ title: 'Tab 1', content: 'Content 1' }];
                
                let tabsHtml = '<div style="margin-top:0.5rem;">';
                tabs.forEach((tab, tIndex) => {
                    tabsHtml += `
                        <div style="border:1px solid #e5e7eb; padding:1rem; margin-bottom:0.5rem; border-radius:8px; background:#f9fafb;">
                            <div style="display:flex; justify-content:space-between; margin-bottom:0.5rem;">
                                <input 
                                    value="${tab.title}" 
                                    placeholder="Tab Title"
                                    onchange="updateTabTitle(${index}, ${tIndex}, this.value)"
                                    style="font-weight:600; padding:0.25rem; border:1px solid #d1d5db; border-radius:4px;"
                                >
                                <button type="button" onclick="removeTab(${index}, ${tIndex})" style="color:red; border:none; background:none; cursor:pointer;">&times;</button>
                            </div>
                            <textarea 
                                onchange="updateTabContent(${index}, ${tIndex}, this.value)" 
                                style="width:100%; padding:0.5rem; border:1px solid #d1d5db; border-radius:4px; min-height:80px;"
                                placeholder="Tab Content"
                            >${tab.content}</textarea>
                        </div>
                    `;
                });
                tabsHtml += '</div>';

                contentHtml = `
                    <div style="margin-bottom:0.5rem; font-weight:600;">Tabs Block</div>
                    ${tabsHtml}
                    <button type="button" onclick="addTab(${index})" style="margin-top:0.5rem; font-size:0.875rem; color:var(--primary-color); background:none; border:none; cursor:pointer;">+ Add Tab</button>
                `;
            }

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
        if (type === 'table') {
            data = { rows: [['Header 1', 'Header 2'], ['Data 1', 'Data 2']] };
        } else if (type === 'tabs') {
            data = { tabs: [{ title: 'Tab 1', content: 'Content 1' }, { title: 'Tab 2', content: 'Content 2' }] };
        }
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
            // Show loading state if desired
            const res = await fetch('{{ route('admin.builder.upload') }}', {
                method: 'POST',
                body: formData
            });
            const data = await res.json();
            
            if (data.url) {
                blocks[index].data.url = data.url;
                renderBlocks(); // Re-render to show preview
            } else {
                alert('Upload failed');
            }
        } catch (e) {
            console.error(e);
            alert('Upload error');
        }
    }

    // Table Helpers
    function updateTableCell(blockIndex, rowIndex, colIndex, value) {
        blocks[blockIndex].data.rows[rowIndex][colIndex] = value;
        document.getElementById('blocks-input').value = JSON.stringify(blocks);
    }

    function addTableRow(blockIndex) {
        const cols = blocks[blockIndex].data.rows[0].length;
        const newRow = new Array(cols).fill('');
        blocks[blockIndex].data.rows.push(newRow);
        renderBlocks();
    }

    function removeTableRow(blockIndex, rowIndex) {
        blocks[blockIndex].data.rows.splice(rowIndex, 1);
        renderBlocks();
    }

    // Tabs Helpers
    function addTab(blockIndex) {
        blocks[blockIndex].data.tabs.push({ title: 'New Tab', content: '' });
        renderBlocks();
    }

    function removeTab(blockIndex, tabIndex) {
        blocks[blockIndex].data.tabs.splice(tabIndex, 1);
        renderBlocks();
    }

    function updateTabTitle(blockIndex, tabIndex, value) {
        blocks[blockIndex].data.tabs[tabIndex].title = value;
        document.getElementById('blocks-input').value = JSON.stringify(blocks);
    }

    function updateTabContent(blockIndex, tabIndex, value) {
        blocks[blockIndex].data.tabs[tabIndex].content = value;
        document.getElementById('blocks-input').value = JSON.stringify(blocks);
    }
</script>
