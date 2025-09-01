<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> <?= $page_title ?> <?= $this->endSection() ?>
<?= $this->section('title') ?> <?= $page_title ?> | <?= session()->get('user_item')['firma_adi'] ?>
<?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>


<style>
.user-name {
    cursor: pointer;
}

.user-name:hover {
    text-decoration: underline;
    color: #007bff;
}

.list-group-item {
    padding: 10px;
    border: 1px solid #ddd;
    margin-bottom: 5px;
    border-radius: 4px;
}
.modal-xxl{
    min-width: 1300px!important;
}
.list-group-item input[type="checkbox"] {
    margin-left: 10px;
}
.hidden {
    display: none !important; /* Öğe tamamen gizlenir */
}
    div.dataTables_wrapper div.dataTables_filter label{
        width: 97%;
        margin-bottom: 10px;
        margin-top: 10px;
    }

    .dataTables_filter{
        width: 100%!important;
        padding: 10px !important;
        margin-left:0 !important;
    }

    .dataTables_filter input{
        width:100%!important;
        font-size: 16px;
        padding: 10px 12px;
        border-radius: 6px;
        border: 1px solid #d1d5db;
    }
    
    #datatableOrder {
        font-size: 15px;
    }

    #datatableOrder tbody tr {
        height: 48px;
        vertical-align: middle;
    }

    #datatableOrder th, #datatableOrder td {
        padding: 10px 8px !important;
        vertical-align: middle;
    }

    #datatableOrder_wrapper {
    position: relative;
}
    .dt-loading {
        position: absolute;
        left: 0; right: 0; top: 0; bottom: 0;
        background: rgba(255,255,255,0.7);
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #3b82f6;
        font-weight: bold;
    }
    #datatableOrder_length{
        display: none!important;
    }
</style>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content  d-xl-none">
                        <h3 class="nk-block-title page-title"><?= $page_title ?></h3>

                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">

                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class="nk-block">
                <div class="card card-stretch">
                    <form onsubmit="return false;" id="create_shipment_order_form" method="POST">
                        <div class="card-inner-group">

                            <div class="card-inner position-relative card-tools-toggle">
                                <div class="gy-3">

                                    <div class="row g-3 pt-3 align-center">
                                        <div class="col-lg-3 col-xxl-3 ">
                                            <div class="form-group">
                                                <label class="form-label" for="stock_id">Sipariş</label>
                                                <span class="form-note d-none d-md-block">Lütfen sipariş
                                                    seçin.</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-xxl-9  mt-0 mt-md-2">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <div class="input-group flex-nowrap">
                                                    <input type="hidden" name="siparis_id"
                                                            id="siparis_id"
                                                            class="form-control form-control-xl" style="text-transform:uppercase !important;" disabled>
                                                        <input type="text" name="shipment_order_name"
                                                            id="shipment_order_name"
                                                            class="form-control form-control-xl" style="text-transform:uppercase !important;" disabled>
                                                        <div class="input-group-append">
                                                            <button id="btn_open_mdl_siparisSec"
                                                                class="btn btn-outline-primary btn-dim w-min-110px d-block">Sipariş
                                                                Seç</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row g-3 pt-3 align-center">


                                </div>
                            </div>
                        </div>
                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="gy-3">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-3 col-xxl-3 ">
                                        <div class="form-group"><label class="form-label" for="site-name">Üretim
                                                Emri Verilecek Ürünler</label><span
                                                class="form-note d-none d-md-block">Listedeki
                                                ürünler üretim emri verilecektir.</span></div>
                                    </div>
                                    <div class="col-md-9 col-lg-9 col-xxl-9  col-12 pt-4">
                                        <div class="invoice-bills">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th class="" style="width:80px !important;">Sıra No</th>
                                                            <th>Ürün Adı</th>
                                                            <th class="w-150px text-right"
                                                                style="padding-right:50px; text-align:right ">Sipariş
                                                            </th>
                                                            <th class="w-100px text-right"
                                                                style="padding-right:50px; text-align:right ">Stok</th>
                                                            <th class="w-100px text-right"
                                                                style="padding-right:50px; text-align:right ">
                                                                İşlemdekiler</th>
                                                            <th class="w-100px text-center" style="padding-right:50px;">
                                                                Durum</th>
                                                                <th class="w-110px text-right" style="padding-right:50px;">
                                                                Miktar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="order_items">
                                                    </tbody>
                                                    <tfoot style="display:none;">
                                                        <tr>
                                                            <td class=" text-end" colspan=""></td>
                                                            <td class=" text-end" colspan=""></td>
                                                            <td class=" text-end" colspan=""></td>
                                                            <td class=" text-end" colspan=""><input
                                                                    name="toplamSiparisMiktar" id="toplamSiparisMiktar"
                                                                    class="transparent-input form-control para" value=""
                                                                    readonly="" disabled=""><span
                                                                    id="toplamSiparisMiktarBirim"></span></td>
                                                            <td class=" text-end" colspan="">TOPLAM</td>
                                                            <td class=" text-end">
                                                                
                                                                <b id="total_yazi">0,00</b>
                                                                <b id="total_yazi_para_birimi"> $</b> <br>


                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center pt-5">
                                    <div class="col-lg-3 col-xxl-3 ">
                                        <div class="form-group"><label class="form-label" for="aciliyet">Üretim
                                                Aciliyeti</label><span class="form-note d-none d-md-block">Lütfen sadece acil üretim için seçiniz.</span></div>
                                    </div>
                                    <div class="col-lg-9 col-xxl-9 mt-0 mt-md-2">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <div class="custom-control custom-control-lg custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="aciliyet" name="aciliyet">
                                                    <label class="custom-control-label" for="aciliyet">
                                                        Acil
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center pt-5">
                                    <div class="col-lg-3 col-xxl-3 ">
                                        <div class="form-group"><label class="form-label" for="shipment_note">Üretim
                                                Notu</label><span class="form-note d-none d-md-block">Üretim ile
                                                ilgili notunuz varsa yazınız.</span></div>
                                    </div>
                                    <div class="col-lg-9 col-xxl-9 mt-0 mt-md-2">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <textarea class="form-control form-control-xl no-resize"
                                                    name="shipment_note" id="shipment_note"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-inner">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="form-group">
                                        <a href="javascript:history.back()"
                                            class="btn btn-lg btn-outline-light bg-white d-none d-sm-inline-flex"><em
                                                class="icon ni ni-arrow-left"></em><span>Geri</span></a>
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    <div class="form-group">
                                        <button id="kaydetButtons" class="btn btn-lg btn-primary"
                                            type="button">Kaydet</button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .card-inner -->
                </div><!-- .card-inner-group -->
                </form>
            </div><!-- .card -->

        </div><!-- .nk-block -->
    </div>
