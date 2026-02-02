<!DOCTYPE html>
<html>
<head>
    <title>Test Upload</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .info { background: #f0f0f0; padding: 10px; margin: 10px 0; border-radius: 5px; }
        .error { color: red; }
        .success { color: green; }
        #result { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Test Image Upload</h1>
    
    <div class="info">
        <h3>Upload Information</h3>
        <div id="upload-info">Loading...</div>
    </div>
    
    <form id="upload-form" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="image-input">Select Image:</label>
            <input type="file" id="image-input" accept="image/*" required>
        </div>
        <div style="margin-top: 10px;">
            <button type="submit">Upload via Laravel</button>
            <button type="button" onclick="testSimpleUpload()">Test Simple PHP Upload</button>
        </div>
    </form>
    
    <div id="result"></div>
    
    <script>
        // Load upload info
        fetch('{{ route('admin.upload-info') }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('upload-info').innerHTML = `
                    <p><strong>Upload Max Filesize:</strong> ${data.upload_max_filesize}</p>
                    <p><strong>Post Max Size:</strong> ${data.post_max_size}</p>
                    <p><strong>Max File Uploads:</strong> ${data.max_file_uploads}</p>
                    <p><strong>Memory Limit:</strong> ${data.memory_limit}</p>
                    <p><strong>Uploads Directory Exists:</strong> ${data.uploads_dir_exists ? 'Yes' : 'No'}</p>
                    <p><strong>Uploads Directory Writable:</strong> ${data.uploads_dir_writable ? 'Yes' : 'No'}</p>
                    <p><strong>Storage Link Exists:</strong> ${data.storage_link_exists ? 'Yes' : 'No'}</p>
                `;
            })
            .catch(error => {
                document.getElementById('upload-info').innerHTML = '<p class="error">Failed to load upload info</p>';
            });

        document.getElementById('upload-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const fileInput = document.getElementById('image-input');
            const file = fileInput.files[0];
            const resultDiv = document.getElementById('result');
            
            if (!file) {
                resultDiv.innerHTML = '<p class="error">Please select a file</p>';
                return;
            }
            
            console.log('File details:', {
                name: file.name,
                size: file.size,
                type: file.type,
                lastModified: file.lastModified
            });
            
            resultDiv.innerHTML = '<p>Uploading...</p>';
            
            const formData = new FormData();
            formData.append('image', file);
            formData.append('_token', '{{ csrf_token() }}');
            
            console.log('FormData contents:');
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }
            
            try {
                const response = await fetch('{{ route('admin.pages.upload') }}', {
                    method: 'POST',
                    body: formData
                });
                
                console.log('Response status:', response.status);
                console.log('Response headers:', [...response.headers.entries()]);
                
                const responseText = await response.text();
                console.log('Raw response:', responseText);
                
                let data;
                try {
                    data = JSON.parse(responseText);
                } catch (parseError) {
                    console.error('Failed to parse JSON:', parseError);
                    resultDiv.innerHTML = `<p class="error">Invalid response format: ${responseText}</p>`;
                    return;
                }
                
                console.log('Parsed response data:', data);
                
                if (data.url) {
                    resultDiv.innerHTML = `
                        <p class="success">Upload successful!</p>
                        <p><strong>URL:</strong> ${data.url}</p>
                        <p><strong>Path:</strong> ${data.path}</p>
                        <img src="${data.url}" style="max-width: 200px; border: 1px solid #ccc;" alt="Uploaded image">
                    `;
                } else {
                    resultDiv.innerHTML = `<p class="error">Upload failed: ${data.error || 'Unknown error'}</p>`;
                }
            } catch (error) {
                console.error('Upload error:', error);
                resultDiv.innerHTML = `<p class="error">Upload failed: ${error.message}</p>`;
            }
        });
        
        // Test simple PHP upload
        window.testSimpleUpload = async function() {
            const fileInput = document.getElementById('image-input');
            const file = fileInput.files[0];
            const resultDiv = document.getElementById('result');
            
            if (!file) {
                resultDiv.innerHTML = '<p class="error">Please select a file</p>';
                return;
            }
            
            resultDiv.innerHTML = '<p>Testing simple PHP upload...</p>';
            
            const formData = new FormData();
            formData.append('image', file);
            
            try {
                const response = await fetch('/simple-upload-test.php', {
                    method: 'POST',
                    body: formData
                });
                
                const responseText = await response.text();
                console.log('Simple upload response:', responseText);
                
                const data = JSON.parse(responseText);
                
                resultDiv.innerHTML = `
                    <h3>Simple PHP Upload Test Results:</h3>
                    <pre>${JSON.stringify(data, null, 2)}</pre>
                `;
            } catch (error) {
                console.error('Simple upload error:', error);
                resultDiv.innerHTML = `<p class="error">Simple upload failed: ${error.message}</p>`;
            }
        };
    </script>
</body>
</html>