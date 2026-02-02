<!DOCTYPE html>
<html>
<head>
    <title>Simple Upload Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .result { margin: 20px 0; padding: 10px; border: 1px solid #ccc; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h1>Simple Upload Test</h1>
    
    <h2>Method 1: Traditional Form Submit</h2>
    <form action="{{ route('admin.pages.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Upload via Form</button>
    </form>
    
    <h2>Method 2: JavaScript Fetch</h2>
    <input type="file" id="js-file" accept="image/*">
    <button onclick="uploadViaJS()">Upload via JavaScript</button>
    
    <h2>Method 3: XMLHttpRequest</h2>
    <input type="file" id="xhr-file" accept="image/*">
    <button onclick="uploadViaXHR()">Upload via XHR</button>
    
    <div id="result" class="result"></div>
    
    <script>
        async function uploadViaJS() {
            const fileInput = document.getElementById('js-file');
            const file = fileInput.files[0];
            const resultDiv = document.getElementById('result');
            
            if (!file) {
                resultDiv.innerHTML = '<p class="error">Please select a file</p>';
                return;
            }
            
            console.log('JS Upload - File:', file);
            
            const formData = new FormData();
            formData.append('image', file);
            formData.append('_token', '{{ csrf_token() }}');
            
            // Log FormData contents
            console.log('FormData entries:');
            for (let pair of formData.entries()) {
                console.log(pair[0], pair[1]);
            }
            
            try {
                const response = await fetch('{{ route('admin.pages.upload') }}', {
                    method: 'POST',
                    body: formData
                });
                
                const text = await response.text();
                console.log('Response:', text);
                
                const data = JSON.parse(text);
                
                if (data.url) {
                    resultDiv.innerHTML = `<p class="success">JS Upload Success: ${data.url}</p>`;
                } else {
                    resultDiv.innerHTML = `<p class="error">JS Upload Failed: ${data.error}</p>`;
                }
            } catch (error) {
                console.error('JS Upload Error:', error);
                resultDiv.innerHTML = `<p class="error">JS Upload Error: ${error.message}</p>`;
            }
        }
        
        function uploadViaXHR() {
            const fileInput = document.getElementById('xhr-file');
            const file = fileInput.files[0];
            const resultDiv = document.getElementById('result');
            
            if (!file) {
                resultDiv.innerHTML = '<p class="error">Please select a file</p>';
                return;
            }
            
            console.log('XHR Upload - File:', file);
            
            const formData = new FormData();
            formData.append('image', file);
            formData.append('_token', '{{ csrf_token() }}');
            
            const xhr = new XMLHttpRequest();
            
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    console.log('XHR Response:', xhr.responseText);
                    
                    try {
                        const data = JSON.parse(xhr.responseText);
                        if (data.url) {
                            resultDiv.innerHTML = `<p class="success">XHR Upload Success: ${data.url}</p>`;
                        } else {
                            resultDiv.innerHTML = `<p class="error">XHR Upload Failed: ${data.error}</p>`;
                        }
                    } catch (error) {
                        resultDiv.innerHTML = `<p class="error">XHR Parse Error: ${error.message}</p>`;
                    }
                }
            };
            
            xhr.open('POST', '{{ route('admin.pages.upload') }}', true);
            xhr.send(formData);
        }
    </script>
</body>
</html>