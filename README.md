# PERPUSTAKAAN

Project studi kasus nyata sistem perpustakaan. Mata kuliah Pemrograman Web 2, menggunakan Bahasa pemrograman PHP, library Laravel, dan Database MySQL

## Tugas 1 (Pertemuan 6) : Eksplorasi Database dengan Query (40%)

### Dokumentasi Hasil Query (Screenshot)

#### 1 Statistik Buku (5 Query)

1.1 Total jumlah buku aktif  
![1.1 Total jumlah buku aktif](dokumentasi/1.1.png)

1.2 Total nilai inventaris buku aktif
![1.2 Total nilai inventaris buku aktif](dokumentasi/1.2.png)

1.3 Rata-rata harga buku aktif  
![1.3 Rata-rata harga buku aktif](dokumentasi/1.3.png)

1.4 Buku termahal (judul dan harga)  
![1.4 Buku termahal](dokumentasi/1.4.png)

1.5 Buku dengan stok terbanyak  
![1.5 Buku dengan stok terbanyak](dokumentasi/1.5.png)

#### 2 Filter dan Pencarian (5 Query)

2.1 Buku kategori Programming dengan harga di bawah 100000  
![2.1 Buku kategori Programming dengan harga di bawah 100000](dokumentasi/2.1.png)

2.2 Buku dengan judul mengandung kata PHP atau MySQL  
![2.2 Buku dengan judul mengandung kata PHP atau MySQL](dokumentasi/2.2.png)

2.3 Buku terbit tahun 2024  
![2.3 Buku terbit tahun 2024](dokumentasi/2.3.png)

2.4 Buku dengan stok antara 5 sampai 10  
![2.4 Buku dengan stok antara 5 sampai 10](dokumentasi/2.4.png)

2.5 Buku oleh pengarang Budi Raharjo  
![2.5 Buku oleh pengarang Budi Raharjo](dokumentasi/2.5.png)

#### 3 Grouping dan Agregasi (3 Query)

3.1 Jumlah judul buku dan total stok per kategori  
![3.1 Jumlah judul buku dan total stok per kategori](dokumentasi/3.1.png)

3.2 Rata-rata harga buku per kategori  
![3.2 Rata-rata harga buku per kategori](dokumentasi/3.2.png)

3.3 Kategori dengan total nilai inventaris terbesar  
![3.3 Kategori dengan total nilai inventaris terbesar](dokumentasi/3.3.png)

#### 4 Update Data (2 Query)

4.1 Kenaikan harga buku kategori Programming sebesar 5%  
![4.1 Kenaikan harga buku kategori Programming sebesar 5%](dokumentasi/4.1.png)

4.2 Penambahan stok 10 untuk buku dengan stok kurang dari 5  
![4.2 Penambahan stok 10 untuk buku dengan stok kurang dari 5](dokumentasi/4.2.png)

#### 5 Laporan Khusus (2 Query)

5.1 Daftar buku yang perlu restocking (stok < 5)  
![5.1 Daftar buku yang perlu restocking](dokumentasi/5.1.png)

5.2 5 buku termahal dari buku aktif  
![5.2 5 buku termahal dari buku aktif](dokumentasi/5.2.png)

## Tugas 2 (Pertemuan 6) : Desain Database Lengkap (60%)

### ERD

![ERD](ERD.png)

### Screenshot

#### Struktur semua tabel

1. Tabel anggota
   ![Tabel Anggota](SS_Tugas2_P6/Struktur%20Tabel/anggota.png)

2. Tabel buku  
   ![Tabel Buku](SS_Tugas2_P6/Struktur%20Tabel/buku.png)

3. Tabel kategori_buku
   ![Tabel Kategori](SS_Tugas2_P6/Struktur%20Tabel/kategori_buku.png)

4. Tabel penerbit  
   ![Tabel Penerbit](SS_Tugas2_P6/Struktur%20Tabel/penerbit.png)
5. Tabel transaksi
   ![Tabel transaksi](SS_Tugas2_P6/Struktur%20Tabel/transaksi.png)

#### Data di setiap tabel

1. Data tabel anggota  
   ![Data tabel anggota](SS_Tugas2_P6/Data%20Tabel/anggota.png)

2. Data tabel buku  
   ![Data tabel buku](SS_Tugas2_P6/Data%20Tabel/buku.png)

3. Data tabel kategori_buku  
   ![Data tabel kategori_buku](SS_Tugas2_P6/Data%20Tabel/kategori_buku.png)

4. Data tabel penerbit  
   ![Data tabel penerbit](SS_Tugas2_P6/Data%20Tabel/penerbit.png)

5. Data tabel transaksi  
   ![Data tabel transaksi](SS_Tugas2_P6/Data%20Tabel/transaksi.png)

#### Hasil query JOIN

1. Query JOIN 1
    ![JOIN 1](SS_Tugas2_P6/Hasil%20Query/join_1.png)

2. Query JOIN Jumlah Buku Per Kategori  
  ![Jumlah Buku Per Kategori](SS_Tugas2_P6/Hasil%20Query/jmlBuku_kategori.png)

3. Query JOIN Jumlah Buku Per Penerbit  
  ![Jumlah Buku Per Penerbit](SS_Tugas2_P6/Hasil%20Query/jmlBuku_penerbit.png)

4. Query JOIN Lengkap  
  ![JOIN lengkap](SS_Tugas2_P6/Hasil%20Query/join_lengkap.png)