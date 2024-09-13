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

 // File Upload Script
 const fileDropArea = document.getElementById('file-drop-area');
     const fileInputDokumen = document.getElementById('file_dokumen');
     const uploadedFile = document.getElementById('uploaded-file');
     const fileNameSpan = document.getElementById('file-name');
     const removeFileButton = document.getElementById('remove-file');
     const maxSize = 5 * 1024 * 1024;
     
     fileDropArea.addEventListener('dragover', (e) => {
         e.preventDefault();
         fileDropArea.classList.add('dragover');
     });

     fileDropArea.addEventListener('dragleave', () => fileDropArea.classList.remove('dragover'));

     fileDropArea.addEventListener('drop', (e) => {
         e.preventDefault();
         fileDropArea.classList.remove('dragover');
         const file = e.dataTransfer.files[0];
         
         if (validateFile(file)) {
             fileInputDokumen.files = e.dataTransfer.files;
             fileNameSpan.textContent = file.name;
             fileDropArea.style.display = 'none';
             uploadedFile.style.display = 'flex';
         }
     });

     fileDropArea.addEventListener('click', () => fileInputDokumen.click());

     fileInputDokumen.addEventListener('change', () => {
         const file = fileInputDokumen.files[0];
         if (validateFile(file)) {
             fileNameSpan.textContent = file.name;
             fileDropArea.style.display = 'none';
             uploadedFile.style.display = 'flex';
         }
     });

     removeFileButton.addEventListener('click', () => {
         fileInputDokumen.value = '';
         fileDropArea.style.display = 'block';
         uploadedFile.style.display = 'none';
     });

     function validateFile(file) {
         const allowedExtensions = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
             'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
             'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'];

         if (file.size > maxSize) {
             Swal.fire({
                 icon: 'error',
                 title: 'Ukuran File Terlalu Besar',
                 text: 'Ukuran file melebihi 5MB. Silakan unggah file yang lebih kecil.',
             });
             return false;
         }

         if (!allowedExtensions.includes(file.type)) {
             Swal.fire({
                 icon: 'error',
                 title: 'Format File Tidak Valid',
                 text: 'Harap unggah file dengan format Word, Excel, PDF, atau PowerPoint.',
             });
             return false;
         }

         return true;
     }






    //  HALAMAN EVENT
    
    document.getElementById('shareWhatsapp').addEventListener('click', function() {
        // Ambil nilai dari form
        const ketuaPelaksana = document.getElementById('ketua_pelaksana').value;
        const wakil = document.getElementById('wakil').value;
        const sekretaris = document.getElementById('sekretaris').value;
        const bendahara = document.getElementById('bendahara').value;
        const tempat = document.getElementById('tempat').value;
        const anggaran = document.querySelector('input[name="anggaran"]').value;
        const tanggal = document.querySelector('input[name="tanggal"]').value;
    
        // Ambil nilai dari input list
        const tamuUndangan = [...document.querySelectorAll('#listTamuUndangan div span')].map(el => el.textContent).join(', ');
        const divisiHumas = [...document.querySelectorAll('#listDivisiHumas div span')].map(el => el.textContent).join(', ');
        const divisiPerkap = [...document.querySelectorAll('#listDivisiPerkap div span')].map(el => el.textContent).join(', ');
        const divisiDekdok = [...document.querySelectorAll('#listDivisiDekdok div span')].map(el => el.textContent).join(', ');
        const divisiKonsumsi = [...document.querySelectorAll('#listDivisiKonsumsi div span')].map(el => el.textContent).join(', ');
        const divisiAcara = [...document.querySelectorAll('#listDivisiAcara div span')].map(el => el.textContent).join(', ');
    
        // Ambil nilai dari "Keperluan Divisi"
        const keperluanDivisiWrapper = document.getElementById('hasilInput').querySelectorAll('div h5');
        let keperluanDivisi = '';
    
        keperluanDivisiWrapper.forEach((divisiItem, index) => {
            const divisiTitle = divisiItem.textContent;
            const keperluanList = divisiItem.nextElementSibling.querySelectorAll('li');
            const keperluanText = [...keperluanList].map(keperluan => keperluan.textContent).join(', ');
    
            keperluanDivisi += `${divisiTitle}: ${keperluanText}\n`;
        });
    
        // Format pesan WhatsApp dengan teks yang rapi
        const message = `
            *Data Event:*\n
            *Ketua Pelaksana:* ${ketuaPelaksana}\n
            *Wakil:* ${wakil}\n
            *Sekretaris:* ${sekretaris}\n
            *Bendahara:* ${bendahara}\n
            *Tempat:* ${tempat}\n
            *Anggaran:* Rp${anggaran}\n
            *Tanggal:* ${tanggal}\n\n
            *Tamu Undangan:* ${tamuUndangan}\n\n
            *Divisi Humas:* ${divisiHumas}\n
            *Divisi Perkap:* ${divisiPerkap}\n
            *Divisi Dekdok:* ${divisiDekdok}\n
            *Divisi Konsumsi:* ${divisiKonsumsi}\n
            *Divisi Acara:* ${divisiAcara}\n\n
            *Keperluan Divisi:*\n
            ${keperluanDivisi}
        `;
    
        // Encode URI untuk WhatsApp (format yang rapi)
        const whatsappURL = `https://api.whatsapp.com/send?phone=6282134749670&text=${encodeURIComponent(message)}`;
    
        // Buka tautan WhatsApp dengan nomor yang diinginkan
        window.open(whatsappURL, '_blank');
    });
    
    
    
    
    document.addEventListener('DOMContentLoaded', () => {
        const divisiSelectors = [
            { selectId: 'divisiAcaraSelect', inputId: 'divisiAcaraManualInput', containerId: 'divisiAcaraContainer', hiddenInputId: 'divisiAcaraHidden' },
            { selectId: 'divisiHumasSelect', inputId: 'divisiHumasManualInput', containerId: 'divisiHumasContainer', hiddenInputId: 'divisiHumasHidden' },
            { selectId: 'divisiPerkapSelect', inputId: 'divisiPerkapManualInput', containerId: 'divisiPerkapContainer', hiddenInputId: 'divisiPerkapHidden' },
            { selectId: 'divisiDekdokSelect', inputId: 'divisiDekdokManualInput', containerId: 'divisiDekdokContainer', hiddenInputId: 'divisiDekdokHidden' },
            { selectId: 'divisiKonsumsiSelect', inputId: 'divisiKonsumsiManualInput', containerId: 'divisiKonsumsiContainer', hiddenInputId: 'divisiKonsumsiHidden' },
            { selectId: 'tamuUndanganSelect', inputId: 'tamuUndanganManualInput', containerId: 'tamuUndanganContainer', hiddenInputId: 'tamuUndanganHidden' },
        ];
    
        divisiSelectors.forEach(divisi => {
            setupTagInput(divisi.selectId, divisi.inputId, divisi.containerId, divisi.hiddenInputId);
        });
    
        function setupTagInput(selectId, inputId, containerId, hiddenInputId) {
            const select = document.getElementById(selectId);
            const manualInput = document.getElementById(inputId);
            const container = document.getElementById(containerId);
            const hiddenInput = document.getElementById(hiddenInputId);
    
            // Buat wrapper untuk input dan tombol tambah
            const wrapper = document.createElement('div');
            wrapper.classList.add('input-wrapper');
            manualInput.parentNode.insertBefore(wrapper, manualInput);
            wrapper.appendChild(manualInput);
    
            // Buat tombol tambah
            const addButton = document.createElement('button');
            addButton.textContent = 'Tambah';
            addButton.classList.add('add-button');
            wrapper.appendChild(addButton); // Tambahkan tombol di dalam wrapper
    
            let tags = hiddenInput.value ? hiddenInput.value.split(',') : [];
    
            // Update hidden input dari array tags setiap kali ada perubahan
            function updateHiddenInput() {
                hiddenInput.value = tags.join(','); // Update nilai hidden input dengan tag yang terpilih
            }
    
            // Fungsi untuk menambahkan tag
            function addTag(value) {
                const tag = document.createElement('div');
                tag.classList.add('tag');
    
                const nameSpan = document.createElement('span');
                nameSpan.textContent = value;
    
                const removeButton = document.createElement('button');
                removeButton.textContent = '×';
    
                removeButton.addEventListener('click', () => {
                    tag.remove(); // Hapus tag dari tampilan
                    tags = tags.filter(tagValue => tagValue !== value); // Hapus dari array tags
                    updateHiddenInput(); // Perbarui hidden input
                });
    
                tag.appendChild(nameSpan);
                tag.appendChild(removeButton);
                container.insertBefore(tag, select); // Tambahkan tag ke container
            }
    
            // Tambahkan nama dari input manual
            function handleManualInput() {
                const manualValues = manualInput.value.split(',').map(v => v.trim()).filter(v => v !== "");
    
                manualValues.forEach(value => {
                    if (!tags.includes(value)) {
                        tags.push(value); // Tambahkan setiap nilai unik ke tags
                        addTag(value); // Tampilkan tag
                    }
                });
    
                updateHiddenInput(); // Perbarui hidden input setelah semua nama manual ditambahkan
                manualInput.value = ''; // Kosongkan input manual
            }
    
            // Ketika tombol "Tambah" diklik di mode mobile, tambahkan nama dari input manual
            addButton.addEventListener('click', function (e) {
                e.preventDefault(); // Cegah tombol dari menyebabkan form submit
                handleManualInput();
            });
    
            // Jika input manual diisi dan Enter ditekan di desktop
            manualInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && manualInput.value.trim() !== "") {
                    handleManualInput();
                    e.preventDefault(); // Cegah halaman dari submit
                }
            });
    
            // Ketika dropdown berubah
            select.addEventListener('change', function () {
                const selectedValue = this.value;
    
                if (selectedValue === "manual") {
                    manualInput.style.display = 'block';
                    addButton.classList.add('active'); // Tampilkan tombol saat input manual dipilih
                    manualInput.focus();
                } else {
                    // Sembunyikan input manual dan tombol tambah jika item lain dipilih
                    manualInput.style.display = 'none';
                    addButton.classList.remove('active'); // Sembunyikan tombol tambah
                    addButton.style.display = 'none';
    
                    if (selectedValue !== "" && !tags.includes(selectedValue)) {
                        // Jika item belum ada di tags, tambahkan
                        tags.push(selectedValue);
                        addTag(selectedValue);
                        updateHiddenInput(); // Perbarui hidden input
                        select.value = ''; // Reset dropdown
                    }
                }
            });
    
            // Inisialisasi tag dari hidden input (jika sudah ada sebelumnya)
            tags.forEach(tag => addTag(tag));
        }
    });
    