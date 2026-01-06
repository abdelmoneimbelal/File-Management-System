@extends('layouts.app')

@section('title', 'Upload File')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card card-modern">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="bi bi-cloud-upload" style="font-size: 3rem; color: var(--primary-color);"></i>
                    </div>
                    <h2 class="card-title fw-bold mb-2">Upload New File</h2>
                    <p class="text-muted">Choose your file and start uploading</p>
                </div>

                <form id="uploadForm" method="POST" action="{{ route('files.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="file" class="form-label fw-semibold">
                            <i class="bi bi-file-earmark me-2"></i>Select File
                        </label>
                        <input type="file" 
                               name="file" 
                               id="file" 
                               class="form-control form-control-modern @error('file') is-invalid @enderror" 
                               required>
                        <div id="fileError" class="invalid-feedback d-none"></div>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Maximum file size: 10 MB
                        </div>
                        @error('file')
                            <div class="invalid-feedback d-block">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Progress Bar -->
                    <div id="progressContainer" class="mb-4 d-none">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-semibold" style="color: var(--primary-color);" id="progressText">0%</span>
                            <span class="text-muted" id="progressStatus">Uploading...</span>
                        </div>
                        <div class="progress progress-modern">
                            <div id="progressBar" 
                                 class="progress-bar progress-bar-modern" 
                                 role="progressbar" 
                                 style="width: 0%" 
                                 aria-valuenow="0" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between gap-2">
                        <a href="{{ route('files.index') }}" 
                           id="cancelBtn"
                           class="btn btn-outline-secondary flex-fill">
                            <i class="bi bi-x-lg me-2"></i>Cancel
                        </a>
                        <button type="submit" 
                                id="submitBtn"
                                class="btn btn-primary-modern text-white flex-fill">
                            <span id="submitText">
                                <i class="bi bi-cloud-upload me-2"></i>Upload File
                            </span>
                            <span id="submitLoader" class="spinner-border spinner-border-sm d-none me-2" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('uploadForm');
    const fileInput = document.getElementById('file');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitLoader = document.getElementById('submitLoader');
    const progressContainer = document.getElementById('progressContainer');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const fileError = document.getElementById('fileError');
    const cancelBtn = document.getElementById('cancelBtn');

    // Toast configuration
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const file = fileInput.files[0];
        if (!file) {
            Toast.fire({
                icon: 'error',
                title: 'Please select a file to upload'
            });
            return;
        }

        // Reset UI
        fileError.classList.add('d-none');
        fileError.textContent = '';
        progressContainer.classList.remove('d-none');
        progressBar.style.width = '0%';
        progressBar.setAttribute('aria-valuenow', '0');
        progressText.textContent = '0%';
        document.getElementById('progressStatus').textContent = 'Uploading...';
        submitBtn.disabled = true;
        submitText.classList.add('d-none');
        submitLoader.classList.remove('d-none');
        cancelBtn.style.pointerEvents = 'none';
        cancelBtn.style.opacity = '0.5';

        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();

        // Upload progress
        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                const percentComplete = (e.loaded / e.total) * 100;
                const roundedPercent = Math.round(percentComplete);
                progressBar.style.width = percentComplete + '%';
                progressBar.setAttribute('aria-valuenow', roundedPercent);
                progressText.textContent = roundedPercent + '%';
                
                if (percentComplete === 100) {
                    document.getElementById('progressStatus').textContent = 'Processing...';
                }
            }
        });

        // Request complete
        xhr.addEventListener('load', function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                
                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    }).then(() => {
                        window.location.href = '{{ route("files.index") }}';
                    });
                } else {
                    showError(response.message || 'Upload failed');
                }
            } else {
                try {
                    const response = JSON.parse(xhr.responseText);
                    let errorMessage = response.message || 'An error occurred during upload';
                    
                    if (response.errors) {
                        const errors = Object.values(response.errors).flat();
                        errorMessage = errors.join('<br>');
                    }
                    
                    showError(errorMessage);
                } catch (e) {
                    showError('An error occurred during upload');
                }
            }
            
            resetUI();
        });

        // Request error
        xhr.addEventListener('error', function() {
            showError('Connection error occurred');
            resetUI();
        });

        // Request abort
        xhr.addEventListener('abort', function() {
            resetUI();
        });

        // Send request
        xhr.open('POST', form.action);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.send(formData);

        function showError(message) {
            Toast.fire({
                icon: 'error',
                title: 'Upload Failed',
                html: message
            });
        }

        function resetUI() {
            submitBtn.disabled = false;
            submitText.classList.remove('d-none');
            submitLoader.classList.add('d-none');
            progressContainer.classList.add('d-none');
            cancelBtn.style.pointerEvents = 'auto';
            cancelBtn.style.opacity = '1';
        }
    });
});
</script>
@endsection

