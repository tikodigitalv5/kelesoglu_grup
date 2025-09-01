<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VKN Birleştirme İşlemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .merge-card {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .merge-card:hover {
            border-color: #007bff;
            box-shadow: 0 4px 8px rgba(0,123,255,0.1);
            transform: translateY(-2px);
        }
        .merge-card.selected {
            border-color: #28a745;
            background-color: #f8fff9;
            box-shadow: 0 4px 12px rgba(40,167,69,0.2);
            position: relative;
        }
        .merge-card.selected::before {
            content: "BİRLEŞTİRİLECEK";
            position: absolute;
            top: -10px;
            left: 15px;
            background: #28a745;
            color: #fff;
            padding: 2px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: bold;
            z-index: 10;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .merge-card.merge-target {
            border-color: #ffc107;
            background-color: #fffbf0;
            box-shadow: 0 4px 12px rgba(255,193,7,0.2);
            position: relative;
        }
        .merge-card.merge-target::before {
            content: "ORJİNAL CARİ";
            position: absolute;
            top: -10px;
            left: 15px;
            background: #ffc107;
            color: #000;
            padding: 2px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: bold;
            z-index: 10;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .card-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .card-text strong {
            color: #495057;
        }
        .stats-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-merge"></i> VKN Birleştirme İşlemi</h2>
                    <button type="button" class="btn btn-secondary" onclick="window.close()">
                        <i class="fas fa-times"></i> Kapat
                    </button>
                </div>

                <?php if (empty($duplicateResults)): ?>
                    <div class="alert alert-success">
                        <h4><i class="fas fa-check-circle"></i> Tekrar Eden Kayıt Bulunamadı</h4>
                        <p>Tüm cari kayıtları benzersiz identification_number'lara sahip.</p>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <h4><i class="fas fa-exclamation-triangle"></i> Tekrar Eden Kayıtlar Bulundu</h4>
                        <p>Toplam <strong><?= count($duplicateResults) ?></strong> adet tekrar eden identification_number bulundu.</p>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fas fa-list"></i> Tekrar Eden VKN'ler</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>VKN/TC</th>
                                                    <th>Ad Soyad / Firma Adı</th>
                                                    <th>Tekrar Sayısı</th>
                                                    <th>İşlem</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($duplicateResults as $duplicate): ?>
                                                    <tr>
                                                        <td>
                                                            <strong><?= htmlspecialchars($duplicate['identification_number']) ?></strong>
                                                        </td>
                                                        <td>
                                                            <strong><?= !empty($duplicate['name']) && !empty($duplicate['surname']) ? htmlspecialchars($duplicate['name'] . ' ' . $duplicate['surname']) : htmlspecialchars($duplicate['invoice_title']) ?></strong>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-danger"><?= $duplicate['tekrar_sayisi'] ?> kayıt</span>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm" 
                                                                    onclick="showMergeModal('<?= htmlspecialchars($duplicate['identification_number']) ?>')">
                                                                <i class="fas fa-merge"></i> Birleştir
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Birleştirme Modal -->
    <div class="modal fade" id="mergeModal" tabindex="-1" aria-labelledby="mergeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mergeModalLabel">
                        <i class="fas fa-merge"></i> VKN Birleştirme: <span id="currentVkn"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle"></i> Birleştirme Talimatları:</h6>
                        <ul class="mb-0">
                            <li><strong>Orijinal Kayıt:</strong> Tüm işlemlerin aktarılacağı ana kayıt (sarı renkte)</li>
                            <li><strong>Birleştirilecek Kayıtlar:</strong> İşlemleri aktarılacak ve silinecek kayıtlar</li>
                            <li>Birleştirme işlemi geri alınamaz, dikkatli olun!</li>
                        </ul>
                    </div>

                    <div id="mergeCardsContainer">
                        <!-- Kayıtlar buraya yüklenecek -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> İptal
                    </button>
                    <button type="button" class="btn btn-success" id="confirmMergeBtn" onclick="confirmMerge()">
                        <i class="fas fa-check"></i> Birleştirmeyi Onayla
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="text-center text-white">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Yükleniyor...</span>
            </div>
            <div class="mt-3">
                <h5>İşlem yapılıyor...</h5>
                <p>Lütfen bekleyiniz</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let currentVkn = '';
        let mergeData = [];

        function showMergeModal(vkn) {
            currentVkn = vkn;
            $('#currentVkn').text(vkn);
            $('#mergeCardsContainer').html('<div class="text-center"><div class="spinner-border" role="status"></div></div>');
            
            // AJAX ile detayları getir
            $.ajax({
                url: '<?= route_to('tportal.cariler.getVknBirlesimDetay') ?>',
                type: 'POST',
                data: {
                    identification_number: vkn
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        mergeData = response.data;
                        renderMergeCards(response.data);
                        $('#mergeModal').modal('show');
                    } else {
                        alert('Hata: ' + response.message);
                    }
                },
                error: function() {
                    alert('Bir hata oluştu. Lütfen tekrar deneyin.');
                }
            });
        }

        function renderMergeCards(data) {
            let html = '';
            
            data.forEach((item, index) => {
                const companyName = item.invoice_title || (item.name + ' ' + item.surname);
                const fullName = (item.name || '') + ' ' + (item.surname || '');
                const type = item.company_type === 'company' ? 'Firma' : (item.company_type === 'person' ? 'Şahıs' : 'Kamu');
                const balanceClass = item.cari_balance >= 0 ? 'text-success' : 'text-danger';
                
                html += `
                    <div class="merge-card card" data-cari-id="${item.cari_id}" onclick="selectCard(this, ${item.cari_id})">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="card-title text-primary mb-2">${companyName}</h5>
                                    <p class="text-muted mb-1"><strong>Ad Soyad:</strong> ${fullName.trim() || '-'}</p>
                                    <p class="text-muted mb-1"><strong>Firma Adı:</strong> ${item.invoice_title || '-'}</p>
                                    <p class="card-text">
                                        <strong>ID:</strong> ${item.cari_id} | 
                                        <strong>Kod:</strong> ${item.cari_code} | 
                                        <strong>Tür:</strong> ${type}<br>
                                        <strong>Telefon:</strong> ${item.cari_phone || '-'} | 
                                        <strong>E-posta:</strong> ${item.cari_email || '-'}<br>
                                        <strong>Vergi Dairesi:</strong> ${item.tax_administration || '-'}<br>
                                        <strong>Oluşturulma:</strong> ${new Date(item.created_at).toLocaleDateString('tr-TR')}
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-end">
                                        <h5 class="${balanceClass}">${parseFloat(item.cari_balance).toLocaleString('tr-TR', {minimumFractionDigits: 2})} ₺</h5>
                                        <div class="mt-2">
                                            <span class="badge bg-primary stats-badge">${item.finansal_hareket_sayisi} Finansal</span>
                                            <span class="badge bg-info stats-badge">${item.fatura_sayisi} Fatura</span>
                                            <span class="badge bg-warning stats-badge">${item.siparis_sayisi} Sipariş</span>
                                            <span class="badge bg-secondary stats-badge">${item.adres_sayisi} Adres</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            $('#mergeCardsContainer').html(html);
        }

        function selectCard(cardElement, cariId) {
            // Önce tüm kartları temizle
            $('.merge-card').removeClass('selected merge-target');
            
            // Seçilen kartı işaretle
            $(cardElement).addClass('merge-target');
            
            // Diğer kartları seçilebilir yap
            $('.merge-card').not(cardElement).addClass('selected');
        }

        function confirmMerge() {
            const selectedCards = $('.merge-card.selected');
            const targetCard = $('.merge-card.merge-target');
            
            if (targetCard.length === 0) {
                alert('Lütfen orijinal kaydı seçin (sarı renkte olacak)');
                return;
            }
            
            if (selectedCards.length === 0) {
                alert('Lütfen birleştirilecek kayıtları seçin');
                return;
            }
            
            const originalCariId = targetCard.data('cari-id');
            const mergeCariIds = selectedCards.map(function() {
                return $(this).data('cari-id');
            }).get();
            
            // Onay al
            if (!confirm(`Bu işlem geri alınamaz!\n\nOrijinal Kayıt ID: ${originalCariId}\nBirleştirilecek Kayıtlar: ${mergeCariIds.join(', ')}\n\nDevam etmek istediğinizden emin misiniz?`)) {
                return;
            }
            
            // Loading göster
            $('#loadingOverlay').show();
            $('#mergeModal').modal('hide');
            
            // Birleştirme işlemini başlat
            $.ajax({
                url: '<?= route_to('tportal.cariler.vknBirlesimYap') ?>',
                type: 'POST',
                data: {
                    original_cari_id: originalCariId,
                    merge_cari_ids: mergeCariIds
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                success: function(response) {
                    $('#loadingOverlay').hide();
                    
                    if (response.success) {
                        alert('Birleştirme işlemi başarıyla tamamlandı!\n\nOrijinal Kayıt ID: ' + response.original_cari_id);
                        // Sayfayı yenile
                        location.reload();
                    } else {
                        alert('Hata: ' + response.message);
                    }
                },
                error: function() {
                    $('#loadingOverlay').hide();
                    alert('Bir hata oluştu. Lütfen tekrar deneyin.');
                }
            });
        }

        // Modal kapandığında seçimleri temizle
        $('#mergeModal').on('hidden.bs.modal', function () {
            $('.merge-card').removeClass('selected merge-target');
            mergeData = [];
        });
    </script>
</body>
</html> 