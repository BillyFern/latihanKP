// Enhanced JavaScript untuk Halaman Registrasi Pasien

// Global variables
let currentPage = 1;
let isLoading = false;

// Utility functions
const Utils = {
    // Show toast notification
    showToast: function(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast-notification toast-${type}`;
        toast.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i>
            <span>${message}</span>
            <button class="toast-close">&times;</button>
        `;
        
        // Add toast styles if not exists
        if (!document.getElementById('toast-styles')) {
            const styles = document.createElement('style');
            styles.id = 'toast-styles';
            styles.textContent = `
                .toast-notification {
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: white;
                    padding: 15px 20px;
                    border-radius: 10px;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    z-index: 10000;
                    animation: slideInRight 0.3s ease;
                    min-width: 300px;
                }
                
                .toast-success {
                    border-left: 4px solid #28a745;
                    color: #28a745;
                }
                
                .toast-error {
                    border-left: 4px solid #dc3545;
                    color: #dc3545;
                }
                
                .toast-warning {
                    border-left: 4px solid #ffc107;
                    color: #856404;
                }
                
                .toast-close {
                    background: none;
                    border: none;
                    font-size: 18px;
                    cursor: pointer;
                    opacity: 0.7;
                    margin-left: auto;
                }
                
                .toast-close:hover {
                    opacity: 1;
                }
                
                @keyframes slideInRight {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
                
                @keyframes slideOutRight {
                    from { transform: translateX(0); opacity: 1; }
                    to { transform: translateX(100%); opacity: 0; }
                }
            `;
            document.head.appendChild(styles);
        }
        
        document.body.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 5000);
        
        // Manual close
        toast.querySelector('.toast-close').onclick = () => {
            toast.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        };
    },

    // Show loading overlay
    showLoading: function() {
        if (!document.querySelector('.loading-overlay')) {
            const overlay = document.createElement('div');
            overlay.className = 'loading-overlay';
            overlay.innerHTML = `
                <div class="loading-content">
                    <div class="spinner"></div>
                    <p>Memuat data...</p>
                </div>
            `;
            document.body.appendChild(overlay);
            isLoading = true;
        }
    },

    // Hide loading overlay
    hideLoading: function() {
        const overlay = document.querySelector('.loading-overlay');
        if (overlay) {
            overlay.style.opacity = '0';
            setTimeout(() => {
                if (overlay.parentNode) {
                    overlay.parentNode.removeChild(overlay);
                }
            }, 300);
            isLoading = false;
        }
    },

    // Format date
    formatDate: function(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: '2-digit', 
            year: 'numeric'
        });
    },

    // Debounce function
    debounce: function(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
};

// Search Enhancement
const SearchManager = {
    init: function() {
        const searchInput = document.querySelector('input[name="q"]');
        if (!searchInput) return;

        // Add search suggestions dropdown
        this.createSuggestionDropdown();
        
        // Enhanced search with debounce
        searchInput.addEventListener('input', this.debounceSearch);
        searchInput.addEventListener('focus', this.showSuggestions);
        searchInput.addEventListener('blur', this.hideSuggestions);
    },

    debounceSearch: Utils.debounce(function(e) {
        SearchManager.performSearch(e.target.value);
    }, 300),

    createSuggestionDropdown: function() {
        const searchContainer = document.querySelector('.search-container');
        const dropdown = document.createElement('div');
        dropdown.className = 'search-suggestions';
        dropdown.innerHTML = '<div class="suggestions-content"></div>';
        searchContainer.appendChild(dropdown);
    },

    performSearch: function(query) {
        if (query.length < 2) return;
        
        // Show loading in search
        this.showSearchLoading();
        
        // Simulate API call or perform actual search
        setTimeout(() => {
            this.hideSearchLoading();
            this.updateSuggestions(query);
        }, 500);
    },

    showSearchLoading: function() {
        const suggestionsContent = document.querySelector('.suggestions-content');
        if (suggestionsContent) {
            suggestionsContent.innerHTML = '<div class="search-loading">Mencari...</div>';
            document.querySelector('.search-suggestions').style.display = 'block';
        }
    },

    hideSearchLoading: function() {
        const suggestionsContent = document.querySelector('.suggestions-content');
        if (suggestionsContent) {
            suggestionsContent.innerHTML = '';
        }
    },

    updateSuggestions: function(query) {
        const suggestionsContent = document.querySelector('.suggestions-content');
        // This would normally come from server
        const suggestions = [
            'Airin - 87364523',
            'Contoh Nama 2 - 93874563',
            'Contoh Nama 3 - 23847569'
        ].filter(item => item.toLowerCase().includes(query.toLowerCase()));

        if (suggestions.length > 0) {
            suggestionsContent.innerHTML = suggestions.map(suggestion => 
                `<div class="suggestion-item" onclick="SearchManager.selectSuggestion('${suggestion.split(' - ')[0]}')">${suggestion}</div>`
            ).join('');
            document.querySelector('.search-suggestions').style.display = 'block';
        }
    },

    selectSuggestion: function(value) {
        document.querySelector('input[name="q"]').value = value;
        this.hideSuggestions();
    },

    showSuggestions: function() {
        const dropdown = document.querySelector('.search-suggestions');
        if (dropdown && dropdown.innerHTML.trim() !== '') {
            dropdown.style.display = 'block';
        }
    },

    hideSuggestions: function() {
        setTimeout(() => {
            const dropdown = document.querySelector('.search-suggestions');
            if (dropdown) {
                dropdown.style.display = 'none';
            }
        }, 200);
    }
};

