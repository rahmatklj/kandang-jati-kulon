<!-- Modal Quick Add Category -->
<div id="quickCategoryModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all">
        <!-- Header Modal -->
        <div class="px-6 py-4 bg-slate-800 text-white flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-lg">
                    +
                </div>
                <div>
                    <h3 class="text-sm font-bold tracking-wide">Tambah Kategori Baru</h3>
                    <p class="text-[11px] text-slate-300">Modul: <span id="quickCategoryModuleLabel" class="font-bold text-emerald-400">...</span></p>
                </div>
            </div>
            <button type="button" onclick="closeQuickAddCategoryModal()" class="text-slate-400 hover:text-white p-1 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Body Form Modal -->
        <form id="quickCategoryForm" onsubmit="submitQuickAddCategoryForm(event)" class="p-6 space-y-4">
            <input type="hidden" id="quickCategoryModule" value="">
            <input type="hidden" id="quickCategorySelectId" value="">
            <input type="hidden" id="quickCategoryValueType" value="id">

            <div>
                <label for="quickCategoryName" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Nama Kategori Baru <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="quickCategoryName" required placeholder="Contoh: Kategori Baru..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-xs font-semibold text-slate-800 transition">
            </div>

            <div>
                <label for="quickCategoryDescription" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Deskripsi Singkat (Opsional)
                </label>
                <textarea id="quickCategoryDescription" rows="2" placeholder="Jelaskan ringkasan atau cakupan kategori ini..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-xs text-slate-700 transition"></textarea>
            </div>

            <div class="pt-2 flex items-center justify-end gap-2.5">
                <button type="button" onclick="closeQuickAddCategoryModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 border border-slate-200 rounded-xl bg-white hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="submit" id="quickCategorySubmitBtn" class="px-5 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-md transition flex items-center gap-1.5">
                    <span>Simpan Kategori</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let activeQuickCategoryConfig = {
        module: '',
        selectId: '',
        valueType: 'id'
    };

    const moduleLabels = {
        'layanan': 'SOP & Layanan',
        'berita': 'Berita & Artikel',
        'galeri': 'Galeri Foto',
        'video': 'Video Dokumentasi',
        'dokumen': 'Dokumen PDF',
        'apbd': 'Transparansi APBD',
        'kemitraan': 'Link Terkait & Kemitraan'
    };

    function openQuickAddCategoryModal(moduleName, selectId, valueType = 'id') {
        activeQuickCategoryConfig = { module: moduleName, selectId: selectId, valueType: valueType };
        
        document.getElementById('quickCategoryModule').value = moduleName;
        document.getElementById('quickCategorySelectId').value = selectId;
        document.getElementById('quickCategoryValueType').value = valueType;
        document.getElementById('quickCategoryModuleLabel').innerText = moduleLabels[moduleName] || moduleName;
        document.getElementById('quickCategoryName').value = '';
        document.getElementById('quickCategoryDescription').value = '';

        const modal = document.getElementById('quickCategoryModal');
        modal.classList.remove('hidden');
        setTimeout(() => document.getElementById('quickCategoryName').focus(), 100);
    }

    function closeQuickAddCategoryModal() {
        const modal = document.getElementById('quickCategoryModal');
        modal.classList.add('hidden');
    }

    async function submitQuickAddCategoryForm(event) {
        event.preventDefault();
        const submitBtn = document.getElementById('quickCategorySubmitBtn');
        const originalText = submitBtn.innerHTML;

        const moduleName = document.getElementById('quickCategoryModule').value;
        const selectId = document.getElementById('quickCategorySelectId').value;
        const valueType = document.getElementById('quickCategoryValueType').value;
        const name = document.getElementById('quickCategoryName').value.trim();
        const description = document.getElementById('quickCategoryDescription').value.trim();

        if (!name) return;

        submitBtn.disabled = true;
        submitBtn.innerHTML = `<span>Menyimpan...</span>`;

        try {
            const response = await fetch("{{ route('dashboard.categories.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    name: name,
                    module: moduleName,
                    description: description
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                const category = data.category;
                let optionValue = category.id;
                if (valueType === 'slug') {
                    optionValue = category.slug;
                } else if (valueType === 'name') {
                    optionValue = category.name;
                } else if (valueType === 'kategori_layanan_id' || moduleName === 'layanan') {
                    optionValue = category.kategori_layanan_id || category.id;
                }

                // Update target select element
                const selectEl = document.getElementById(selectId);
                if (selectEl) {
                    const newOption = new Option(category.name, optionValue, true, true);
                    selectEl.add(newOption);
                    selectEl.value = optionValue;
                    selectEl.dispatchEvent(new Event('change', { bubbles: true }));
                }

                closeQuickAddCategoryModal();

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message || `Kategori '${category.name}' berhasil ditambahkan.`,
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else if (typeof window.showToastNotification === 'function') {
                    window.showToastNotification({
                        title: 'BERHASIL!',
                        message: data.message || `Kategori '${category.name}' berhasil ditambahkan.`,
                        type: 'success'
                    });
                } else {
                    alert(data.message || `Kategori '${category.name}' berhasil ditambahkan.`);
                }
            } else {
                if (typeof window.showToastNotification === 'function') {
                    window.showToastNotification({
                        title: 'PERHATIAN',
                        message: data.message || 'Gagal menambahkan kategori baru.',
                        type: 'error'
                    });
                } else {
                    alert(data.message || 'Gagal menambahkan kategori baru.');
                }
            }
        } catch (err) {
            console.error(err);
            alert('Terjadi kesalahan jaringan saat menambahkan kategori.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    }

    async function quickDeleteSelectedCategory(moduleName, selectId, valueType = 'id') {
        const selectEl = document.getElementById(selectId);
        if (!selectEl) return;

        const selectedValue = selectEl.value;
        const selectedIndex = selectEl.selectedIndex;
        const selectedText = selectedIndex >= 0 ? selectEl.options[selectedIndex].text : '';

        if (!selectedValue || selectedValue === '') {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Kategori',
                    text: 'Silakan pilih kategori pada dropdown terlebih dahulu sebelum menghapus.',
                });
            } else if (typeof window.showToastNotification === 'function') {
                window.showToastNotification({
                    title: 'PILIH KATEGORI',
                    message: 'Silakan pilih kategori pada dropdown terlebih dahulu sebelum menghapus.',
                    type: 'info'
                });
            } else {
                alert('Silakan pilih kategori pada dropdown terlebih dahulu sebelum menghapus.');
            }
            return;
        }

        const confirmText = `Apakah Anda yakin ingin menghapus kategori '${selectedText}'? Data yang menggunakan kategori ini akan dikosongkan.`;

        if (typeof Swal !== 'undefined') {
            const result = await Swal.fire({
                title: 'Hapus Kategori?',
                text: confirmText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            });
            if (!result.isConfirmed) return;
        } else {
            if (!confirm(confirmText)) return;
        }

        try {
            const response = await fetch("{{ route('dashboard.categories.quick-destroy') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    module: moduleName,
                    value: selectedValue,
                    value_type: valueType
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                if (selectedIndex >= 0) {
                    selectEl.remove(selectedIndex);
                }
                selectEl.value = '';
                selectEl.dispatchEvent(new Event('change', { bubbles: true }));

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: data.message || `Kategori '${selectedText}' berhasil dihapus.`,
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else if (typeof window.showToastNotification === 'function') {
                    window.showToastNotification({
                        title: 'BERHASIL DIHAPUS',
                        message: data.message || `Kategori '${selectedText}' berhasil dihapus.`,
                        type: 'success'
                    });
                } else {
                    alert(data.message || `Kategori '${selectedText}' berhasil dihapus.`);
                }
            } else {
                if (typeof window.showToastNotification === 'function') {
                    window.showToastNotification({
                        title: 'GAGAL MENGHAPUS',
                        message: data.message || 'Gagal menghapus kategori.',
                        type: 'error'
                    });
                } else {
                    alert(data.message || 'Gagal menghapus kategori.');
                }
            }
        } catch (err) {
            console.error(err);
            alert('Terjadi kesalahan jaringan saat menghapus kategori.');
        }
    }
</script>
