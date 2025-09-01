<?= $this->extend('auth/layout_personel') ?>
<?= $this->section('page_title') ?> Personel Giriş <?= $this->endSection() ?>
<?= $this->section('title') ?> Personel Giriş <?= $this->endSection() ?>
<?= $this->section('subtitle') ?>Sistemimizde kayıtlı PIN kodunuz ile giriş yapabilirsiniz.
<?= $this->endSection() ?>


<?= $this->section('content') ?>
<style>
/* Ana container için yeni stiller */
.nk-content {
    min-height: 100vh;
    padding: 20px;
}

.card {
    height: calc(100vh - 40px); /* Ekran yüksekliğinden padding'leri çıkar */
    max-height: 900px; /* Maksimum yükseklik */
    display: flex;
    flex-direction: column;
    overflow: hidden; /* Taşan içeriği gizle */
}

.card-inner {
    display: flex;
    flex-direction: column;
    height: 100%;
    overflow: hidden;
}

.nk-block-head {
    flex-shrink: 0; /* Başlık alanının boyutu sabit kalsın */
    padding-bottom: 20px;
}

.user-container {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    padding: 0;
}

.search-container {
    flex-shrink: 0;
    padding: 0 0 15px 0;
}

.user-list {
    flex: 1;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    overflow-y: auto;
    padding-right: 10px;
    margin-top: 30px;
    align-items: start;
    grid-auto-rows: min-content;
}

/* Scroll çubuğu stilleri */
.user-list::-webkit-scrollbar {
    width: 6px;
}

.user-list::-webkit-scrollbar-track {
    background: #f5f6fa;
    border-radius: 3px;
}

.user-list::-webkit-scrollbar-thumb {
    background: #6576ff;
    border-radius: 3px;
}

.user-list::-webkit-scrollbar-thumb:hover {
    background: #4b5fff;
}

/* Kullanıcı kartları için mevcut stiller */
.user-card {
    background: #fff;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.3s ease;
    border: 1px solid #eee;
    min-width: 0; /* Taşmaları önle */
    height: 82px; /* Sabit yükseklik ekleyelim */
    margin-bottom: 0; /* Alt margin'i kaldıralım */
}

.user-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-color: #6576ff;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.user-avatar {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: #f0f2ff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6576ff;
}

.user-avatar .icon {
    font-size: 24px;
}

.user-details {
    min-width: 0;
    flex: 1;
}