// Modal Enhancement
const ModalManager = {
    init: function() {
        this.enhanceModals();
        this.setupModalEvents();
    },

    enhanceModals: function() {
        // Add animation classes to modals
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.classList.add('fade');
            
            // Add backdrop click enhancement
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    this.closeModal(modal);
                }
            });
        });
    },

    setupModalEvents: function() {
        // Enhanced form submission
        document.addEventListener('submit', (e) => {
            if (e.target.closest('.modal')) {
                e.preventDefault();
                this.handleFormSubmission(e.target);
            }
        });
    },

    handleFormSubmission: function(form) {
        Utils.showLoading();
        
        const formData = new FormData(form);
        const action = form.getAttribute('action') || window.location.href;
        
        fetch(action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            Utils.hideLoading();
            
            if (data.success) {
                Utils.showToast('Data berhasil disimpan!', 'success');
                this.closeModal(form.closest('.modal'));
                // Refresh page or update table
                setTimeout(() => window.location.reload(), 1000);
            } else {
                Utils.showToast(data.message || 'Terjadi kesalahan!', 'error');
            }
        })
        .catch(error => {
            Utils.hideLoading();
            Utils.showToast('Terjadi kesalahan koneksi!', 'error');
            console.error('Error:', error);
        });
    },

    closeModal: function(modal) {
        const modalInstance = bootstrap.Modal.getInstance(modal);
        if (modalInstance) {
            modalInstance.hide();
        }
    }
};

