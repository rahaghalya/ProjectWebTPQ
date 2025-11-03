// Menghubungkan elemen HTML ke JavaScript
const loginForm = document.getElementById('loginForm');
const alertModal = document.getElementById('alertModal');
const alertOkButton = document.getElementById('alertOkButton');
const logMessage = document.getElementById('logMessage');
const modalOverlay = document.getElementById('modalOverlay'); // Overlay ditambahkan

// Fungsi untuk menampilkan modal
function showModal() {
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

    // Mengambil nilai dari input
    const user = document.getElementById('user').value;
    const pass = document.getElementById('pass').value;

    // Logika validasi sederhana
    if (user === 'admin' && pass === '123') {
        logMessage.textContent = 'Login berhasil! Selamat datang, ' + user + '.';
    } else if (user === '' || pass === '') {
         logMessage.textContent = 'User dan Password tidak boleh kosong.';
    } else {
        logMessage.textContent = 'Login gagal. Periksa kembali User dan Password Anda.';
    }

    // Tampilkan modal
    showModal();
});

// Event listener untuk tombol OK
alertOkButton.addEventListener('click', hideModal);

// Event listener untuk overlay (klik di luar modal akan menutupnya)
modalOverlay.addEventListener('click', hideModal);