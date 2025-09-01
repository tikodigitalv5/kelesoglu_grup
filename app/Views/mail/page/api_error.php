
<?= $this->extend('mail/layout') ?>

<?= $this->section('content') ?>


<table style="width:100%;max-width:620px;margin:0 auto;background-color:#ffffff; text-align:center;">
    <tbody style="text-align:center;">
        <tr>
            <td style="padding: 30px 30px 15px 30px;">
                <h2 style="font-size: 18px; color: #a1aea4; font-weight: 600; margin: 0;"><?php echo $baslik; ?></h2>
            </td>
        </tr>
        <tr>
            <td style="padding: 0 30px 20px">
                <p style="margin-bottom: 10px;font-size: 14px;"><b>Senkronizasyon Tarihi: </b>  <?php echo $senk_tarih; ?></p>
               
            </td>
        </tr>

        <tr>
            <td style="padding: 0 30px 20px">
            <p style="margin-bottom: 10px;font-size: 14px;"><b>Senkronizasyon Mesajı: </b>  <?php echo $mesaj; ?></p>
               
            </td>
        </tr>

  

    </tbody>
</table>
    

<?= $this->endSection() ?>



