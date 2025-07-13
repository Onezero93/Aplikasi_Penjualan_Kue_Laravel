-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Jul 2025 pada 15.38
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pemesanan_kue`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `keranjang`
--

INSERT INTO `keranjang` (`id_keranjang`, `user_id`, `produk_id`, `jumlah`) VALUES
(1, 34, 2, 1),
(2, 34, 3, 1),
(3, 34, 4, 1),
(6, 31, 3, 1),
(7, 31, 4, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pemesanan` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `tanggal_ambil` date NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `metode_pembayaran` enum('DP','Lunas') NOT NULL,
  `jenis_pembayaran` enum('Transfer','Tunai') NOT NULL,
  `nominal_dp` int(11) DEFAULT NULL,
  `sisa_pembayaran` int(11) DEFAULT NULL,
  `bukti_transfer` varchar(255) NOT NULL,
  `bukti_pelunasan` varchar(255) DEFAULT NULL,
  `status` enum('pending','setuju','batal') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemesanan`
--

INSERT INTO `pemesanan` (`id_pemesanan`, `user_id`, `produk_id`, `tanggal_ambil`, `jumlah`, `total_harga`, `metode_pembayaran`, `jenis_pembayaran`, `nominal_dp`, `sisa_pembayaran`, `bukti_transfer`, `bukti_pelunasan`, `status`, `created_at`, `updated_at`) VALUES
(5, 31, 6, '2025-06-27', 5, 10000, 'Lunas', 'Transfer', 3000, 0, 'bukti_transfer/s0l6bHriC4inu4ALEAYtIp9xs2YgWc98ZFWA0sWD.jpg', 'bukti_pelunasan/zaTmwQpk9M6vxyNpxjIGAdOvLRWqa3NaYpOTXOqP.png', 'setuju', '2025-06-20 07:12:03', '2025-06-23 09:07:17'),
(6, 31, 6, '2025-06-27', 6, 12000, 'Lunas', 'Transfer', 0, 0, 'bukti_transfer/enjS2KiGll8rbYDI0MwdXzDw0KJCoyz7YtxvQvR7.jpg', 'bukti_pelunasan/NTUH2DCCGl2D2xEdPH09vqDz3QqrdikjSurERxZF.jpg', 'setuju', '2025-06-20 07:22:10', '2025-06-23 09:09:44'),
(7, 31, 6, '2025-06-26', 5, 10000, 'DP', 'Tunai', 5000, 5000, 'bukti_transfer/oUlg7sbJ1CQZfSdsCvtaVTWaAly7BdWneFW8QFyh.jpg', '', 'setuju', '2025-06-20 07:27:15', '2025-06-21 08:43:15'),
(10, 31, 2, '2025-06-29', 15, 37500, 'DP', 'Transfer', 18750, 18750, 'bukti_transfer/xUbYHzN4FpOGlxGns9CZRX9VspF3w0vNxqz3fMe8.jpg', '', 'setuju', '2025-06-20 21:21:39', '2025-06-21 08:30:46'),
(15, 34, 4, '2025-06-24', 6, 15000, 'Lunas', 'Tunai', NULL, NULL, 'bukti_transfer/ltB58MUA2jkpXnZVNohkIDyr8Br9OsBRgR2SZ1JS.png', NULL, 'setuju', '2025-06-24 00:29:16', '2025-06-24 00:30:56'),
(16, 34, 6, '2025-06-30', 4, 8000, 'Lunas', 'Transfer', 0, 0, 'bukti_transfer/493EnV9ijkE2x2c3LjuJdErJH5kYddFlMDPbHvNA.jpg', 'bukti_pelunasan/jKZuJ44LrgARxhFNvfW4l1W3wmRtAtSb3i02HqJH.jpg', 'setuju', '2025-06-24 00:33:16', '2025-06-24 00:34:34'),
(18, 31, 3, '2025-06-30', 5, 15000, 'Lunas', 'Tunai', NULL, NULL, 'bukti_transfer/VOqL2IKWfMeVWbCCYOYCy3txySQvKCDyVBIdLFpm.jpg', NULL, 'setuju', '2025-06-24 03:03:25', '2025-06-25 10:07:05'),
(19, 31, 3, '2025-06-26', 4, 12000, 'Lunas', 'Tunai', NULL, NULL, 'bukti_transfer/MmJWgGj0EqrtppVQ4HhqqpiJYlgxSuj1sr2penMP.png', NULL, 'setuju', '2025-06-25 10:47:52', '2025-06-25 10:50:28'),
(20, 31, 3, '2025-06-26', 4, 12000, 'Lunas', 'Tunai', 0, 0, 'bukti_transfer/EVuHK34bHPxOxKmKTYA097ERAbLIFUUFjADi1K4Z.jpg', 'bukti_pelunasan/0SDhFGNEubdxsDxRxFY7S2IO16k1XqO388qmwECz.png', 'setuju', '2025-06-25 10:49:00', '2025-06-25 10:52:17'),
(21, 35, 2, '2025-06-19', 23, 57500, 'Lunas', 'Tunai', NULL, NULL, 'bukti_transfer/t41QMPa1PzXN3mYlwAwIuDQEC7Ip6OwaUBGzyoJu.png', NULL, 'setuju', '2025-06-25 21:37:38', '2025-06-25 21:38:17'),
(22, 36, 3, '2025-06-19', 25, 75000, 'Lunas', 'Tunai', NULL, NULL, 'bukti_transfer/2MBWemdAcCuUECqF5CSuevVTsvo3xrHU8FisKfwX.png', NULL, 'setuju', '2025-06-25 21:45:45', '2025-06-25 21:46:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `stok` int(100) NOT NULL,
  `kategori` enum('basah','kering','','') NOT NULL,
  `foto_produk` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `harga`, `stok`, `kategori`, `foto_produk`) VALUES
(2, 'Grim Mawar', '2500', 1200, 'kering', 'fotosproduk/1750174272_6237573170416699767.jpg'),
(3, 'Cinammond Roll', '3000', 0, 'basah', 'fotosproduk/1750174331_6237573170416699768.jpg'),
(4, 'Potato Bread', '2500', 0, 'basah', 'fotosproduk/1750174417_6237573170416699764.jpg'),
(5, 'Abon\'s Roll Bread (Abon Ayam)', '2500', 0, 'basah', 'fotosproduk/1750174485_6237573170416699766.jpg'),
(6, 'Pastry Griim', '2000', 0, 'kering', 'fotosproduk/1750174532_6237573170416699765.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `namalengkap` varchar(50) NOT NULL,
  `username` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `alamat` text NOT NULL,
  `nomortelepon` varchar(225) NOT NULL,
  `gambar` varchar(225) DEFAULT NULL,
  `status` enum('admin','pelanggan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `namalengkap`, `username`, `password`, `alamat`, `nomortelepon`, `gambar`, `status`) VALUES
(6, 'Anugerah', 'Anugerah', '$2y$12$k2Inf4sizc35kmQvyQJG6.l3G79sR8K3ayY1gePt2xMHHWqyj98.K', 'eqweweqwe', '626281917716274', 'fotos/1751210745.png', 'admin'),
(31, 'yudi', 'yudi', '$2y$12$cYdx9kUUTwHjDSJtGeacYeAElxfddykZQ1m9sYVKMSR4HBiLD2hKq', 'fgjjfjhjghj', '6281339062645', 'fotos/1751198625.png', 'pelanggan'),
(34, 'Arik Wagiyanto', 'arik', '$2y$12$uhB6PgLM8LE87lWE6fwvMOzKhFDyBeb1TwQBxv9Hj.ickg68nfJsO', 'sfsfsdf', '6285871927707', 'fotos/1750743293_logo-removebg-preview.png', 'pelanggan'),
(35, 'den', 'lana', '$2y$12$aYfQ1xvH7o8V1/ClgsMwmeNDHo28zCn1wvnJpzMhtmTWyxly7O/WW', 'Alamat belum di isi', '6282247173904', 'fotos/1750912582_mysql.png', 'pelanggan'),
(36, 'lutfi', 'lutfi', '$2y$12$szJEIIZvYriAtxW.cDw63.enhFbVa3cLrzUDDwcDU0MAMGrAa6Wn6', 'sxdcfgvbhnjm', '6282228565553', 'fotos/1750912899_tr.jpg', 'pelanggan');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indeks untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pemesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `keranjang_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id_produk`);

--
-- Ketidakleluasaan untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `pemesanan_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id_produk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
