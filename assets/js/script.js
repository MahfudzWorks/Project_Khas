document.addEventListener('DOMContentLoaded', () => {
    // 1. Mobile Menu Toggle
    const mobileBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileBtn && mobileMenu) {
        mobileBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // 2. Toast Notification System
    const showToast = (message, type = 'success') => {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const toast = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-emerald-600' : 'bg-red-600';
        
        toast.className = `${bgColor} text-white px-4 py-3 rounded-lg shadow-lg flex items-center justify-between min-w-[280px] toast-animate text-sm font-medium`;
        toast.innerHTML = `
            <span>${message}</span>
            <button onclick="this.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">&times;</button>
        `;

        container.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 4000);
    };

    // Auto trigger toast dari parameter URL ?msg=
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('msg')) {
        const msg = urlParams.get('msg');
        if (msg === 'added') showToast('✓ Data berhasil ditambahkan!');
        if (msg === 'updated') showToast('✓ Data berhasil diperbarui!');
        if (msg === 'deleted') showToast('✓ Data berhasil dihapus!');
    }

    // 3. Global Delete Confirmation Modal
    const deleteButtons = document.querySelectorAll('.btn-delete');
    const modal = document.getElementById('delete-modal');
    const modalForm = document.getElementById('delete-modal-form');
    const modalText = document.getElementById('delete-modal-text');
    const cancelBtn = document.getElementById('modal-cancel-btn');

    if (modal && modalForm) {
        deleteButtons.forEach(button => {
            button.addEventListener('click', () => {
                const url = button.getAttribute('data-delete-url');
                const title = button.getAttribute('data-delete-title') || 'data ini';
                
                modalForm.setAttribute('action', url);
                modalText.textContent = `Apakah Anda yakin ingin menghapus ${title}?`;
                modal.classList.remove('hidden');
            });
        });

        if (cancelBtn) {
            cancelBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        }

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    }

    // 4. Form Client-side Validation Helper
    const forms = document.querySelectorAll('.js-validate-form');
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            const requireds = form.querySelectorAll('[required]');
            let isValid = true;

            requireds.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('border-red-500');
                } else {
                    input.classList.remove('border-red-500');
                }
            });

            if (!isValid) {
                e.preventDefault();
                showToast('Harap isi semua kolom yang wajib diisi!', 'error');
            }
        });
    });
});