</div>
</div>
<!-- Modal Delete -->
<div class="modal fade" tabindex="-1" id="confirm_change_warehouse_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-question text-danger bg-transparent"
                        style="font-size: 70px;"></em>
                    <h4 class="nk-modal-title">Bu Depoyu Değiştirmek İstediğinize<br>Emin misiniz?</h4>
                    <div class="nk-modal-action mb-5">
                        <a href="#" class="btn btn-lg btn-mw btn-light" id="not_confirm_change_warehouse"
                            data-bs-dismiss="modal">Hayır</a>
                        <a href="#" class="btn btn-lg btn-mw btn-danger" id="confirm_change_warehouse"
                            data-bs-dismiss="modal">Evet</a>
                    </div>
                    <div class="nk-modal-text">
                        <p class="lead">Mevcut çıkış deposunu değiştirmek okuttuğunuz barkodların silinmesine yol
                            açacaktır.</p>
                    </div>
                </div>
            </div><!-- .modal-body -->
        </div>
    </div>
</div>

<?= view_cell(
    'App\Libraries\ViewComponents::getModals',
    [
        'element' => 'shipment',
        'modals' => [
            'ok' => [
                'modal_title' => 'İşlem Başarılı!',
                'modal_text' => 'İşlem Başarıyla Gerçekleşti.',
                'modal_buttons' => '<a href="#" id="shipmentDetail" class="btn btn-info btn-block mb-2">Bu Sevkiyatın Detayına Git</a>
                                    <a href="#" onclick="location.reload()" class="btn btn-primary btn-block mb-2" data-bs-dismiss="modal">Yeni Sevkiyat Emri Oluştur</a>
                                    <a href="' . route_to('tportal.shipment.list', 'all') . '" class="btn btn-l btn-dim btn-outline-dark btn-block">Sevkiyat Listesi</a>'
            ],
        ],
    ]
); ?>


<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= view_cell(
    'App\Libraries\ViewComponents::getSearchOrderModalUretim'
); ?>


<!-- Modal Trigger Code -->
<!-- Modal Content Code -->



<div class="modal fade" tabindex="-1" id="uretimModal">
  <div class="modal-dialog modal-dialog-scrollable modal-xxl" role="document">
    <div class="modal-content">
      <a href="#" class="close" data-dismiss="modal" aria-label="Close">
        <em class="icon ni ni-cross"></em>
      </a>
      <div class="modal-header">
        <h5 class="modal-title">Operasyon Kullanıcılarını Seç</h5>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Sol taraf: Operasyonlar ve kullanıcılar -->
          <div class="col-8" id="operationsContainer">
            <!-- Dinamik içerik buraya yüklenecek -->
          </div>
          <!-- Sağ taraf: Seçilmeyen kullanıcılar -->
          <div class="col-4" >
            <h6>Diğer Kullanıcılar</h6>
            <div class="list-group-item">
                <input type="text" id="userSearchInput" class="form-control" placeholder="Kullanıcı ara...">
            </div>
            <div class="list-group" id="availableUsers" style="">
            

            </div>
            <select id="targetOperationSelect" class="form-control mt-3">
                <option value="" disabled selected>Operasyon Seçiniz</option>
                <!-- Dinamik operasyonlar buraya yüklenecek -->
            </select>
            <button type="button" id="transferUsers" class="btn btn-success btn-block mt-3">Seçili Kullanıcıları Aktar</button>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-primary" id="kaydetButton">Üretim Emri Oluştur</button>
        <button type="button" class="btn btn-secondary" id="KapaModal" data-dismiss="modal">Kapat</button>
      </div>
    </div>
  </div>
</div>
<script>
    $("#KapaModal").click(function(){
        $("#uretimModal").modal("hide");
    });
