const router = require('koa-router')()
const query = require('../app/controller/query');
const sql = require('mssql')
const axios = require('axios')
var cron = require('node-cron');
const fs = require('fs')
router.post('/query', async (ctx, next) => {
  ctx.body = await query.query(ctx)
})

router.get('/runSc/:id',async(ctx,next)=>{

  let id = ctx.params.id
 let rs = await getDb(id);

 ctx.response.body = rs
})
router.post('/runSc',async(ctx,next)=>{
 let id = ctx.request.body.id
 let rs = await getDb(id);

 ctx.response.body = rs
})
console.log('ok')

/* cron.schedule('59 01 * * *', () => {
  console.log('ok cron çalıştı')
  getDb(0);
}); */
const sqlConfig = {
  user: "web",
  password: "123456654321",
  database: "MikroDB_V16_BABY16",
  port: 65533,
  server: '109.235.248.100',
  pool: {
    max: 10,
    min: 0,
    idleTimeoutMillis: 300000000,
    acquireTimeoutMillis: 300000000,

  },
  options: {
    encrypt: false, // for azure
    trustServerCertificate: false, // change to true for local dev / self-signed certs,
    requestTimeout: 300000000
  }
}



const knex = require('knex')({
  client: 'mysql',
  connection: {
    host: '78.135.66.90',
    port: 3306,
    user: 'kitikate_us',
    password: '2iigNrDIaD5e2Bm6',
    database: 'kitikate_db'
  }
});


getDb(0);
/*


const knex = require('knex')({
  client: 'mysql',
  connection: {
    host: '45.143.99.171',
    port: 3306,
    user: 'kiti_last_us',
    password: '2iigNrDIaD5e2Bm6',
    database: 'kiti_last_db'
  }
}); */

async function sendRequest() {
  const axios = require('axios');

  const timestamp = Date.now();
  let configs = {
    method: 'GET',
    maxBodyLength: Infinity,
    url: `https://order.kitikate.com/api/v1/UzakPortalSQL?timestamp=${timestamp}`,
    headers: {
      'User-Agent': 'Mozilla/5.0',
      'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
      'Accept-Language': 'en-US,en;q=0.5',
      'Connection': 'keep-alive'
    }
        };

   return axios.request(configs)
    

}
async function getDb(id) {
  try {
    console.log('script çalıştı');

    // Veritabanına bağlanma
    await sql.connect(sqlConfig);
    console.log('Bağlantı kuruldu');

    // Veri çekme
    const result = await sql.query`SELECT * FROM MST_WEB_V2`;
    console.log('Veri çekildi');
    console.log('Data uzunluk:', result.recordset.length);

    // Gelen veriyi işlemeye başla
    const insertData = [];
    for (const element of result.recordset) {
      const insData = {
        KODU: element.KODU,
        ADI: element.ADI,
        BARKOD: element.BARKOD,
        BEDEN: element.BEDEN,
        RENK: element.RENK && element.RENK.trim() !== '' ? element.RENK : 'renksiz',
        ANA_DEPO: element['ANA DEPO'],
        ALT_GRUP_NO: element.ALT_GRUP_NO,
        ANA_GRUP_NO: element.ANA_GRUP_NO,
        ALT_GRUP_ISIM: element.ALT_GRUP_ISIM,
        BIRIM: element['BİRİM'],
        S_FIYAT_LISTE_SIRA_NO: element.sfiyat_listesirano,
        S_FIYAT: element.sfiyat_fiyati,
        ANA_GRUP_ISIM: element.ANA_GRUP_ISIM,
        RAF_KODU: element.REYON,
      };
      insertData.push(insData);
    }

    // Toplu veri ekleme
    if (insertData.length > 0) {
      await knex('urunler_mikro').insert(insertData);
      console.log('Insert işlemi tamamlandı');
    }

    // Tablodaki veri sayısını kontrol et
    const tableCount = await knex('urunler_mikro').count('* as count');
    const recordCount = parseInt(tableCount[0].count, 10);
    console.log(`Tablodaki veri sayısı: ${recordCount}`);

    if (recordCount === result.recordset.length) {
      console.log('Veri sayısı eşleşti, sendRequest çağrılıyor...');

      // Geri sayım ve sendRequest çağrısı
      let count = 3;
      const countdown = setInterval(() => {
        console.log(`${count}...`);
        count--;
        if (count === 0) {
          clearInterval(countdown);
          sendRequest().then(dbrq => {
            console.log('sendRequest isteği sonucu:', dbrq.data);

            if (dbrq.data === "ok") {
              console.log('Tablo güncellendi');
              const url = `https://order.kitikate.com/api/v1/anaurunler_isle/scs/${id}/basarili`;
              axios.get(url).then(() => {
                console.log('Başarı isteği gönderildi');
              });
            } else {
              const url = `https://order.kitikate.com/api/v1/anaurunler_isle/err/${id}/UzakPortalSQL_servisi_hata`;
              axios.get(url).then(() => {
                console.log('Hata isteği gönderildi');
              });
            }
          }).catch(error => {
            console.error('sendRequest hata:', error.message);
            const url = `https://order.kitikate.com/api/v1/anaurunler_isle/err/${id}/${error.message.replace(/\s/g, "")}`;
            axios.get(url).then(() => {
              console.log('Hata mesajı gönderildi');
            });
          });
        }
      }, 1000); // 1 saniye aralıklarla logla
    } else {
      console.log('Veri sayısı eşleşmedi, sendRequest çağrılmadı.');
    }
  } catch (error) {
    console.error('error', error.message);
    const url = `https://order.kitikate.com/api/v1/anaurunler_isle/err/${id}/${error.message.replace(/\s/g, "")}`;
    axios.get(url).then(() => {
      console.log('Hata mesajı gönderildi');
    });
    return {
      status: 200,
      code: "err",
      message: error.message
    };
  }
}



module.exports = router
