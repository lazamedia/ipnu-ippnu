document.addEventListener('DOMContentLoaded', () => {
    const divisiDropdown = document.getElementById('divisiKeperluanDropdown');
    const keperluanInput = document.getElementById('keperluanDivisiInput');
    const keperluanWrapper = document.getElementById('keperluanDivisiWrapper');
    const hasilInputDiv = document.getElementById('hasilInput'); // Box hasil input

    const keperluanDivisi = {};

    // Event saat divisi dipilih
    divisiDropdown.addEventListener('change', (e) => {
        const selectedDivisi = divisiDropdown.value;

        keperluanInput.style.display = 'block';
        keperluanInput.focus();

        updateKeperluanList(selectedDivisi);
    });

    keperluanInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' && keperluanInput.value.trim() !== "") {
            const selectedDivisi = divisiDropdown.value;
            const keperluan = keperluanInput.value.trim();

            if (!keperluanDivisi[selectedDivisi]) {
                keperluanDivisi[selectedDivisi] = [];
            }
            keperluanDivisi[selectedDivisi].push(keperluan);

            keperluanInput.value = '';
            updateKeperluanList(selectedDivisi);
            updateHasilInput(); // Update hasil input di box
            e.preventDefault();
        }
    });

    function updateKeperluanList(divisi) {
        keperluanWrapper.innerHTML = '';

        if (keperluanDivisi[divisi]) {
            keperluanDivisi[divisi].forEach((keperluan, index) => {
                const listItem = document.createElement('div');
                const nameSpan = document.createElement('span');
                nameSpan.textContent = keperluan;

                const removeButton = document.createElement('button');
                removeButton.textContent = '×';
                removeButton.addEventListener('click', () => {
                    keperluanDivisi[divisi].splice(index, 1);
                    updateKeperluanList(divisi);
                    updateHasilInput(); // Update hasil input di box setelah hapus
                });

                listItem.appendChild(nameSpan);
                listItem.appendChild(removeButton);
                listItem.classList.add('list-horizontal-item');
                keperluanWrapper.appendChild(listItem);
            });
        }
    }

    // Fungsi untuk menampilkan hasil input di dalam box
    function updateHasilInput() {
        hasilInputDiv.innerHTML = ''; // Kosongkan konten box

        Object.keys(keperluanDivisi).forEach(divisi => {
            if (keperluanDivisi[divisi].length > 0) {
                const divisiWrapper = document.createElement('div');

                const divisiHeading = document.createElement('h5');
                divisiHeading.textContent = `Divisi. ${divisi}`;

                const keperluanList = document.createElement('ul');
                keperluanDivisi[divisi].forEach(keperluan => {
                    const listItem = document.createElement('li');
                    listItem.textContent = keperluan;
                    keperluanList.appendChild(listItem);
                });

                divisiWrapper.appendChild(divisiHeading);
                divisiWrapper.appendChild(keperluanList);
                hasilInputDiv.appendChild(divisiWrapper);
            }
        });
    }
});








    
// script untuk input masal 
document.addEventListener('DOMContentLoaded', () => {
        // Fungsi untuk menambah nama ke daftar
        function addToList(inputId, listId) {
            const input = document.getElementById(inputId);
            const list = document.getElementById(listId);

            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && input.value.trim() !== "") {
                    createListItem(input.value, list);
                    input.value = ''; // Kosongkan input setelah menambah nama
                    e.preventDefault(); // Mencegah form submit saat Enter ditekan
                }
            });
        }

        // Fungsi untuk membuat item daftar dengan tombol hapus
        function createListItem(value, list) {
            const listItem = document.createElement('div');
            const nameSpan = document.createElement('span');
            nameSpan.textContent = value;

            const removeButton = document.createElement('button');
            removeButton.textContent = '×';
            removeButton.addEventListener('click', () => listItem.remove());

            listItem.appendChild(nameSpan);
            listItem.appendChild(removeButton);
            list.appendChild(listItem);
        }

        // Fungsi untuk dropdown divisi dengan input manual
        function handleDropdownWithManualInput(dropdownId, manualInputId, listId) {
            const dropdown = document.getElementById(dropdownId);
            const manualInput = document.getElementById(manualInputId);
            const list = document.getElementById(listId);

            dropdown.addEventListener('change', (e) => {
                if (dropdown.value === 'other') {
                    manualInput.style.display = 'block';
                    manualInput.focus();
                } else if (dropdown.value !== '') {
                    createListItem(dropdown.value, list);
                    dropdown.value = ''; // Reset dropdown setelah memilih
                }
            });

            manualInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && manualInput.value.trim() !== "") {
                    createListItem(manualInput.value, list);
                    manualInput.value = ''; // Kosongkan input setelah menambah nama
                    manualInput.style.display = 'none'; // Sembunyikan input manual setelah penggunaan
                    dropdown.value = ''; // Reset dropdown
                    e.preventDefault();
                }
            });
        }

        // Panggil fungsi untuk masing-masing input dan daftar
        addToList('tamuUndangan', 'listTamuUndangan');
        addToList('divisiHumas', 'listDivisiHumas');
        addToList('divisiAcara', 'listDivisiAcara');

        // Dropdown untuk divisi perlengkapan
        handleDropdownWithManualInput('divisiPerlengkapanDropdown', 'divisiPerlengkapanManual', 'listDivisiPerlengkapan');
    });