$('#saveChanges').on('click', function () {
    const operationsData = []; // Tüm operasyon verilerini tutacak dizi

    // Tüm operasyonları işle
    document.querySelectorAll('.operation-users').forEach(operationContainer => {
        const operationId = operationContainer.id.split('_')[1]; // `operation_1` => 1
        const operationTitle = operationContainer.previousElementSibling.textContent.split('(')[0].trim(); // Operasyon başlığı
        const stockTitle = operationContainer.previousElementSibling.textContent.match(/\((.*?)\)/)?.[1] || ''; // Stok başlığı

        const users = []; // Operasyona bağlı kullanıcılar
        operationContainer.querySelectorAll('.list-group-item').forEach(userItem => {
            const clientId = userItem.querySelector('input').value; // Kullanıcı ID
            const username = userItem.querySelector('.user-name').textContent.split(' (')[0]; // Kullanıcı Adı
            users.push({ client_id: clientId, username: username }); // Kullanıcıları ekle
        });

        // Operasyonu ve kullanıcıları diziye ekle
        operationsData.push({
            operation_id: operationId,
            operation_title: operationTitle,
            stock_title: stockTitle,
            users: users
        });
    });

    console.log('Seçili Operasyonlar ve Kullanıcılar:', operationsData);

   
});
document.getElementById('transferUsers').addEventListener('click', function () {
    const selectedUsers = Array.from(document.querySelectorAll('#availableUsers input:checked'));
    const targetOperationId = document.getElementById('targetOperationSelect').value;

    if (!targetOperationId) {
        alert('Lütfen bir operasyon seçin!');
        return;
    }

    const targetOperation = document.getElementById(`operation_${targetOperationId}`);
    if (!targetOperation) {
        alert('Geçersiz Operasyon!');
        return;
    }

    selectedUsers.forEach(input => {
        const userId = input.value;
        const userName = input.parentElement.querySelector('.user-name').textContent.split(' (')[0]; // Sadece kullanıcı adı
        const userOperation = input.parentElement.querySelector('.user-name').textContent.match(/\((.*?)\)/)?.[1] || 'Operasyon Yok'; // Parantez içindeki unvan

        // Kullanıcı nesnesine unvanı ekleyerek aktar
        const user = { 
            client_id: userId, 
            username: userName, 
            operation_title: userOperation 
        };

        addUserToList(targetOperation, user, true); // Sol tarafa ekle
        input.parentElement.remove(); // Sağ taraftan kaldır
    });
});


function addUserToList(container, user, isChecked = false) {
    const userItem = document.createElement('div');
    userItem.className = 'list-group-item d-flex align-items-center justify-content-between';
    userItem.dataset.username = user.username.toLowerCase(); // Arama için kullanıcı adı
    userItem.dataset.operation = user.operation_title.toLowerCase(); // Arama için operasyon

    userItem.innerHTML = `
        <span class="user-name">${user.username} (${user.operation_title})</span>
        <input type="checkbox" ${isChecked ? 'checked' : ''} id="user_${user.client_id}" value="${user.client_id}">
    `;

    const checkbox = userItem.querySelector('input[type="checkbox"]');

    // Kullanıcı adına tıklama ile checkbox kontrolü bağlama ve kaldırma işlemi ekleme
    userItem.querySelector('.user-name').addEventListener('click', function () {
        checkbox.checked = !checkbox.checked;

        // Checkbox durumuna göre kaldırma işlemi yap
        if (!checkbox.checked) {
            moveUserToAvailable(user); // Sağ tarafa taşı
            userItem.remove(); // Sol listeden kaldır
        }
    });

    // Checkbox değişikliğine bağlı kaldırma işlemi
    if (container.id.startsWith('operation_')) {
        checkbox.addEventListener('change', function () {
            if (!this.checked) {
                moveUserToAvailable(user); // Sağ tarafa taşı
                userItem.remove(); // Sol listeden kaldır
            }
        });
    }

    container.appendChild(userItem);
}

// Arama işlevini ekleyelim
document.getElementById('userSearchInput').addEventListener('input', function () {
    const searchTerm = this.value.toLowerCase(); // Kullanıcı arama girdisi
    const userItems = document.querySelectorAll('#availableUsers .list-group-item'); // Liste öğelerini seç
    
    userItems.forEach(item => {
        const username = item.dataset.username || ''; // Kullanıcı adı
        const operation = item.dataset.operation || ''; // Operasyon adı

        // Arama terimini hem kullanıcı adında hem de operasyonda kontrol et
        if (username.includes(searchTerm) || operation.includes(searchTerm)) {
            item.classList.remove('hidden'); // Uygun olanlar sınıfı kaldırılarak gösterilir
        } else {
            item.classList.add('hidden'); // Uygun olmayanlar gizlenir
        }
    });
});


function moveUserToAvailable(user) {
    const availableUsersContainer = document.getElementById('availableUsers');
    addUserToList(availableUsersContainer, user);
}







$(document).on('keyup change focusout', '.girilen_miktar', function() {
    // Input alanından değerleri al
    var enteredValue = parseFloat($(this).val());
    var minOrderValue = parseFloat($(this).data('min'));
    var maxStockValue = parseFloat($(this).data('max'));

  

    // Girdi stok miktarını aşıyorsa SweetAlert ile uyarı göster
    if (enteredValue > maxStockValue) {
        Swal.fire({
            icon: 'error',
            title: 'Hata',
            text: 'Girilen miktar stok miktarını aşamaz! Maksimum: ' + maxStockValue,
            confirmButtonText: 'Tamam'
        });
        $(this).val(maxStockValue); // Maksimum stok miktarına geri döndür
    }
});

