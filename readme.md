# Ödev 5: CRUD + Import/Export

Aşağıdaki json formatındaki bilgileri veritabanında tutacak şekilde `product` ve `category` içeriklerini görüntüleyebildiğimiz, düzenleyebildiğimiz ve silebildiğimiz bir web uygulaması oluşturulacak. Ek olarak, **Export** dökümanından(sayfasından) aşağıdaki formata uyacak şekilde ürünler ve kategoriler dışarı aktarılacak. Aynı şekilde, **Import** dökümanında(sayfasında) da `.json` dosyası yüklenerek bu bilgilerin senkronize edilmesi sağlanacak. Senkronize işlemini formatta yer alan `uniqid` alanına göre yapabilirsiniz. Yeni ürün ve kategori eklemelerinde [`uniqid(string $prefix="", bool $more_entropy=false): string`](https://www.php.net/manual/en/function.uniqid.php) ile uniqid oluşturabilirsiniz.

JSON Örneği;

```json=
[
    {
        "uniqid": "4b3403665fea6",
        "name": "Tamphome",
        "price": 98.55,
        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sit amet nisl porttitor nunc efficitur egestas ac sed elit. Vestibulum velit diam, viverra a vestibulum sit amet, euismod eu dui.",
        "content": "<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p><ul><li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li><li>Aliquam tincidunt mauris eu risus.</li><li>Vestibulum auctor dapibus neque.</li></ul><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>",
        "category": {
            "uniqid": "603539b085b7a",
            "name": "Category 1"
        }
   },
   {
       "uniqid": "603539c7c4758",
       "name": "Lam-Dox",
       "price": 99.55,
       "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sit amet nisl porttitor nunc efficitur egestas ac sed elit. Vestibulum velit diam, viverra a vestibulum sit amet, euismod eu dui.",
       "content": "<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p><ul><li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li><li>Aliquam tincidunt mauris eu risus.</li><li>Vestibulum auctor dapibus neque.</li></ul><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>",
       "category": {
            "uniqid": "603539b085b7a",
            "name": "Category 2"
        }
   },
   {
       "uniqid": "603539ffb7ff5",
       "name": "Roundfix",
       "price": 100.55,
       "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sit amet nisl porttitor nunc efficitur egestas ac sed elit. Vestibulum velit diam, viverra a vestibulum sit amet, euismod eu dui.",
       "content": "<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p><ul><li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li><li>Aliquam tincidunt mauris eu risus.</li><li>Vestibulum auctor dapibus neque.</li></ul><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>",
       "category": {
            "uniqid": "603539b085b7a",
            "name": "Category 1"
        }
   }
]
```

Ödevin daha iyi anlaşılması için bir örnek senaryosu inceleyelim. Bu senaryonun örnek olduğunu unutmayın, farklı dosya isimleriyle farklı yapılarla da ödevi gerçekleştirebilirsiniz:

- Kullanıcı `index.php` dökümanına istek gönderir. Veritabanındaki ürünler ve ürünlerin kategorileri tablo içerisinde listelenmesi beklenir. Ürünün olmaması durumunda _"Henüz bir ürün eklemediniz"_ uyarısı yer alır. Sayfa içerisinde "İçe Aktar", "Yeni Ürün Ekle" ve "Yeni Kategori Ekle" linkleri bulunur. 
- Kullanıcının "Yeni Kategori Ekle" linkine tıklamasıyla yeni kategori oluşturabileceği forma ulaşır. Bu form içerisinden kategori ismini belirttikten sonra yeni kategorinin **veritabanına** kaydedilmiş olması beklenir.
- Kullanıcının "Yeni Ürün Ekle" linkine tıklamasıyla yeni ürün oluşturabileceği forma ulaşır. Bu form içerisinden ürün ismi, fiyatı, açıklaması,detay metni girmesi ve ilgili kategoriyi seçmesi beklenir. Bu bilgileri gönderdiği durumda yeni ürünün **veritabanına** kaydedilmiş olması istenir.
- Kullanıcı tekrar listelemeye geldiğinde artık "Dışa Aktar" linki ve her ürünün yanında da "Düzenle" ve "Sil" linkleri görüntüler.
- İlgili ürünün "Düzenle" linkine bastığında aynı ekleme formundaki gibi ürünü düzenleyebileceği sayfaya ulaşması beklenir.
- İlgili ürünün "Sil" linkine bastığında ilişkili ürünün silinmesi beklenir.
- "Dışa Aktar" linkine bastığında kullanıcının json dosyası indirmesi sağlanmalıdır. Dışa aktarılan dosya için yukarıda verilen JSON dosya örneğine dikkat edilmelidir. Aynı yapı korunmalıdır.

  PHP ile dosya indirmesi sağlamak için aşağıdaki betiği örnek alabilirsiniz:
  ```php=
  header("Content-Type: application/json");
  header("Content-Disposition: attachment; filename=products.json");
  echo json_encode($products);
  ```
- "İçe Aktar" linkine bastığında kullanıcının dosya yükleyebileceği bir form görüntülenmeli ve bu formu gönderdiğinde ilgili dosyadaki json okunarak senkronizasyon işlemi yapılmalıdır.

  Daha önce eklenmiş ürünler olabileceği için, dosyadaki `uniqid` ile veritabanındaki `uniqid` kontrol edilmelidir. Veritabanında olmaması durumunda eklenmeli, olması durumunda güncellenmelidir. JSON içerisinde `product`'ın altında yer alan `category` için de kontrol işlemi yapılmalı ve aynı kategorilerin tekrar edilmediğinden emin olunmalıdır.
  
> **Not:** Ödevinizi tamamladığınızda, deneme amaçlı, diğer kursiyerlerin oluşturduğu `products.json` dosyalarını içe aktarıp kontrol edebilirsiniz.

> **Karşılaştığınız herhangi bir sorunda Telegram üzerinden veya Discord üzerinden gruba veya bana sorunuzu lütfen iletin.**
