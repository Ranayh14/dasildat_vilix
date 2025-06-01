# Prediksi Harga Apartemen

Aplikasi web untuk memprediksi harga apartemen menggunakan machine learning.

## Fitur

- Prediksi harga apartemen menggunakan 3 model machine learning:
  - Decision Tree
  - Random Forest
  - K-Nearest Neighbor (KNN)
- Input manual melalui form
- Upload file CSV untuk prediksi batch
- History prediksi
- Visualisasi perbandingan performa model

## Persyaratan Sistem

- PHP 7.4 atau lebih tinggi
- Python 3.8 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Web server (Apache/Nginx) atau PHP built-in server

## Package Python yang Diperlukan

```
numpy==1.24.3
pandas==2.0.3
scikit-learn==1.3.0
joblib==1.3.2
```

## Instalasi

1. Clone repository:
```bash
git clone https://github.com/username/dasildat_vilix.git
cd dasildat_vilix
```

2. Install package Python:
```bash
pip install -r requirements.txt
```

3. Buat database MySQL:
```sql
CREATE DATABASE apartment_prediction;
```

4. Import schema database:
```bash
mysql -u root -p apartment_prediction < database/schema.sql
```

5. Konfigurasi database:
- Edit file `config/database.php`
- Sesuaikan host, username, dan password database

6. Jalankan aplikasi:
```bash
php -S localhost:8000
```

7. Buka browser dan akses:
```
http://localhost:8000
```

## Struktur Project

```
dasildat_vilix/
├── config/
│   └── database.php
├── database/
│   └── schema.sql
├── model/
│   ├── Apart_Price_Prediction_DT.sav
│   ├── Apart_Price_Prediction_RF.sav
│   └── Apart_Price_Prediction_KNN.sav
├── uploads/
├── index.php
├── history.php
├── predict.py
├── requirements.txt
└── README.md
```

## Penggunaan

1. Prediksi Manual:
   - Isi form dengan data apartemen
   - Pilih model prediksi
   - Klik "Prediksi Harga"

2. Prediksi dari CSV:
   - Upload file CSV dengan format yang sesuai
   - Pilih model prediksi
   - Klik "Prediksi Harga"

3. Lihat History:
   - Klik "Lihat History & Perbandingan Model"
   - Lihat grafik perbandingan model
   - Lihat history prediksi

## Format CSV

File CSV harus memiliki kolom berikut:
- Minutes to metro
- Area
- Living area
- Kitchen area
- Floor
- Number of floors
- Number of rooms
- Apartment type (New building/Secondary)
- Renovation (yes/no)

## Lisensi

MIT License 