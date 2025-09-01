<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Senet - <?= $check['check_no'] ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            font-size: 12pt;
        }
        .senet-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .senet-header {
            text-align: center;
            margin-bottom: 30px;
            font-size: 16pt;
            font-weight: bold;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .info-box {
            border: 1px solid #ccc;
            padding: 5px 10px;
            background-color: #f5f5f5;
        }
        .content-box {
            border: 1px solid #000;
            padding: 15px;
            margin: 20px 0;
            min-height: 100px;
        }
        .footer-info {
            margin-top: 30px;
        }
        .qr-code {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        @media print {
            body {
                margin: 0;
                padding: 20px;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="senet-container">
        <div class="senet-header">SENET</div>
        
        <div class="info-row">
            <div>
                <strong>ÖDEME GÜNÜ</strong><br>
                <div class="info-box"><?= date('d.m.Y', strtotime($check['due_date'])) ?></div>
            </div>
            <div>
                <strong>TUTAR</strong><br>
                <div class="info-box"><?= number_format($check['amount'], 2) ?> <?= $check['currency'] ?></div>
            </div>
            <?php if ($check['currency'] !== 'TRY'): ?>
            <div>
                <strong>KUR</strong><br>
                <div class="info-box"><?= number_format($check['exchange_rate'], 4) ?></div>
            </div>
            <?php endif; ?>
        </div>

        <div class="content-box">
            İşbu emre yazılı senedim.... mukabilinde <?= date('d F Y', strtotime($check['due_date'])) ?> tarihinde
            Sayın <?= $check['drawer_id'] ? 'XXXX' : 'XXXX' ?> veyahut emruhavale ....... yukarıda yazılı yalnız
            #<?= number_format($check['amount'], 2) ?># ödeyeceği... Bedeli .......... ahzolunmuştur. İhtilaf vukuunda
            ................... mahkemelerinin selahiyetini, avukat ücreti dahil bütün
            mahkeme masraflarını ve bir senet ödenmediği takdirde diğerlerinin
            muacceliyet kesbedeceğini şimdiden kabul eyleri... Okudu...
        </div>

        <div class="footer-info">
            <div><strong>ÖDEYECEK</strong></div>
            <div><strong>ADRESİ</strong></div>
            <div><strong>VERGİ DAİRESİ</strong></div>
            <div><strong>VERGİ / TC NO</strong></div>
            <div style="margin-top: 20px;">
                <strong>DÜZENLENME</strong>: <?= date('d.m.Y', strtotime($check['issue_date'])) ?>
            </div>
            <div><strong>KEFİL</strong></div>
        </div>

        <?php if (!empty($check['check_image'])): ?>
            <div class="qr-code">
                <img src="<?= base_url($check['check_image']) ?>" alt="QR Kod" style="width: 100px;">
            </div>
        <?php endif; ?>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>