// Drag and Drop Script
const dragDropArea = document.getElementById('dragDropArea');
const fileInput = document.getElementById('fileInput');
const imagePreviewWrapper = document.getElementById('imagePreviewWrapper');
const imagePreview = document.getElementById('imagePreview');
const removeImageButton = document.getElementById('removeImage');
const createAnotherButton = document.getElementById('createAnother'); // Pastikan tombol diinisialisasi
const createForm = document.getElementById('createForm'); // Pastikan form diinisialisasi

// Handle Drag and Drop
dragDropArea.addEventListener('click', () => fileInput.click());

dragDropArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    dragDropArea.classList.add('dragover');
});

dragDropArea.addEventListener('dragleave', () => dragDropArea.classList.remove('dragover'));

dragDropArea.addEventListener('drop', (e) => {
    e.preventDefault();
    dragDropArea.classList.remove('dragover');
    const file = e.dataTransfer.files[0];
    if (file) {
        fileInput.files = e.dataTransfer.files;
        previewImage(file);
    }
});

fileInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
        previewImage(file);
    }
});

removeImageButton.addEventListener('click', function() {
    fileInput.value = ""; // Clear the input value
    imagePreview.src = ""; // Remove the image source
    imagePreviewWrapper.style.display = "none"; // Hide the image preview wrapper
    dragDropArea.style.display = "flex"; // Show drag-drop area again
});

function previewImage(file) {
    const reader = new FileReader();
    reader.onload = (e) => {
        imagePreview.src = e.target.result; // Set image source to uploaded file
        imagePreviewWrapper.style.display = "block"; // Show image preview wrapper
        dragDropArea.style.display = "none"; // Hide drag-drop area when image is loaded
    };
    reader.readAsDataURL(file);
}


const fileDropArea = document.getElementById('file-drop-area');
    const fileInput = document.getElementById('file_dokumen');
    const uploadedFile = document.getElementById('uploaded-file');
    const fileNameSpan = document.getElementById('file-name');
    const removeFileButton = document.getElementById('remove-file');
    const maxSize = 5 * 1024 * 1024; // 5MB in bytes
    const linkDrive = document.getElementById('link_drive');
    const eventForm = document.getElementById('eventForm');

    // Validasi link dengan regex URL sederhana
    function validateURL(url) {
        const pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
        '((([a-zA-Z0-9\\-]+\\.)+[a-zA-Z]{2,})|'+ // domain name and extension
        '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-zA-Z0-9@:%_\\+.~#?&//=]*)?$','i'); // port and path
        return !!pattern.test(url);
    }

    // Ketika file di-drag ke area
    fileDropArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        fileDropArea.classList.add('dragover');
    });

    // Ketika file keluar dari area drag
    fileDropArea.addEventListener('dragleave', () => {
        fileDropArea.classList.remove('dragover');
    });

    // Ketika file dijatuhkan ke dalam area drag
    fileDropArea.addEventListener('drop', (e) => {
        e.preventDefault();
        fileDropArea.classList.remove('dragover');

        const files = e.dataTransfer.files;
        const allowedExtensions = ['application/pdf', 'application/msword', 
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'];

        if (files.length > 0) {
            const file = files[0];
            
            // Validasi ukuran file
            if (file.size > maxSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran File Terlalu Besar',
                    text: 'Ukuran file melebihi 5MB. Silakan unggah file yang lebih kecil.',
                });
                return;
            }

            // Validasi tipe file
            if (!allowedExtensions.includes(file.type)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Format File Tidak Valid',
                    text: 'Harap unggah file dengan format Word, Excel, PDF, atau PowerPoint.',
                });
                return;
            }

            fileInput.files = files;
            fileNameSpan.textContent = file.name;
            fileDropArea.style.display = 'none';
            uploadedFile.style.display = 'flex';
        }
    });

    // Klik pada area drop untuk membuka file picker
    fileDropArea.addEventListener('click', () => {
        fileInput.click();
    });

    // Ketika file dipilih dari file picker
    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];

            // Validasi ukuran file
            if (file.size > maxSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran File Terlalu Besar',
                    text: 'Ukuran file melebihi 5MB. Silakan unggah file yang lebih kecil.',
                });
                fileInput.value = '';
                return;
            }

            fileNameSpan.textContent = file.name;
            fileDropArea.style.display = 'none';
            uploadedFile.style.display = 'flex';
        }
    });

    // Hapus file yang diunggah
    removeFileButton.addEventListener('click', () => {
        fileInput.value = '';
        fileDropArea.style.display = 'block';
        uploadedFile.style.display = 'none';
    });