// Table Enhancement
const TableManager = {
    init: function() {
        this.enhanceTable();
        this.setupTableEvents();
    },

    enhanceTable: function() {
        const table = document.querySelector('.table-custom');
        if (!table) return;

        // Add table loading state
        this.addTableLoading();
        
        // Enhanced row interactions
        this.setupRowHover();
        
        // Add sort functionality to headers
        this.addSortFunctionality();
    },

    addTableLoading: function() {
        const tableContainer = document.querySelector('.table-container');
        const loadingDiv = document.createElement('div');
        loadingDiv.className = 'table-loading';
        loadingDiv.innerHTML = `
            <div class="text-center p-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Memuat data...</p>
            </div>
        `;
        loadingDiv.style.display = 'none';
        tableContainer.appendChild(loadingDiv);
    },

    setupRowHover: function() {
        const rows = document.querySelectorAll('.table-custom tbody tr');
        rows.forEach(row => {
            row.addEventListener('mouseenter', () => {
                row.style.transform = 'translateY(-2px) scale(1.005)';
                row.style.boxShadow = '0 6px 15px rgba(0,0,0,0.5)'; // Changed to black shadow
                row.style.position = 'relative';
                row.style.zIndex = '1';
            });
            
            row.addEventListener('mouseleave', () => {
                row.style.transform = 'translateY(0) scale(1)';
                row.style.boxShadow = 'none';
                row.style.position = 'static';
                row.style.zIndex = 'auto';
            });
        });
    },

    addSortFunctionality: function() {
        const headers = document.querySelectorAll('.table-custom thead th');
        headers.forEach((header, index) => {
            if (index < headers.length - 1) { // Exclude action column
                header.style.cursor = 'pointer';
                header.innerHTML += ' <i class="fas fa-sort sort-icon"></i>';
                
                header.addEventListener('click', () => {
                    this.sortTable(index);
                });
            }
        });
    },

    sortTable: function(columnIndex) {
        const table = document.querySelector('.table-custom');
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        // Simple sort implementation
        const isAscending = !table.dataset.sortAscending || table.dataset.sortAscending === 'false';
        table.dataset.sortAscending = isAscending;
        
        rows.sort((a, b) => {
            const aText = a.cells[columnIndex].textContent.trim();
            const bText = b.cells[columnIndex].textContent.trim();
            
            if (isAscending) {
                return aText.localeCompare(bText, 'id', { numeric: true });
            } else {
                return bText.localeCompare(aText, 'id', { numeric: true });
            }
        });
        
        // Clear and re-add rows
        tbody.innerHTML = '';
        rows.forEach(row => tbody.appendChild(row));
        
        // Update sort icons
        document.querySelectorAll('.sort-icon').forEach(icon => {
            icon.className = 'fas fa-sort';
        });
        
        const currentIcon = document.querySelectorAll('.sort-icon')[columnIndex];
        currentIcon.className = `fas fa-sort-${isAscending ? 'up' : 'down'}`;
    },

    showLoading: function() {
        const loading = document.querySelector('.table-loading');
        const table = document.querySelector('.table-custom');
        if (loading && table) {
            table.style.display = 'none';
            loading.style.display = 'block';
        }
    },

    hideLoading: function() {
        const loading = document.querySelector('.table-loading');
        const table = document.querySelector('.table-custom');
        if (loading && table) {
            loading.style.display = 'none';
            table.style.display = 'table';
        }
    }
};

