CREATE TABLE IF NOT EXISTS `tbl_pelanggan` (
  `kode_pelanggan` varchar(5) NOT NULL,
  `nama_pelanggan` varchar(60) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pelanggan`
--

INSERT INTO `tbl_pelanggan` (`kode_pelanggan`, `nama_pelanggan`, `alamat`) VALUES
('P0001', 'Ath Thoriq', 'Jl. Komputer Servis Pangkalpinang'),
('P0002', 'Hendra Kho', 'Desa Kimhin Sungailiat'),
('P0003', 'Ghita Sebrina', 'Gedung Hamidah pangkalpinang');

CREATE TABLE IF NOT EXISTS `tbl_barang` (
  `kode_barang` varchar(5) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga` mediumint(9) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_barang`
--

INSERT INTO `tbl_barang` (`kode_barang`, `nama_barang`, `harga`) VALUES
('B0001', 'Handphone', 5000000);