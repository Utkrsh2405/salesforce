// Additional utility functions

// Debounce function for search inputs
function debounce(func, wait) {
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

// Enhanced search functionality
function enhancedSearch(inputSelector, targetSelector) {
    const searchInput = document.querySelector(inputSelector);
    if (!searchInput) return;
    
    const debouncedSearch = debounce((searchTerm) => {
        const targets = document.querySelectorAll(targetSelector);
        
        targets.forEach(target => {
            const text = target.textContent.toLowerCase();
            const show = text.includes(searchTerm.toLowerCase());
            target.style.display = show ? '' : 'none';
            
            // Add highlight effect
            if (show && searchTerm) {
                target.classList.add('search-highlight');
            } else {
                target.classList.remove('search-highlight');
            }
        });
    }, 300);
    
    searchInput.addEventListener('input', (e) => {
        debouncedSearch(e.target.value);
    });
}

// Modal enhancements
function enhanceModals() {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('show.bs.modal', function() {
            this.querySelector('input, textarea, select')?.focus();
        });
        
        modal.addEventListener('hidden.bs.modal', function() {
            // Reset form if exists
            const form = this.querySelector('form');
            if (form) {
                form.reset();
                form.classList.remove('was-validated');
            }
        });
    });
}

// Copy to clipboard function
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showAlert('Copied to clipboard!', 'success');
    }).catch(() => {
        showAlert('Failed to copy to clipboard', 'danger');
    });
}

// Export table data to CSV
function exportTableToCSV(tableSelector, filename = 'export.csv') {
    const table = document.querySelector(tableSelector);
    if (!table) return;
    
    const rows = table.querySelectorAll('tr');
    const csvContent = Array.from(rows).map(row => {
        const cells = row.querySelectorAll('th, td');
        return Array.from(cells).map(cell => {
            return '"' + cell.textContent.replace(/"/g, '""') + '"';
        }).join(',');
    }).join('\n');
    
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
    window.URL.revokeObjectURL(url);
}

// Initialize enhanced features
document.addEventListener('DOMContentLoaded', function() {
    enhanceModals();
    
    // Add click to copy functionality for elements with data-copy attribute
    document.querySelectorAll('[data-copy]').forEach(element => {
        element.addEventListener('click', function() {
            copyToClipboard(this.dataset.copy || this.textContent);
        });
    });
    
    // Add export functionality for tables with data-export attribute
    document.querySelectorAll('[data-export]').forEach(button => {
        button.addEventListener('click', function() {
            const tableSelector = this.dataset.export;
            const filename = this.dataset.filename || 'export.csv';
            exportTableToCSV(tableSelector, filename);
        });
    });
});