.user-name, .user-operation {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.user-name {
    font-size: 16px;
    font-weight: 600;
    color: #364a63;
}

.user-operation {
    font-size: 13px;
    color: #8094ae;
    background: #f5f6fa;
    padding: 3px 8px;
    border-radius: 4px;
    display: inline-block;
}

.login-btn {
    padding: 8px 20px;
    border-radius: 6px;
    background: #6576ff;
    color: white;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 6px;
}

.login-btn:hover {
    background: #4b5fff;
    transform: translateY(-1px);
}

.login-btn .icon {
    font-size: 16px;
}

/* Arama kutusu için stil */
.search-input {
    width: 100%;
    padding: 12px 20px;
    border: 1px solid #e5e9f2;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s;
}

.search-input:focus {
    outline: none;
    border-color: #6576ff;
    box-shadow: 0 0 0 3px rgba(101, 118, 255, 0.1);
}

/* Pin Modal Styles */
.pin-pad {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    max-width: 300px;
    margin: 20px auto;
}

.pin-display {
    text-align: center;
    margin: 20px 0;
    font-size: 24px;
    letter-spacing: 5px;
}

.pin-button {
    padding: 15px;
    font-size: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background: white;
    cursor: pointer;
    transition: all 0.3s ease;
}

.pin-button:hover {
    background: #f5f6fa;
}

/* Mobil cihazlar için responsive ayarlar */
@media screen and (max-width: 1200px) {
    .user-list {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media screen and (max-width: 768px) {
    .user-list {
        grid-template-columns: 1fr;
    }
    
    .user-card {
        height: auto; /* Mobilde yüksekliği otomatik yap */
        min-height: 82px;
    }
}

/* Tablet cihazlar için düzenlemeler */
@media screen and (min-width: 769px) and (max-width: 1024px) {
    .nk-content {
        padding: 15px;
    }

    .card {
        height: calc(100vh - 40px);
    }

    .user-list {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 12px;
    }
}

/* Pin Modal mobil düzenlemeleri */
@media screen and (max-width: 768px) {
    .modal-dialog {
        margin: 10px;
    }

    .pin-pad {
        gap: 8px;
    }

    .pin-button {
        padding: 12px;
        font-size: 18px;
    }

    .pin-display {
        font-size: 20px;
        margin: 15px 0;
    }

    #selectedUserName {
        font-size: 14px;
    }
}

/* Pin doğrulama animasyonu için yeni stiller */
.pin-validation {
    text-align: center;
    margin: 0;
    display: none;
    padding: 40px 20px;
    transition: all 0.3s ease;
    min-height: 200px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.pin-validation i {
    font-size: 64px;
    margin-bottom: 16px;
    display: block;
}

.pin-validation.success i {
    color: #0acf97;
    animation: popIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.pin-validation.error i {
    color: #fa5c7c;
    animation: shake 0.5s cubic-bezier(0.36, 0.07, 0.19, 0.97);
}

.pin-validation-text {
    font-size: 18px;
    font-weight: 600;
    color: #364a63;
    margin-bottom: 8px;
}

.pin-validation-subtext {
    font-size: 14px;
    color: #8094ae;
    margin-top: 4px;
}

/* Yeni pop-in animasyonu */
@keyframes popIn {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    70% {
        transform: scale(1.2);
        opacity: 0.8;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

/* Yeni sallama animasyonu */
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    15%, 45%, 75% { transform: translateX(-10px); }
    30%, 60%, 90% { transform: translateX(10px); }
}

/* Yeni yükleniyor animasyonu */
.loading-spinner {
    width: 40px;
    height: 40px;
    border: 3px solid #e6e9f2;
    border-top: 3px solid #6576ff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-bottom: 16px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Modal içeriği için ek stiller */
.modal-content {
    border: none;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    border-radius: 16px;
    overflow: hidden;
}

.modal-header {
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding: 20px 24px;
}

.modal-body {
    padding: 24px;
}

/* Modal geçiş efekti */
.modal.fade .modal-dialog {
    transition: transform 0.3s ease-out;
    transform: scale(0.95);
}

.modal.show .modal-dialog {
    transform: scale(1);
}

/* Görünürlük animasyonu */
.user-card {
    transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s ease;
}

.user-card[style*="hidden"] {
    opacity: 0;
    transform: scale(0.95);
    pointer-events: none;
    position: absolute;
}

.modal-header {
    transition: all 0.3s ease;
}
</style>

<div class="user-container">
    <!-- Arama kutusu -->
    <div class="search-container">
        <input type="text" 
               class="search-input" 
               placeholder="Kullanıcı ara..." 
               id="userSearch"
               onkeyup="searchUsers()">
    </div>

    <div class="user-list">
        <?php foreach ($user_item as $user): ?>
            <div class="user-card" data-user-name="<?= strtolower($user['user_adsoyad']) ?>">
                <div class="user-info">
                    <div class="user-avatar">
                        <em class="icon ni ni-user"></em>
                    </div>
                    <div class="user-details">
                        <div class="user-name"><?= $user['user_adsoyad'] ?></div>
                        <div class="user-operation"><?= $user['operation_title'] ?></div>
                    </div>
                </div>
                <button class="login-btn" onclick="showPinModal('<?= $user['client_id'] ?>', '<?= $user['user_adsoyad'] ?>')">
                    <em class="icon ni ni-login"></em>
                    <span>Giriş</span>
                </button>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Pin Modal -->
<div class="modal fade" id="pinModal" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">PIN Girişi</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h6 id="selectedUserName"></h6>
                </div>
                <div class="pin-display" id="pinDisplay">****</div>
                
                <!-- Pin doğrulama mesajı için yeni div -->
                <div class="pin-validation" id="pinValidation">
                    <i class="icon ni ni-check-circle-fill"></i>
                    <div class="pin-validation-text"></div>
                </div>
                
                <div class="pin-pad">
                    <button class="pin-button" onclick="addPin('1')">1</button>
                    <button class="pin-button" onclick="addPin('2')">2</button>
                    <button class="pin-button" onclick="addPin('3')">3</button>
                    <button class="pin-button" onclick="addPin('4')">4</button>
                    <button class="pin-button" onclick="addPin('5')">5</button>
                    <button class="pin-button" onclick="addPin('6')">6</button>
                    <button class="pin-button" onclick="addPin('7')">7</button>
                    <button class="pin-button" onclick="addPin('8')">8</button>
                    <button class="pin-button" onclick="addPin('9')">9</button>
                    <button class="pin-button" onclick="clearPin()">C</button>
                    <button class="pin-button" onclick="addPin('0')">0</button>
                    <button class="pin-button" onclick="submitPin()">✓</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentPin = '';
let selectedUserId = '';
let isProcessing = false;

// Klavye girişi için event listener
document.addEventListener('keydown', function(e) {
    if ($('#pinModal').is(':visible')) {
        // Sayısal tuşlar (hem normal hem numpad)
        if ((e.key >= '0' && e.key <= '9') || (e.key >= 'Numpad0' && e.key <= 'Numpad9')) {
            const num = e.key.replace('Numpad', '');
            addPin(num);
        }
        // Backspace veya Delete tuşu
        else if (e.key === 'Backspace' || e.key === 'Delete') {
            clearPin();
        }
        // Enter tuşu
        else if (e.key === 'Enter' && currentPin.length === 4) {
            submitPin();
        }
    }
});

function showPinModal(userId, userName) {
    selectedUserId = userId;
    currentPin = '';
    isProcessing = false;
    updatePinDisplay();
    $('#selectedUserName').text(userName);
    $('#pinValidation').hide();
    $('.modal-header').show(); // Modal açılırken header'ı göster
    $('#pinDisplay').show();
    $('.pin-pad').show();
    $('#pinModal').modal('show');
}

function showValidationMessage(success, message) {
    const validationEl = $('#pinValidation');
    const modalHeader = $('.modal-header');
    
    // Reset classes
    validationEl.removeClass('success error');
    
    // Modal header'ı gizle
    modalHeader.fadeOut(200);
    
    let icon, title, subtext;
    if (success) {
        icon = 'ni ni-check-circle-fill';
        title = 'Pin Kodu Doğrulandı';
        subtext = 'Yönlendiriliyorsunuz...';
    } else {
        icon = 'ni ni-cross-circle-fill';
        title = 'Başarısız';
        subtext = message || 'Geçersiz PIN kodu';
    }
    
    validationEl.html(`
        <i class="icon ${icon}"></i>
        <div class="pin-validation-text">${title}</div>
        <div class="pin-validation-subtext">${subtext}</div>
    `).addClass(success ? 'success' : 'error');
    
    // Animasyonlu geçiş
    $('#pinDisplay').fadeOut(200);
    $('.pin-pad').fadeOut(200);
    validationEl.fadeIn(200);
}

function addPin(number) {
    if (currentPin.length < 4) {
        currentPin += number;
        updatePinDisplay();
        if (currentPin.length === 4) {
            setTimeout(submitPin, 300);
        }
    }
}

function clearPin() {
    currentPin = '';
    updatePinDisplay();
}

function updatePinDisplay() {
    const display = '*'.repeat(currentPin.length) + '_'.repeat(4 - currentPin.length);
    $('#pinDisplay').text(display);
}

function submitPin() {
    if (currentPin.length === 4 && !isProcessing) {
        isProcessing = true;
        
        // Yükleniyor durumunu göster
        $('#pinDisplay').fadeOut(200);
        $('.pin-pad').fadeOut(200);
        $('.modal-header').fadeOut(200);
        
        $('#pinValidation').html(`
            <div class="loading-spinner"></div>
            <div class="pin-validation-text">Doğrulanıyor</div>
        `).fadeIn(200);
        
        $.ajax({
            url: '<?= route_to("tportal.auth.personelLogin") ?>',
            method: 'POST',
            data: {
                user_id: selectedUserId,
                pin: currentPin
            },
            success: function(response) {
                if (response.success) {
                    showValidationMessage(true, response.message);
                    setTimeout(() => {
                        window.location.href = response.redirect;
                    }, 2500);
                } else {
                    showValidationMessage(false, response.message);
                    setTimeout(() => {
                        isProcessing = false;
                        clearPin();
                        $('#pinValidation').fadeOut(200, function() {
                            $('.modal-header').fadeIn(200);
                            $('#pinDisplay').fadeIn(200);
                            $('.pin-pad').fadeIn(200);
                        });
                    }, 2500);
                }
            },
            error: function() {
                showValidationMessage(false, 'Bağlantı hatası oluştu');
                setTimeout(() => {
                    isProcessing = false;
                    $('#pinModal').modal('hide');
                }, 2500);
            }
        });
    }
}

function searchUsers() {
    const searchTerm = document.getElementById('userSearch').value.toLowerCase();
    const userCards = document.querySelectorAll('.user-card');

    userCards.forEach(card => {
        const userName = card.getAttribute('data-user-name');
        if (userName.includes(searchTerm)) {
            card.style.display = '';
            card.style.visibility = 'visible';
            card.style.order = '1';
        } else {
            card.style.visibility = 'hidden';
            card.style.order = '2';
        }
    });
}
</script>

<?= $this->endSection() ?>