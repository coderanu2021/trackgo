# Upload Debugging Steps

## Current Issue
Getting "Validation failed: The image failed to upload." error when trying to upload images.

## Debugging Steps to Follow

### 1. Test Simple PHP Upload
Visit `/simple-upload-test.php` and try uploading a file to see if the issue is at the web server level.

### 2. Check Laravel Logs
After attempting an upload, check `storage/logs/laravel.log` for detailed error information.

### 3. Test Upload Info
Visit `/admin/upload-info` to verify server configuration.

### 4. Test Upload Page
Visit `/admin/test-upload` to use the comprehensive test page.

### 5. Check PHP Configuration
Visit `/admin/php-info` to see full PHP configuration.

## Common Issues and Solutions

### Issue 1: File Not Received
- **Symptom**: `has_file` is false in logs
- **Cause**: Web server configuration, PHP limits, or form encoding
- **Solution**: Check `upload_max_filesize`, `post_max_size`, and form `enctype`

### Issue 2: File Upload Error
- **Symptom**: File error code is not 0
- **Cause**: PHP upload limits or temporary directory issues
- **Solution**: Increase PHP limits or fix temp directory permissions

### Issue 3: Validation Failure
- **Symptom**: File received but validation fails
- **Cause**: File type, size, or Laravel validation rules
- **Solution**: Check file MIME type and size against validation rules

### Issue 4: Storage Failure
- **Symptom**: File validates but storage fails
- **Cause**: Directory permissions or disk space
- **Solution**: Check storage directory permissions and available space

## Current Configuration
- Upload max filesize: 2M
- Post max size: 8M
- Memory limit: 128M
- Storage disk: public
- Upload directory: storage/app/public/uploads/

## Next Steps
1. Try the simple PHP upload test first
2. Check the Laravel logs for detailed error information
3. If simple PHP works but Laravel doesn't, the issue is in Laravel
4. If simple PHP doesn't work, the issue is at the web server/PHP level