// Action Buttons Enhancement
const ActionManager = {
    init: function() {
        this.setupActionButtons();
    },

    setupActionButtons: function() {
        // Enhanced delete confirmation
        document.addEventListener('click', (e) => {
            if (e.target.closest('.delete-btn')) {
                e.preventDefault();
                this.showDeleteConfirmation(e.target.closest('.delete-btn'));
            }
        });

        // Enhanced edit action
        document.addEventListener('click', (e) => {
            if (e.target.closest('.edit-btn')) {
                this.handleEditAction(e.target.closest('.edit-btn'));
            }
        });
    },

    showDeleteConfirmation: function(button) {
        const id = button.dataset.id;
        const modal = document.querySelector('#ModalDelete');
        
        // Enhanced modal content
        const modalBody = modal.querySelector('.modal-body') || modal.querySelector('div');
        modalBody.innerHTML = `
            <div class="text-center p-4">
                <div class="warning-icon mb-3">
                    <i class="fas fa-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
                </div>
                <h5 class="mb-3">Konfirmasi Penghapusan</h5>
                <p class="text-muted mb-4">
                    Apakah Anda yakin ingin menghapus data ini?<br>
                    <strong>Tindakan ini tidak dapat dibatalkan!</strong>
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="button" class="btn btn-danger px-4" onclick="ActionManager.confirmDelete(${id})">
                        <i class="fas fa-trash me-2"></i>Ya, Hapus
                    </button>
                </div>
            </div>
        `;
        
        // Show modal
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();
    },

    confirmDelete: function(id) {
        Utils.showLoading();
        
        // Simulate delete API call
        fetch(`index.php?r=data-form/delete&id_registrasi=${id}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            Utils.hideLoading();
            
            if (data.success) {
                Utils.showToast('Data berhasil dihapus!', 'success');
                // Remove row with animation
                const row = document.querySelector(`[data-id="${id}"]`).closest('tr');
                row.style.animation = 'fadeOut 0.3s ease';
                setTimeout(() => {
                    if (row.parentNode) {
                        row.parentNode.removeChild(row);
                    }
                }, 300);
            } else {
                Utils.showToast(data.message || 'Gagal menghapus data!', 'error');
            }
        })
        .catch(error => {
            Utils.hideLoading();
            Utils.showToast('Terjadi kesalahan!', 'error');
            console.error('Error:', error);
        });
        
        // Close modal
        const modal = document.querySelector('#ModalDelete');
        const modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();
    },

    handleEditAction: function(button) {
        const id = button.dataset.id;
        Utils.showLoading();
        
        // Add visual feedback
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        
        setTimeout(() => {
            button.disabled = false;
            button.innerHTML = '<i class="fas fa-edit"></i>';
            Utils.hideLoading();
        }, 1000);
    }
};

// Form Enhancement
const FormManager = {
    init: function() {
        this.setupFormValidation();
        this.setupFormCalculations();
    },

    setupFormValidation: function() {
        // Real-time validation
        document.addEventListener('input', (e) => {
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
                this.validateField(e.target);
            }
        });
    },

    validateField: function(field) {
        const isValid = field.checkValidity();
        const feedback = field.parentNode.querySelector('.invalid-feedback') || 
                         this.createFeedbackElement(field.parentNode);
        
        if (isValid) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
            feedback.style.display = 'none';
        } else {
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');
            feedback.textContent = field.validationMessage;
            feedback.style.display = 'block';
        }
    },

    createFeedbackElement: function(parent) {
        const feedback = document.createElement('div');
        feedback.className = 'invalid-feedback';
        parent.appendChild(feedback);
        return feedback;
    },

    setupFormCalculations: function() {
        // This would integrate with the existing IMT calculation
        document.addEventListener('input', (e) => {
            if (e.target.name && e.target.name.includes('berat_badan')) {
                this.updateIMT(e.target.closest('form'));
            }
        });
    },

    updateIMT: function(form) {
        const berat = parseFloat(form.querySelector('[name*="berat_badan"]')?.value);
        const tinggi = parseFloat(form.querySelector('[name*="tinggi_badan"]')?.value);
        const imtField = form.querySelector('[name*="imt"]');
        
        if (berat && tinggi && imtField) {
            const tinggiM = tinggi / 100;
            const imt = (berat / (tinggiM * tinggiM)).toFixed(2);
            imtField.value = imt;
            
            // Add visual feedback for IMT status
            this.showIMTStatus(imtField, parseFloat(imt));
        }
    },

    showIMTStatus: function(field, imt) {
        let status = '';
        let color = '';
        
        if (imt < 18.5) {
            status = 'Underweight';
            color = 'text-info';
        } else if (imt < 25) {
            status = 'Normal';
            color = 'text-success';
        } else if (imt < 30) {
            status = 'Overweight';
            color = 'text-warning';
        } else {
            status = 'Obese';
            color = 'text-danger';
        }
        
        let statusElement = field.parentNode.querySelector('.imt-status');
        if (!statusElement) {
            statusElement = document.createElement('small');
            statusElement.className = 'imt-status';
            field.parentNode.appendChild(statusElement);
        }
        
        statusElement.className = `imt-status ${color}`;
        statusElement.textContent = `Status: ${status}`;
    }
};

// Initialize all managers
document.addEventListener('DOMContentLoaded', function() {
    SearchManager.init();
    ModalManager.init();
    TableManager.init();
    ActionManager.init();
    FormManager.init();
    
    // Add custom animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeOut {
            from { opacity: 1; transform: scale(1); }
            to { opacity: 0; transform: scale(0.95); }
        }
        
        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            z-index: 1000;
            display: none;
        }
        
        .suggestion-item {
            padding: 10px 15px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .suggestion-item:hover {
            background: #f8f9fa;
        }
        
        .suggestion-item:last-child {
            border-bottom: none;
        }
        
        .search-loading {
            padding: 10px 15px;
            text-align: center;
            color: #666;
        }
        
        .loading-content {
            text-align: center;
            color: #666;
        }
        
        .loading-content p {
            margin-top: 15px;
            font-size: 16px;
        }
        
        .warning-icon {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        /* New styles for row hover effect */
        .table-custom tbody tr {
            transition: transform 0.2s ease, box-shadow 0.2s ease, z-index 0.2s ease;
            position: relative;
        }
        
        .table-custom tbody tr:hover {
            transform: translateY(-2px) scale(1.005);
            box-shadow: 0 6px 15px rgba(0,0,0,0.5); /* Warna bayangan diubah menjadi hitam */
            z-index: 1;
        }
    `;
    document.head.appendChild(style);
    
    // Show welcome message
    setTimeout(() => {
        Utils.showToast('Selamat datang di Sistem Registrasi Pasien!', 'success');
    }, 1000);
});