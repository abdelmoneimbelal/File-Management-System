@extends('layouts.app')

@section('title', 'Files List')

@section('content')
<div class="card card-modern">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="card-title fw-bold mb-1">
                    <i class="bi bi-files me-2" style="color: var(--primary-color);"></i>My Files
                </h2>
                <p class="text-muted mb-0 small">Manage and download your uploaded files</p>
            </div>
            <a href="{{ route('files.create') }}" class="btn btn-primary-modern text-white">
                <i class="bi bi-plus-lg me-2"></i>Upload New File
            </a>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('files.index') }}" class="mb-4">
            <div class="row g-2">
                <div class="col">
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               class="form-control form-control-modern" 
                               placeholder="Search for a file...">
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-outline-secondary">
                        <i class="bi bi-search me-1"></i>Search
                    </button>
                </div>
                @if(request('search'))
                    <div class="col-auto">
                        <a href="{{ route('files.index') }}" class="btn btn-outline-danger">
                            <i class="bi bi-x-lg me-1"></i>Clear
                        </a>
                    </div>
                @endif
            </div>
        </form>

        <!-- Files Table -->
        @if($files->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-modern align-middle">
                    <thead class="table-light">
                        <tr>
                            <th><i class="bi bi-file-earmark me-2"></i>File Name</th>
                            <th><i class="bi bi-hdd me-2"></i>Size</th>
                            <th><i class="bi bi-calendar-event me-2"></i>Date & Time</th>
                            <th><i class="bi bi-link-45deg me-2"></i>Download Link</th>
                            <th class="text-center"><i class="bi bi-gear me-2"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($files as $file)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded p-2 me-3">
                                            <i class="bi bi-file-earmark-fill text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $file->original_name }}</div>
                                            <small class="text-muted">{{ $file->mime_type }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-modern bg-light text-dark">
                                        {{ $file->formatted_size }}
                                    </span>
                                </td>
                                <td>
                                    <div class="small">
                                        <div class="fw-semibold">{{ $file->created_at->format('M d, Y') }}</div>
                                        <div class="text-muted">{{ $file->created_at->format('h:i A') }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">
                                            {{ $file->created_at->format('l') }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-info preview-file-btn" 
                                                data-file-name="{{ $file->original_name }}"
                                                data-file-type="{{ $file->mime_type }}"
                                                data-file-url="{{ route('files.view', $file->download_token) }}"
                                                data-download-url="{{ route('files.download', $file->download_token) }}"
                                                title="Preview file">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <a href="{{ route('files.download', $file->download_token) }}" 
                                           target="_blank"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Download file">
                                            <i class="bi bi-download"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-secondary copy-link-btn" 
                                                data-link="{{ route('files.download', $file->download_token) }}"
                                                title="Copy download link">
                                            <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger delete-file-btn"
                                            data-file-id="{{ $file->id }}"
                                            data-file-name="{{ $file->original_name }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $files->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-inbox" style="font-size: 4rem; color: #cbd5e1;"></i>
                </div>
                <h5 class="text-muted">
                    @if(request('search'))
                        No files found matching your search
                    @else
                        No files uploaded yet
                    @endif
                </h5>
                <p class="text-muted small mb-3">
                    @if(request('search'))
                        Try a different search term
                    @else
                        Start by uploading your first file
                    @endif
                </p>
                @if(!request('search'))
                    <a href="{{ route('files.create') }}" class="btn btn-primary-modern text-white">
                        <i class="bi bi-cloud-upload me-2"></i>Upload File
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- File Preview Modal -->
<div class="modal fade" id="filePreviewModal" tabindex="-1" aria-labelledby="filePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filePreviewModalLabel">
                    <i class="bi bi-eye me-2"></i>File Preview
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" id="filePreviewContent" style="min-height: 400px;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="modal-footer">
                <span id="filePreviewName" class="me-auto text-muted small"></span>
                <a href="#" id="fileDownloadBtn" class="btn btn-primary" download>
                    <i class="bi bi-download me-2"></i>Download File
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
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

// Delete file with confirmation
document.addEventListener('DOMContentLoaded', function() {
    // File Preview functionality
    const previewButtons = document.querySelectorAll('.preview-file-btn');
    const previewModal = new bootstrap.Modal(document.getElementById('filePreviewModal'));
    const previewContent = document.getElementById('filePreviewContent');
    const previewName = document.getElementById('filePreviewName');
    const downloadBtn = document.getElementById('fileDownloadBtn');
    
    previewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const fileName = this.getAttribute('data-file-name');
            const fileType = this.getAttribute('data-file-type');
            const fileUrl = this.getAttribute('data-file-url');
            const downloadUrl = this.getAttribute('data-download-url');
            
            // Set file name and download link
            previewName.textContent = fileName;
            downloadBtn.href = downloadUrl; // Use download URL for download button
            downloadBtn.download = fileName;
            
            // Show loading
            previewContent.innerHTML = `
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            `;
            
            // Show modal
            previewModal.show();
            
            // Generate preview based on file type
            setTimeout(() => {
                generatePreview(fileUrl, fileType, fileName);
            }, 100);
        });
    });
    
    function generatePreview(url, mimeType, fileName) {
        let content = '';
        
        // Images
        if (mimeType && mimeType.startsWith('image/')) {
            content = `
                <div class="d-flex justify-content-center align-items-center" style="min-height: 400px;">
                    <img src="${url}" class="img-fluid" style="max-height: 70vh;" alt="${fileName}">
                </div>
            `;
        }
        // PDFs
        else if (mimeType === 'application/pdf') {
            content = `
                <iframe src="${url}" width="100%" height="600px" frameborder="0"></iframe>
            `;
        }
        // Videos
        else if (mimeType && mimeType.startsWith('video/')) {
            content = `
                <video controls class="w-100" style="max-height: 70vh;">
                    <source src="${url}" type="${mimeType}">
                    Your browser does not support the video tag.
                </video>
            `;
        }
        // Audio
        else if (mimeType && mimeType.startsWith('audio/')) {
            content = `
                <div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 400px;">
                    <i class="bi bi-music-note-beamed" style="font-size: 5rem; color: var(--primary-color); margin-bottom: 2rem;"></i>
                    <audio controls class="w-75">
                        <source src="${url}" type="${mimeType}">
                        Your browser does not support the audio tag.
                    </audio>
                    <p class="text-muted mt-3">${fileName}</p>
                </div>
            `;
        }
        // Text files
        else if (mimeType && (mimeType.startsWith('text/') || mimeType === 'application/json' || mimeType === 'application/xml')) {
            fetch(url)
                .then(response => response.text())
                .then(text => {
                    previewContent.innerHTML = `
                        <div class="text-start">
                            <pre class="bg-light p-3 rounded" style="max-height: 600px; overflow-y: auto;"><code>${escapeHtml(text)}</code></pre>
                        </div>
                    `;
                })
                .catch(error => {
                    previewContent.innerHTML = getUnsupportedPreview(fileName, mimeType);
                });
            return;
        }
        // Microsoft Office files
        else if (mimeType && (
            mimeType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
            mimeType === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ||
            mimeType === 'application/vnd.openxmlformats-officedocument.presentationml.presentation' ||
            mimeType === 'application/msword' ||
            mimeType === 'application/vnd.ms-excel' ||
            mimeType === 'application/vnd.ms-powerpoint'
        )) {
            content = `
                <div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 400px;">
                    <i class="bi bi-file-earmark-word" style="font-size: 5rem; color: #2b579a; margin-bottom: 2rem;"></i>
                    <h5>Microsoft Office Document</h5>
                    <p class="text-muted">${fileName}</p>
                    <p class="small text-muted">Preview not available for Office files. Please download to view.</p>
                    <a href="${url}" class="btn btn-primary mt-3" download="${fileName}">
                        <i class="bi bi-download me-2"></i>Download to View
                    </a>
                </div>
            `;
        }
        // Unsupported types
        else {
            content = getUnsupportedPreview(fileName, mimeType);
        }
        
        previewContent.innerHTML = content;
    }
    
    function getUnsupportedPreview(fileName, mimeType) {
        let icon = 'bi-file-earmark';
        let iconColor = '#6c757d';
        
        if (mimeType) {
            if (mimeType.includes('zip') || mimeType.includes('rar') || mimeType.includes('compressed')) {
                icon = 'bi-file-earmark-zip';
                iconColor = '#ffc107';
            } else if (mimeType.includes('word')) {
                icon = 'bi-file-earmark-word';
                iconColor = '#2b579a';
            } else if (mimeType.includes('excel') || mimeType.includes('spreadsheet')) {
                icon = 'bi-file-earmark-excel';
                iconColor = '#217346';
            } else if (mimeType.includes('powerpoint') || mimeType.includes('presentation')) {
                icon = 'bi-file-earmark-ppt';
                iconColor = '#d24726';
            }
        }
        
        return `
            <div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 400px;">
                <i class="bi ${icon}" style="font-size: 5rem; color: ${iconColor}; margin-bottom: 2rem;"></i>
                <h5>Preview Not Available</h5>
                <p class="text-muted">${fileName}</p>
                <p class="small text-muted">File type: ${mimeType || 'Unknown'}</p>
                <p class="small text-muted">This file type cannot be previewed. Please download it to view.</p>
            </div>
        `;
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Copy link functionality
    const copyButtons = document.querySelectorAll('.copy-link-btn');
    copyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const link = this.getAttribute('data-link');
            
            // Try modern clipboard API first
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(link).then(function() {
                    Toast.fire({
                        icon: 'success',
                        title: 'Link copied to clipboard!'
                    });
                }).catch(function(err) {
                    // Fallback to textarea method
                    fallbackCopyToClipboard(link);
                });
            } else {
                // Fallback for older browsers
                fallbackCopyToClipboard(link);
            }
        });
    });
    
    // Fallback copy method
    function fallbackCopyToClipboard(text) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.select();
        
        try {
            const successful = document.execCommand('copy');
            if (successful) {
                Toast.fire({
                    icon: 'success',
                    title: 'Link copied to clipboard!'
                });
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Failed to copy link'
                });
            }
        } catch (err) {
            Toast.fire({
                icon: 'error',
                title: 'Failed to copy link'
            });
            console.error('Fallback: Oops, unable to copy', err);
        }
        
        document.body.removeChild(textarea);
    }
    
    // Delete file buttons
    const deleteButtons = document.querySelectorAll('.delete-file-btn');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const fileId = this.getAttribute('data-file-id');
            const fileName = this.getAttribute('data-file-name');
            
            Swal.fire({
                title: 'Delete File?',
                html: `Are you sure you want to delete <strong>${fileName}</strong>?<br>This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-trash me-2"></i>Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create and submit form
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/files/${fileId}`;
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    
                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    
                    // Show loading
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection

