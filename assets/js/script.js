function confirmDelete(id, name) {
    const modal = document.getElementById('deleteModal');
    const deleteItemName = document.getElementById('deleteItemName');
    const deleteInputId = document.getElementById('deleteInputId');

    if (modal && deleteItemName && deleteInputId) {
        deleteItemName.textContent = name;
        deleteInputId.value = id;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
}

function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    if (!container) return;

    const toast = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-emerald-600' : 'bg-red-600';

    toast.className = `${bgColor} text-white px-4 py-3 rounded-lg shadow-lg text-sm flex items-center justify-between transition-all duration-300 transform translate-y-2 opacity-0 min-w-[250px]`;
    toast.innerHTML = `
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" class="ml-3 font-bold text-white hover:text-gray-200">&times;</button>
    `;

    container.appendChild(toast);

    setTimeout(() => {
        toast.classList.remove('translate-y-2', 'opacity-0');
    }, 10);

    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-2');
        setTimeout(() => toast.remove(), 300);
    }, 3500);
}

function validateForm(event) {
    const nama = document.getElementById('nama_item')?.value.trim();
    const kategori = document.getElementById('kategori')?.value.trim();
    const asal = document.getElementById('asal_daerah')?.value.trim();
    const btnSubmit = document.getElementById('btnSubmit');

    if (!nama || !kategori || !asal) {
        alert("Harap isi semua kolom wajib!");
        event.preventDefault();
        return false;
    }

    if (btnSubmit) {
        btnSubmit.disabled = true;
        btnSubmit.innerText = "Memproses...";
        btnSubmit.classList.add('opacity-75', 'cursor-not-allowed');
    }

    return true;
}

document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'success_add') {
        showToast('Data berhasil ditambahkan!');
    } else if (status === 'success_edit') {
        showToast('Data berhasil diperbarui!');
    } else if (status === 'success_delete') {
        showToast('Data berhasil dihapus!');
    } else if (status === 'error') {
        showToast('Terjadi kesalahan pada sistem.', 'error');
    }
});