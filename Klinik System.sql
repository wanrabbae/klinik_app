CREATE TABLE `users` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `nama` varchar(255),
  `telepon` varchar(255),
  `email` varchar(255),
  `password` varchar(255),
  `role` ENUM ('Admin', 'Owner', 'Dokter'),
  `alamat` varchar(255),
  `tgl_lahir` datetime,
  `usia` integer,
  `created_at` timestamp DEFAULT NOW(),
  `updated_at` timestamp DEFAULT NOW()
);

CREATE TABLE `transactions` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `nomor_transaksi` varchar(255),
  `tgl_transaksi` datetime DEFAULT NOW(),
  `patient_id` integer,
  `user_id` integer COMMENT 'Dokternya',
  `tindakans` json,
  `created_at` timestamp DEFAULT NOW(),
  `updated_at` timestamp DEFAULT NOW()
);

CREATE TABLE `patients` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `nama_pasien` varchar(255),
  `nomor_rekam_medis` varchar(255),
  `telepon` varchar(255),
  `alamat` varchar(255),
  `tgl_lahir` datetime,
  `usia` integer,
  `created_at` timestamp DEFAULT NOW(),
  `updated_at` timestamp DEFAULT NOW()
);

CREATE TABLE `tindakan` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `nama_tindakan` varchar(255),
  `satuan` varchar(255),
  `jasa_medis` integer,
  `bhp` integer,
  `total_harga` integer,
  `keterangan` varchar(255),
  `created_at` timestamp DEFAULT NOW(),
  `updated_at` timestamp DEFAULT NOW()
);

ALTER TABLE `transactions` ADD FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

ALTER TABLE `transactions` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
