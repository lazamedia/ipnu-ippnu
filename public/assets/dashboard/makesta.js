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