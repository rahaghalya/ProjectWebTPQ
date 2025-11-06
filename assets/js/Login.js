// Menghubungkan elemen HTML ke JavaScript
const loginForm = document.getElementById('loginForm');
const alertModal = document.getElementById('alertModal');
const modalOverlay = document.getElementById('modalOverlay'); // Kita butuh ini
const alertOkButton = document.getElementById('alertOkButton');
const logMessage = document.getElementById('logMessage');

// Fungsi untuk menampilkan modal
function showModal(message) {
    logMessage.textContent = message; // Atur pesan modal
    alertModal.classList.remove('hidden');
    modalOverlay.classList.remove('hidden');
}

// Fungsi untuk menyembunyikan modal
function hideModal() {
    alertModal.classList.add('hidden');
    modalOverlay.classList.add('hidden');
}

// Event listener untuk form submit
loginForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Mencegah form terkirim (reload)

    // Ambil semua data form
    const formData = new FormData(loginForm);

    // Kirim data ke login.php menggunakan fetch (AJAX)
    fetch('login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) // Ubah balasan dari PHP menjadi objek JSON
    .then(data => {
        // 'data' adalah objek JSON dari PHP (misal: {status: '...', message: '...'})

        if (data.status === 'success') {
            // Tampilkan pesan sukses di modal
            logMessage.textContent = data.message;
            alertModal.classList.remove('hidden');
            modalOverlay.classList.remove('hidden');

            // Beri jeda 1 detik, lalu redirect ke dashboard
            setTimeout(() => {
                window.location.href = data.redirect; // Pindah halaman
            }, 1000);

        } else {
            // Jika status 'error', tampilkan pesan error di modal
            showModal(data.message);
        }
    })
    .catch(error => {
        // Tangani jika ada error jaringan atau PHP error
        console.error('Error:', error);
        showModal('Terjadi kesalahan koneksi. Silakan coba lagi.');
    });
});

// Event listener untuk tombol OK
alertOkButton.addEventListener('click', hideModal);

// Event listener untuk overlay (klik di luar modal akan menutupnya)
modalOverlay.addEventListener('click', hideModal);