$(document).ready(function(){
    $('#kaydetButtons').on('click', function(){

        Swal.fire({
    title: 'Üretim Emiri Oluşturuluyor',
    html: '<br><b>Operasyon kullanıcılarını seçiniz</b><br><strong></strong>',
    timer: 3000, // 3 saniye
    timerProgressBar: true, // İlerleme çubuğu göster
    allowOutsideClick: false, // Kullanıcı kapatamasın
    showConfirmButton: false, // Butonları gizle
    didOpen: () => {
        Swal.showLoading(); // Dönen yükleme animasyonu göster
        const timerInterval = setInterval(() => {
            const timeLeft = (Swal.getTimerLeft() / 1000).toFixed(0); // Kalan süre
            Swal.getHtmlContainer().querySelector('strong').textContent = timeLeft;
        }, 100);
    },
    willClose: () => {
        clearInterval(timerInterval); // Zamanlayıcıyı temizle
    }
});



        // Tüm <tr> öğelerini seç
        var rows = $('table tbody tr');

        // Verileri saklamak için bir dizi oluştur
        var dataToSend = [];

        // Her bir satır için döngü
        var siparis_id = $('#siparis_id').val();
var shipment_note = $('#shipment_note').val();
var aciliyet = $('#aciliyet').is(':checked') ? 1 : 0;

rows.each(function(){
    var rowData = {};
    rowData.stock_id = $(this).data('stocks_id');
    rowData.stock_title = $(this).data('stock_title');
    rowData.stock_amount = $(this).data('stock_amount');
    rowData.stock_total = $(this).data('stock_total');
    var girilen_miktar = $(this).find('.girilen_miktar').val();
    rowData.girilen_miktar = girilen_miktar;



    dataToSend.push(rowData);
});



/* 
seçilen saç  eğer full ise stoktan1  düş 
eğer full değil ve kalan saç var ise stoğa ekle ve gene 1 düş 
modal x kontrol
ham madde olarak geri dön 
*/




        // Verileri sunucuya göndermek için AJAX isteği yap
    
        $.ajax({
            url: '<?php echo route_to("tportal.uretim.uretimOlustur"); ?>', // Verileri göndereceğiniz controller'ın bulunduğu URL
            method: 'POST',
            data: {rowsData: dataToSend, siparis_id:siparis_id, shipment_note:shipment_note, aciliyet:aciliyet},
            dataType: 'json',
            
            success: function(response) {

                Swal.close();

                // Eğer response bir JSON string ise parse edelim
                if (typeof response === 'string') {
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        console.error("Yanıt JSON formatında değil:", response);
                        Swal.fire({
                            title: "Hata Oluştu",
                            html: "Beklenmeyen bir hata oluştu.",
                            confirmButtonText: "Tamam",
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            icon: "error",
                        });
                        return;
                    }
                }

                if (response.icon === 'success') {
                    Swal.fire({
                        title: "İşlem Başarılı",
                        html: 'Üretim Emri Başarıyla Oluşturuldu',
                        confirmButtonText: "Tamam",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        icon: "success",
                    })
                    .then(function() {
                      // window.location.href = '<?php echo route_to("tportal.uretim.list"); ?>';
                    });
                } else if (response.status === 'uretimkullanici') {


                    response.operations.forEach(operation => {
    const operationOption = document.createElement('option');
    const relatedProducts = operation.related_products
        .map(product => `${product.stock_title}`)
        .join(' - ');
    operationOption.value = operation.operation_id; // Operasyon ID
    operationOption.textContent = `${operation.operation_title} (${relatedProducts})`; // Görünen metin
    document.getElementById('targetOperationSelect').appendChild(operationOption);
});
                    
const operationsContainer = document.getElementById('operationsContainer');
const availableUsersContainer = document.getElementById('availableUsers');

// Önce içeriği temizle
operationsContainer.innerHTML = '';
availableUsersContainer.innerHTML = '';

// 1. Operasyonları ve seçili kullanıcıları ekleyelim
response.operations.forEach(operation => {
    const operationDiv = document.createElement('div');
    operationDiv.className = 'mb-4';

    const relatedProducts = operation.related_products
        .map(product => `<span class="related-product"><b>${product.stock_title}</b> </span>`)
        .join(' / ');

    operationDiv.innerHTML = `
        <h6>${operation.operation_title} -  ( ${relatedProducts} )  </h6>
        <div class="list-group operation-users" id="operation_${operation.operation_id}">
        </div>
    `;

    // Kullanıcıları bu operasyon altına ekle
    const usersList = operationDiv.querySelector(`#operation_${operation.operation_id}`);
    
    // Sadece ilk kullanıcıyı seçili olarak ekle
    const selectedUsers = response.selected_users
        .filter(user => user.user_operation_id === operation.operation_id);
    
    if (selectedUsers.length > 0) {
        addUserToList(usersList, selectedUsers[0], true); // Sadece ilk kullanıcıyı seçili olarak ekle
        
        // Diğer kullanıcıları available_users listesine ekle
        selectedUsers.slice(1).forEach(user => {
            response.available_users.push(user);
        });
    }

    operationsContainer.appendChild(operationDiv);
});

// 2. Sağ tarafta seçilmeyen kullanıcıları ekleyelim
response.available_users.forEach(user => {
    addUserToList(availableUsersContainer, user, false); // Sağ tarafa ekle
});

    // Modalı Göster
    $('#uretimModal').modal('show');

                } else if (response.icon === 'danger') {
                    var errorMessages = response.message.map(function(msg) {
                        return msg.error;
                    }).join('<br>');

                    Swal.fire({
                        title: "Bilgilendirme",
                        html: errorMessages,
                        confirmButtonText: "Tamam",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        icon: "info",
                    });

                } else if (response.icon === 'esik_stok') {

                   
                    let message = response.message;
            let eksikUrunler = response.eksik_urunler;
            let tableContent = "<br><table style='margin-top:10px;' class='table'><thead><tr><th>Ürün Adı</th><th>İstenen </th><th>Mevcut </th><th>Eksik </th><th>Üretilebilecek </th></tr></thead><tbody>";

            eksikUrunler.forEach(function(stock) {
                tableContent += "<tr>";
                tableContent += "<td>" + stock.stock_title + "</td>";
                tableContent += "<td>" + stock.istenen_miktar + "</td>";
                tableContent += "<td>" + stock.mevcut_stok + "</td>";
                tableContent += "<td>" + stock.eksik_miktar + "</td>";
                tableContent += "<td>" + stock.uret_ilebilecek_adet + "</td>";
                tableContent += "</tr>";
            });

            tableContent += "</tbody></table>";

            Swal.fire({
                icon: 'warning',
                title: 'Yetersiz Stok',
                html: message + tableContent,
                width: '600px',  // Genişliği burada ayarlıyoruz
                confirmButtonText: 'Tamam'
            });

                } else if (response.icon === 'yeterli_stok') {
                   
                    let receteUrunleri = response.recete_urunleri;
            let tableContent = "<table class='table'><thead><tr><th>Reçete Ürün Adı</th><th>Gerekli Miktar</th></tr></thead><tbody>";

            receteUrunleri.forEach(function(urun) {
                tableContent += "<tr>";
                tableContent += "<td>" + urun.stock_title + "</td>";
                tableContent += "<td>" + urun.used_amount * girilenMiktar + "</td>";  // Gerekli miktarı göster
                tableContent += "</tr>";
            });

            tableContent += "</tbody></table>";

            Swal.fire({
                icon: 'success',
                title: 'Yeterli Stok',
                width: '600px' , // Genişliği burada ayarlıyoruz
                html: data.message + tableContent,
                confirmButtonText: 'Tamam'
            });

               } else {
                    Swal.fire({
                        title: "Hata Oluştu",
                        html: "Bilinmeyen bir hata oluştu.",
                        confirmButtonText: "Tamam",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        icon: "error",
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Ajax Hatası:", status, error);
                Swal.fire({
                    title: "Hata Oluştu",
                    html: "Beklenmeyen bir hata oluştu. Lütfen tekrar deneyin.",
                    confirmButtonText: "Tamam",
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    icon: "error",
                });
            }

            

        });
   
    });
});

    var selected_from_warehouse = 0;

    $('#btn_open_mdl_siparisSec').click(function () {
        $('#mdl_siparisSec').modal('show');
    });

    $(document).on("click", ".rd_order", function () {

        selectedOrderId = $('.rd_order:checked').val();
        selectedOrderCariId = $('.rd_order:checked').attr('data-cari-id');
        selectedOrderCariText = $('.rd_order:checked').attr('data-order-cari-title');



        $("#siparis_id").val(selectedOrderId);
        $('#shipment_order_name').val(selectedOrderCariText);


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.uretim.getOrderDetail') ?>',
            dataType: 'json',
            data: {
                orderId: selectedOrderId,
            },
            async: true,
            success: function (response) {
                if (response['icon'] == 'success') {
                    
                    $('#order_items').html(response.data);
                    // jQuery('<option value="0" disabled selected>Sevk edilecek ürünü seçiniz.</option>').appendTo('#stock_id');

                    // JQuery(response['data']).appendTo('#order_items');



                    // response['data'].forEach(function (order_item) {
                    //     jQuery('<tr>', {
                    //         value: order_item.stock_id,
                    //         html: order_item.stock_code + ' | ' + order_item.stock_title, 'data-remaining-amount': order_item.total_remaining_amount, 'data-unit-id': order_item.buy_unit_id
                    //     }).appendTo(response['data']);
                    // })

                    function checkInputs() {
            let allValid = true;
            
            $('.girilen_miktar').each(function() {
                var row = $(this).closest('tr');
                var maxAmount = parseFloat(row.data('stock_amount').replace(',', '.'));
                var busayiStok = parseFloat(row.find('.busayi_stok').text().replace('.', '').replace(',', '.'));
                var currentValue = parseFloat($(this).val().replace(',', '.'));

                if (isNaN(currentValue)) {
                    currentValue = 0;
                }

                if (currentValue > maxAmount || currentValue > busayiStok || currentValue === 0) {
                    allValid = false;
                    return false;  // break out of each loop
                }
            });

         
        }

        $('.girilen_miktar').on('keyup', function() {
            var row = $(this).closest('tr');
            var maxAmount = parseFloat(row.data('stock_amount').replace(',', '.'));
            var busayiStok = parseFloat(row.find('.busayi_stok').text().replace('.', '').replace(',', '.'));
            var currentValue = parseFloat($(this).val().replace(',', '.'));

            if (isNaN(currentValue)) {
                currentValue = 0;
            }

           
            
            checkInputs();
        });

        // Initial check on page load
        checkInputs();

                    swetAlert("İşlem Başarılı", response['message'], "ok");
                    $('#mdl_siparisSec').modal('hide');
                } else {
                    swetAlert("Hatalı İşlem", response['message'], "err");
                }
            }
        })


    });

    $('#from_warehouse').on('change', function () {
        if (selected_from_warehouse == this.value || selected_from_warehouse == 0) {
            selected_from_warehouse = this.value;
            getStockItemsByWarehouse(this.value)
            return;
        } else {
            $('#confirm_change_warehouse_modal').modal('toggle');
            temp_value = this.value
        }
    });

    $('#confirm_change_warehouse').on('click', function () {
        selected_from_warehouse = temp_value
        $('#confirm_change_warehouse_modal').modal('toggle');
        $('#shipment_order_items').empty();
        $('#total_amount').val(0)
        $('#total_yazi').html(0)

        getStockItemsByWarehouse(temp_value)
    })

    $('#not_confirm_change_warehouse').on('click', function () {
        $("#from_warehouse").val(selected_from_warehouse);
        $('#from_warehouse').trigger('change');
    })

    function getStockItemsByWarehouse(warehouse_id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            type: 'POST',
            url: '<?= route_to('tportal.shipment.stock.list') ?>',
            dataType: 'json',
            data: {
                warehouse_id: warehouse_id,
            },
            async: true,
            success: function (response) {
                if (response['icon'] == 'success') {
                    $('#stock_id').empty();
                    jQuery('<option value="0" disabled selected>Sevk edilecek ürünü seçiniz.</option>')
                        .appendTo('#stock_id')
                    response['stock_items'].forEach(function (stock_item) {
                        jQuery('<option>', {
                            value: stock_item.stock_id,
                            html: stock_item.stock_code + ' | ' + stock_item.stock_title,
                            'data-remaining-amount': stock_item.total_remaining_amount,
                            'data-unit-id': stock_item.buy_unit_id
                        }).appendTo('#stock_id');
                    })
                    swetAlert("İşlem Başarılı", response['message'], "ok");
                } else {
                    swetAlert("Hatalı İşlem", response['message'], "err");
                }
            }
        })
    }

    $('#stock_id').on('change', function () {
        if (this.value == 0 || this.value == undefined || this.value == '') {
            return;
        }

        remaining_amount = $(this).find(':selected').attr('data-remaining-amount')
        $('#remaining_quantity').val(replace_for_form_input(parseFloat(remaining_amount).toFixed(4)))
    })

    $('#is_sample').on('change', function () {
        if ($('#is_sample').is(":checked")) {
            shipment_order_quantity = $('#shipment_order_quantity').val()
            if (String(shipment_order_quantity).includes(",")) {
                shipment_order_quantity = shipment_order_quantity.replace(',', '.')
                shipment_order_quantity = parseFloat(shipment_order_quantity).toFixed(4)
            } else {
                shipment_order_quantity = parseFloat(shipment_order_quantity).toFixed(4)
            }

            if (shipment_order_quantity > 10) {
                swetAlert("Dikkat", "Numune ürünlerde sevkiyat miktarı 10 birimi geçemez.", "err");
                $('#shipment_order_quantity').val('10,0000')
            }
        }
    });

    $('#shipment_order_quantity').on('blur', function () {
        // Depo ve ürün id seçilmiş mi diye bakıyoruz
        // Girilen değer 0 mı diye bakıyoruz
        if (parseFloat($(this).val()) != 0 &&
            ($('#stock_id').find(':selected').val() == 0 ||
                $('#stock_id').find(':selected').val() == '' ||
                $('#stock_id').find(':selected').val() == undefined)) {
            $('#shipment_order_quantity').val('0,0000');
            swetAlert("Hatalı İşlem", "Lütfen miktar girmeden önce depo ve stok seçiniz", "err");
            return;
        }
        // Numune olarak işaretlenmiş mi diye bakıyoruz
        is_sample = $('#is_sample').is(":checked");
        if ($('#shipment_order_quantity').val() != null && $('#shipment_order_quantity').val() != '') {
            shipment_order_quantity = $('#shipment_order_quantity').val()
            if (String(shipment_order_quantity).includes(",")) {
                shipment_order_quantity = shipment_order_quantity.replace(',', '.')
                shipment_order_quantity = parseFloat(shipment_order_quantity).toFixed(4)
            } else {
                shipment_order_quantity = parseFloat(shipment_order_quantity).toFixed(4)
            }
            remaining_amount = $('#remaining_quantity').val();
            if (String(remaining_amount).includes(",")) {
                remaining_amount = remaining_amount.replace(',', '.')
                remaining_amount = parseFloat(remaining_amount).toFixed(4)
            } else {
                remaining_amount = parseFloat(remaining_amount).toFixed(4)
            }

            if (is_sample && shipment_order_quantity > 10) {
                $('#shipment_order_quantity').val('10,0000')
                swetAlert("Hatalı İşlem", "Numune olarak işaretlenen ürün 10m'yi geçemez.", "err");
                return;
            }

            if (parseFloat(shipment_order_quantity) > parseFloat(remaining_amount)) {
                $('#shipment_order_quantity').val('0,0000')
                swetAlert("Hatalı İşlem", "Sevkiyatı yapılacak miktar depodaki miktardan fazla olamaz.", "err");
                return;
            }

            shipment_order_quantity = replace_for_form_input(shipment_order_quantity)

            $('#shipment_order_quantity').val(shipment_order_quantity)
        } else {
            $('#shipment_order_quantity').val('0,0000')
        }
    })

    $('#add_shipment_order_item').on('click', function () {
        if (parseFloat($('#shipment_order_quantity').val()) != 0 &&
            ($('#stock_id').find(':selected').val() == 0 ||
                $('#stock_id').find(':selected').val() == '' ||
                $('#stock_id').find(':selected').val() == undefined)) {
            $('#shipment_order_quantity').val('0,0000');
            swetAlert("Hatalı İşlem", "Lütfen sevkiyat emri eklemeden önce depo ve stok seçiniz", "err");
            return;
        }
        shipment_order_note = $('#shipment_order_note').val();
        shipment_order_quantity = $('#shipment_order_quantity').val();
        is_sample = $('#is_sample').is(":checked");
        remaining_amount = $('#remaining_amount').val();
        stock_id = $('#stock_id').find(':selected').val();
        stock_title = $('#stock_id').find(':selected').html();
        unit_id = $('#stock_id').find(':selected').attr('data-unit-id');
        if ($('#order_item_' + stock_id).length) {
            swetAlert("Hatalı İşlem", "Aynı stok sevkiyata birden fazla kez eklenemez", "err");
            return;
        } else if (parseFloat(shipment_order_quantity.replace(',', '.')) == 0 || shipment_order_quantity == '' || shipment_order_quantity == undefined) {
            swetAlert("Hatalı İşlem", "Lütfen sevkiyat emrine geçerli bir miktar ekleyiniz", "err");
            return;
        }

        total_stock_amount = $('#total_stock_amount').val()
        total_stock_amount = parseFloat(shipment_order_quantity.replace(',', '.')) + parseFloat(total_stock_amount);
        $('#total_stock_amount').val(parseFloat(total_stock_amount).toFixed(4));
        $('#total_yazi').empty().html(replace_for_form_input(parseFloat(total_stock_amount).toFixed(4)))

        new_row = jQuery('<tr>', {
            id: 'order_item_' + stock_id,
            class: 'shipment_order_item',
            'data-remaining-amount': remaining_amount,
            'data-shipment-order-quantity': shipment_order_quantity,
            'data-shipment-order-note': shipment_order_note,
            'data-stock-id': stock_id,
            'data-unit-id': unit_id,
            'data-is-sample': is_sample
        }).appendTo('#shipment_order_items');

        jQuery('<td>', {
            html: stock_title,
            class: 'w-100',
            'data-stock-title': stock_title,
        }).appendTo('#order_item_' + stock_id);
        jQuery('<td>', {
            html: shipment_order_note,
            class: 'd-none',
            'data-shipment-order-note': shipment_order_note,
        }).appendTo('#order_item_' + stock_id);
        jQuery('<td>', {
            html: shipment_order_quantity,
            'data-shipment-order-quantity': shipment_order_quantity,
        }).appendTo('#order_item_' + stock_id);

        $("#stock_id").val(0);
        $('#stock_id').trigger('change');
        $('#shipment_order_note').val('');
        $('#shipment_order_quantity').val('');
        $('#remaining_amount').val('');
    });

    $('#yeniSevkiyat').on('click', function (e) {

      

            


        
    });




    $(document).ready(function(){
    $('#kaydetButton').on('click', function(){

        Swal.fire({
    title: 'Üretim Emiri Oluşturuluyor',
    html: '<br><b>Lütfen bekleyiniz..</b><br><strong></strong>',
    timer: 3000, // 3 saniye
    timerProgressBar: true, // İlerleme çubuğu göster
    allowOutsideClick: false, // Kullanıcı kapatamasın
    showConfirmButton: false, // Butonları gizle
    didOpen: () => {
        Swal.showLoading(); // Dönen yükleme animasyonu göster
        const timerInterval = setInterval(() => {
            const timeLeft = (Swal.getTimerLeft() / 1000).toFixed(0); // Kalan süre
            Swal.getHtmlContainer().querySelector('strong').textContent = timeLeft;
        }, 100);
    },
    willClose: () => {
        clearInterval(timerInterval); // Zamanlayıcıyı temizle
    }
});


const operationsData = []; // Tüm operasyon verilerini tutacak dizi

// Tüm operasyonları işle
document.querySelectorAll('.operation-users').forEach(operationContainer => {
    const operationId = operationContainer.id.split('_')[1]; // `operation_1` => 1
    const operationTitle = operationContainer.previousElementSibling.textContent.split('(')[0].trim(); // Operasyon başlığı
    const stockTitle = operationContainer.previousElementSibling.textContent.match(/\((.*?)\)/)?.[1] || ''; // Stok başlığı

    const users = []; // Operasyona bağlı kullanıcılar
    operationContainer.querySelectorAll('.list-group-item').forEach(userItem => {
        const clientId = userItem.querySelector('input').value; // Kullanıcı ID
        const username = userItem.querySelector('.user-name').textContent.split(' (')[0]; // Kullanıcı Adı
        users.push({ client_id: clientId, username: username }); // Kullanıcıları ekle
    });

    // Operasyonu ve kullanıcıları diziye ekle
    operationsData.push({
        operation_id: operationId,
        operation_title: operationTitle,
        stock_title: stockTitle,
        users: users
    });
});



        // Tüm <tr> öğelerini seç
        var rows = $('table tbody tr');

        // Verileri saklamak için bir dizi oluştur
        var dataToSend = [];

        // Her bir satır için döngü
        var siparis_id = $('#siparis_id').val();
var shipment_note = $('#shipment_note').val();
var aciliyet = $('#aciliyet').is(':checked') ? 1 : 0;

rows.each(function(){
    var rowData = {};
    rowData.stock_id = $(this).data('stocks_id');
    rowData.stock_title = $(this).data('stock_title');
    rowData.stock_amount = $(this).data('stock_amount');
    rowData.stock_total = $(this).data('stock_total');
    var girilen_miktar = $(this).find('.girilen_miktar').val();
    rowData.girilen_miktar = girilen_miktar;



    dataToSend.push(rowData);
});


$('#uretimModal').modal('hide');



        // Verileri sunucuya göndermek için AJAX isteği yap
    
        $.ajax({
            url: '<?php echo route_to("tportal.uretim.create"); ?>', // Verileri göndereceğiniz controller'ın bulunduğu URL
            method: 'POST',
            data: {rowsData: dataToSend, siparis_id:siparis_id, shipment_note:shipment_note, operationsData:operationsData, aciliyet:aciliyet},
            dataType: 'json',
            
            success: function(response) {

                Swal.close();

                // Eğer response bir JSON string ise parse edelim
                if (typeof response === 'string') {
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        console.error("Yanıt JSON formatında değil:", response);
                        Swal.fire({
                            title: "Hata Oluştu",
                            html: "Beklenmeyen bir hata oluştu.",
                            confirmButtonText: "Tamam",
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            icon: "error",
                        });
                        return;
                    }
                }

                if (response.icon === 'success') {
                    Swal.fire({
                        title: "İşlem Başarılı",
                        html: 'Üretim Emri Başarıyla Oluşturuldu',
                        confirmButtonText: "Tamam",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        icon: "success",
                    })
                    .then(function() {
                       window.location.href = '<?php echo route_to("tportal.uretim.list"); ?>';
                    });
                } 


                 else if (response.icon === 'danger') {
                    var errorMessages = response.message.map(function(msg) {
                        return msg.error;
                    }).join('<br>');

                    Swal.fire({
                        title: "Bilgilendirme",
                        html: errorMessages,
                        confirmButtonText: "Tamam",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        icon: "info",
                    });

                } else if (response.icon === 'esik_stok') {

                   
                    let message = response.message;
            let eksikUrunler = response.eksik_urunler;
            let tableContent = "<br><table style='margin-top:10px;' class='table'><thead><tr><th>Ürün Adı</th><th>İstenen </th><th>Mevcut </th><th>Eksik </th><th>Üretilebilecek </th></tr></thead><tbody>";

            eksikUrunler.forEach(function(stock) {
                tableContent += "<tr>";
                tableContent += "<td>" + stock.stock_title + "</td>";
                tableContent += "<td>" + stock.istenen_miktar + "</td>";
                tableContent += "<td>" + stock.mevcut_stok + "</td>";
                tableContent += "<td>" + stock.eksik_miktar + "</td>";
                tableContent += "<td>" + stock.uret_ilebilecek_adet + "</td>";
                tableContent += "</tr>";
            });

            tableContent += "</tbody></table>";

            Swal.fire({
                icon: 'warning',
                title: 'Yetersiz Stok',
                html: message + tableContent,
                width: '600px',  // Genişliği burada ayarlıyoruz
                confirmButtonText: 'Tamam'
            });

                } else if (response.icon === 'yeterli_stok') {
                   
                    let receteUrunleri = response.recete_urunleri;
            let tableContent = "<table class='table'><thead><tr><th>Reçete Ürün Adı</th><th>Gerekli Miktar</th></tr></thead><tbody>";

            receteUrunleri.forEach(function(urun) {
                tableContent += "<tr>";
                tableContent += "<td>" + urun.stock_title + "</td>";
                tableContent += "<td>" + urun.used_amount * girilenMiktar + "</td>";  // Gerekli miktarı göster
                tableContent += "</tr>";
            });

            tableContent += "</tbody></table>";

            Swal.fire({
                icon: 'success',
                title: 'Yeterli Stok',
                width: '600px' , // Genişliği burada ayarlıyoruz
                html: data.message + tableContent,
                confirmButtonText: 'Tamam'
            });

               } else {
                    Swal.fire({
                        title: "Hata Oluştu",
                        html: "Bilinmeyen bir hata oluştu.",
                        confirmButtonText: "Tamam",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        icon: "error",
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Ajax Hatası:", status, error);
                Swal.fire({
                    title: "Hata Oluştu",
                    html: "Beklenmeyen bir hata oluştu. Lütfen tekrar deneyin.",
                    confirmButtonText: "Tamam",
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    icon: "error",
                });
            }

            

        });
   
    });
});


</script>

<?= $this->endSection() ?>