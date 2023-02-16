<?php

namespace App\Controllers;

use App\Database\Migrations\Produk;
use App\Database\Migrations\UserRole;
use \App\Models\UsersModel; // Memanggil User Model Dari Class Model
use \App\Models\UserRoleModel;
use \App\Models\TempPenjualanModel;
use \App\Models\ProdukModel;
use \App\Models\PenjualanModel;
use \App\Models\PenjualanDetailModel;
use \App\Models\MejaModel;
use PhpParser\Node\Expr\Cast\Array_;
use TCPDF;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;

class Penjualan extends BaseController
{


	protected $usersModel; //Membuat Variabel Untuk Menampung UsersModel
	protected $userRole;
	protected $tempPenjualanModel;
	protected $produkModel;
	protected $penjualanModel;
	protected $penjualanDetailModel;
	protected $mejaModel;

	public function __construct()
	{
		//Masukkan Users Model Ke Dalam Variabel
		$this->usersModel = new UsersModel();
		$this->userRole = new UserRoleModel();
		$this->tempPenjualanModel = new TempPenjualanModel();
		$this->produkModel = new ProdukModel();
		$this->penjualanModel = new PenjualanModel();
		$this->penjualanDetailModel = new PenjualanDetailModel();
		$this->mejaModel = new MejaModel();
	}

	public function inputPenjualan()
	{
		//cek status login
		if (!session()->has('logged_in')) {
			session()->setFlashdata('login', 'Silahkan Login Terlebih Dahulu !');
			return redirect()->to(base_url());
		} else {
			if (session()->get('role_id') == 3) {
				return redirect()->to(base_url('koki'));
			} else if (session()->get('role_id') == 5) {
				return redirect()->to(base_url('koki'));
			} else if (session()->get('role_id') == 4) {
				return redirect()->to(base_url('kasir'));
			}
		}

		$meja = $this->mejaModel->where('status_meja', 0)->findAll();

		$data = [
			'title' => 'RestoServe || Input Penjualan',
			'validation' => \Config\Services::validation(),
			'invoice' => $this->buatInvoice(),
			'meja' => $meja
		];

		return view('penjualan/inputPenjualan', $data);
	}

	public function buatInvoice()
	{
		$tanggal = date('Y-m-d');
		$db      = \Config\Database::connect();
		$builder = $db->table('penjualan');
		$builder->selectMax('invoice');
		$builder->where('tanggal', $tanggal);
		$query = $builder->get();
		$hasil = $query->getRowArray();
		$users = $hasil['invoice'];
		// Produces: SELECT MAX(age) as age FROM mytable
		$lastNoUrut = substr($users, -4);

		$next = intval($lastNoUrut) + 1;

		$noinvoice = "TRX" . date('dmy', strtotime($tanggal)) . sprintf('%05s', $next);

		return $noinvoice;
	}

	public function detailPenjualan()
	{
		$invoice = $this->request->getPost('invoice');

		$db      = \Config\Database::connect();
		$builder = $db->table('temp_penjualan');
		$builder->select('temp_penjualan.id as id_penjualan,temp_penjualan.id_produk,harga_produk,kode_produk,nama_produk,jumlah,subtotal');
		$builder->join('produk', 'temp_penjualan.id_produk = produk.id');
		$builder->where('invoice', $invoice);
		$builder->orderBy('temp_penjualan.id', 'asc');
		$query = $builder->get();
		$hasil = $query->getResultArray();

		$data = [
			'detail' => $hasil
		];

		$msg = [
			'data' => view('penjualan/detailPenjualan', $data)
		];

		echo json_encode($msg);
	}

	public function dataProduk()
	{
		//Ambil Data Produk JOIN dengan Kategori Produk
		$db      = \Config\Database::connect();
		$builder = $db->table('produk');
		$builder->select('produk.id,kode_produk,nama_produk,kategori_produk_id,kategori,stok_produk');
		$builder->join('kategori_produk', 'produk.kategori_produk_id = kategori_produk.id');
		$builder->where('stok_produk', 1);
		$query = $builder->get();
		$hasil = $query->getResultArray();
		$data = [
			'produk' => $hasil
		];
		if ($this->request->isAJAX()) {
			//Arahkan Ke View Data Produk
			$msg = [
				'viewmodal' => view('penjualan/dataProduk', $data)
			];
			echo json_encode($msg);
		}
	}

	public function dataProduk2()
	{
		$kodeproduk = $this->request->getVar('kodeproduk');
		$namaproduk = $this->request->getVar('namaproduk');

		//Ambil Data Produk JOIN dengan Kategori Produk
		$db      = \Config\Database::connect();
		$builder = $db->table('produk');
		$builder->select('produk.id,kode_produk,nama_produk,kategori_produk_id,kategori,stok_produk');
		$builder->join('kategori_produk', 'produk.kategori_produk_id = kategori_produk.id');
		$builder->where('stok_produk', 1);
		$builder->like('kode_produk', $kodeproduk);
		$builder->orLike('nama_produk', $kodeproduk);
		$query = $builder->get();
		$hasil = $query->getResultArray();
		$data = [
			'produk' => $hasil
		];
		if ($this->request->isAJAX()) {
			//Arahkan Ke View Data Produk
			$msg = [
				'viewmodal' => view('penjualan/dataProduk', $data)
			];
			echo json_encode($msg);
		}
	}

	public function simpanTemp()
	{
		//Tangkap Data
		$kodeproduk = $this->request->getPost('kodeproduk');
		$namaproduk = $this->request->getPost('namaproduk');
		$jumlah = $this->request->getPost('jumlah');
		$invoice = $this->request->getPost('invoice');
		//Ambil Harga Produknya Dulu
		$infoProduk = $this->produkModel->where(['kode_produk' => $kodeproduk])->first();
		$subtotal = floatval($infoProduk['harga_produk']) * $jumlah;
		//Masukkan Ke Database
		if ($this->tempPenjualanModel->save([
			'invoice' => $invoice,
			'id_produk' => $infoProduk['id'],
			'jumlah' => $jumlah,
			'harga_beli' => $infoProduk['modal_produk'],
			'harga_jual' => $infoProduk['harga_produk'],
			'subtotal' => $subtotal
		])) {
			echo "1";
		}
	}

	public function simpanPenjualan()
	{
		//Ambil Data Ajax
		$waiters  = $this->request->getPost('waiters');
		$invoice = $this->request->getPost('invoice');
		$pelanggan = $this->request->getPost('pelanggan');
		$meja = $this->request->getPost('meja');
		$tipepesanan = $this->request->getPost('tipepesanan');
		$infomeja = $this->mejaModel->where('id', $meja)->first();

		//Jalankan Query SUM untuk jumlah total detailpesanan
		$db      = \Config\Database::connect();
		$builder = $db->table('temp_penjualan');
		$builder->select('SUM(subtotal) as total');
		$builder->where('invoice', $invoice);
		$query = $builder->get();
		$total = $query->getRowArray();

		//Masukkan Ke Database Penjualan
		if ($this->penjualanModel->save([
			'id_meja' => $meja,
			'invoice' => $invoice,
			'tanggal' => date('Y-m-d'),
			'pelanggan' => $pelanggan,
			'total' => $total['total'],
			'waiters' => $waiters,
			'status_pesanan' => 0,
			'status_pembayaran' => 0,
			'tipe_pesanan' => $tipepesanan
		])) {
			// 	//Kalau Berhasil
			// 	//Masukkan Ke Database Penjualan Detail Dari Tabel Temp
			$db      = \Config\Database::connect();
			$builder = $db->table('temp_penjualan');
			$builder->where('invoice', $invoice);
			$query = $builder->get();
			$isiTempPenjualan = $query->getResultArray();

			$DetailPenjualan = [];
			foreach ($isiTempPenjualan as $row) {
				$DetailPenjualan[] = [
					'invoice' => $row['invoice'],
					'id_produk' => $row['id_produk'],
					'harga_beli' => $row['harga_beli'],
					'harga_jual' => $row['harga_jual'],
					'jumlah' => $row['jumlah'],
					'subtotal' => $row['subtotal'],
					'status_menu' => 0
				];
			}
			$db      = \Config\Database::connect();
			$builder = $db->table('penjualan_detail');
			$builder->insertBatch($DetailPenjualan);

			//Ubah Data Meja
			if ($infomeja['nomor_meja'] != 0) {
				$this->mejaModel->save([
					'id' => $meja,
					'status_meja' => 1
				]);
			}

			//Hapus Temp
			$db      = \Config\Database::connect();
			$builder = $db->table('temp_penjualan');
			$builder->emptyTable();

			//Masukkan Data Penjualan Ke Session Untuk Di Cetak Ke Struk
			// $dataPenjualan = [
			// 	'invoice' => $invoice,
			// 	'pelanggan' => $pelanggan,
			// 	'kasir' => $kasir,
			// 	'total' => $total,
			// 	'jumlah_uang' => $jumlahUang,
			// 	'sisa_uang' => $sisaUang
			// ];
			// session()->set($dataPenjualan);
		}
		echo '1';
	}

	public function tampilTotalBayar()
	{

		if ($this->request->isAJAX()) {
			//Kalau ada request dari ajax
			//Tangkap Data Yang Dikirim Ajax
			$invoice = $this->request->getPost('invoice');

			//Jalankan Query SUM untuk jumlah total detailpesanan
			$db      = \Config\Database::connect();
			$builder = $db->table('temp_penjualan');
			$builder->select('SUM(subtotal) as totalbayar');
			$builder->where('invoice', $invoice);
			$query = $builder->get();
			$hasil = $query->getRowArray();

			$msg = [
				'totalbayar' => number_format($hasil['totalbayar'], 0, ",", ".")
			];
			echo json_encode($msg);
		}
	}

	public function hapusItem()
	{

		if ($this->request->isAJAX()) {
			//Kalau Ada Request Ajax
			//Tangkap Data Dikirim Ajax
			$id = $this->request->getPost('id');

			//Hapus Data Produk Berdasarkan ID 
			if ($this->tempPenjualanModel->delete($id)) {
				echo "sukses";
			}
		}
	}

	public function simpanPembayaran()
	{

		//Tangkap Data nya
		$id = $this->request->getPost('id');
		$idmeja = $this->request->getPost('idmeja');
		$invoice = $this->request->getPost('invoice');
		$pelanggan = $this->request->getPost('pelanggan');
		$kasir = $this->request->getPost('kasir');
		$total =  str_replace(",", "", $this->request->getPost('total_pembayaran'));
		$jumlahUang =  str_replace(",", "", $this->request->getPost('jumlah_uang'));
		$sisaUang =  str_replace(",", "", $this->request->getPost('sisa_uang'));



		//Masukkan Ke Database Penjualan
		if ($this->penjualanModel->save([
			'id' => $id,
			'status_pembayaran' => 1
		])) {
			//Masukkan Data Penjualan Ke Session Untuk Di Cetak Ke Struk
			$dataPenjualan = [
				'invoice' => $invoice,
				'pelanggan' => $pelanggan,
				'kasir' => $kasir,
				'total' => $total,
				'jumlah_uang' => $jumlahUang,
				'sisa_uang' => $sisaUang
			];
			session()->set($dataPenjualan);

			//Ubah Data Meja
			$this->mejaModel->save([
				'id' => $idmeja,
				'status_meja' => 0
			]);

			echo 'berhasil';
		}
	}

	// public function hapusPenjualan($id)
	// {

	// 	$dataPenjualan = $this->penjualanModel->where(['id' => $id])->first();
	// 	//Hapus Data Yang Ada Di Tabel Penjualan
	// 	$this->penjualanModel->delete($id);
	// 	//Hapus Data Yang Ada Di Tabel Detail Penjualan Berdasarkan Invoice Dari Id yang dipilih
	// 	$db      = \Config\Database::connect();
	// 	$builder = $db->table('penjualan_detail');
	// 	$builder->delete(['invoice' => $dataPenjualan['invoice']]);

	// 	return redirect()->to(base_url('penjualan/dataPenjualan'));
	// }

	// public function print()
	// {
	// 	//Ambil Data Dari Session

	// 	$data = [
	// 		'invoice' => session()->get('invoice'),
	// 		'kasir' => session()->get('kasir'),
	// 		'pelanggan' => session()->get('pelanggan'),
	// 		'total' => session()->get('total'),
	// 		'jumlah_uang' => session()->get('jumlah_uang'),
	// 		'sisa_uang' => session()->get('sisa_uang')
	// 	];
	// 	return view('penjualan/print', $data);
	// }



	public function dataPenjualan()
	{
		//cek status login
		if (!session()->has('logged_in')) {
			session()->setFlashdata('login', 'Silahkan Login Terlebih Dahulu !');
			return redirect()->to(base_url());
		} else {
			if (session()->get('role_id') == 3) {
				return redirect()->to(base_url('koki'));
			} else if (session()->get('role_id') == 5) {
				return redirect()->to(base_url('koki'));
			} else if (session()->get('role_id') == 4) {
				return redirect()->to(base_url('kasir'));
			} else if (session()->get('role_id') == 2) {
				return redirect()->to(base_url('pelayan'));
			}
		}

		//Ambil Data Penjualan
		$dataPenjualan = $this->penjualanModel->findAll();
		$data = [
			'title' => 'RestoServe || Data Penjualan',
			'dataPenjualan' => $dataPenjualan
		];

		return view('penjualan/dataPenjualan', $data);
	}
	public function laporanPenjualan()
	{

		//Ambil Data Tanggal Cetak
		$tanggalAwal = $this->request->getVar('tanggal_awal');
		$tanggalAkhir = $this->request->getVar('tanggal_akhir');

		$db      = \Config\Database::connect();
		$builder = $db->table('penjualan');
		$builder->where('tanggal >=', $tanggalAwal);
		$builder->where('tanggal <=', $tanggalAkhir);
		$builder->where('status_pembayaran', 1);
		$query = $builder->get();
		$laporanPenjualan = $query->getResultArray();

		//Menghitung Total Penjualan Pada Tanggal Tersebut
		$db      = \Config\Database::connect();
		$builder = $db->table('penjualan');
		$builder->select('SUM(total) as totalpenjualan');
		$builder->where('tanggal >=', $tanggalAwal);
		$builder->where('tanggal <=', $tanggalAkhir);
		$builder->where('status_pembayaran', 1);
		$query = $builder->get();
		$hasil = $query->getRowArray();
		$totalPenjualan = $hasil['totalpenjualan'];


		if ($laporanPenjualan) {

			//Jika ada datanya maka cetak pdf nya
			$data = [
				'laporan' => $laporanPenjualan,
				'tanggalawal' => $tanggalAwal,
				'tanggalakhir' => $tanggalAkhir,
				'total_penjualan' => $totalPenjualan
			];
			$html = view('penjualan/laporanPenjualan', $data);

			//$pdf = new TCPDF('P', 'mm', array('58', '30'), true, 'UTF-8', false);
			//$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			//Informasi Dokumen
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Aqil Mustaqim');
			$pdf->SetTitle('Laporan Penjualan');
			$pdf->SetSubject('Laporan Penjualan');

			//Header Dan Footer Data
			//$pdf->setHeaderData('/assets/images/1.jpg', 1, 'PosCafe', 'JL. Gaperta No 433', array(48, 89, 112), array(48, 89, 112));
			//$pdf->setFooterData(array(0, 0, 0), array(0, 0, 0));
			//$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			//$pdf->setFooterFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);

			//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			//Set Margin
			//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			//$pdf->setFooterMargin(PDF_MARGIN_FOOTER);

			//Baris Baru
			//$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

			//Set Scaling Image
			//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			//Font Subsetting
			//$pdf->setFontSubsetting(true);

			//Font Utama
			//$pdf->SetFont('helvetica', '', 12, '', true);

			$pdf->addPage();

			// output the HTML content
			//$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

			$pdf->writeHTML($html, true, false, true, false, '');
			//$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
			//$pdf->writeHTML($html, true, false, true, false, '');
			//line ini penting
			$this->response->setContentType('application/pdf');
			//Close and output PDF document
			$pdf->Output('laporan-penjualan.pdf', 'D');
		} else {
			//Jika data nya gak ada kirimkan pesan kosong
			echo "kosong";
		}
	}

	// public function laporanPengeluaran()
	// {

	// 	//Jika ada datanya maka cetak pdf nya
	// 	$data = [];
	// 	$html = view('penjualan/laporanPengeluaran');

	// 	//$pdf = new TCPDF('P', 'mm', array('58', '30'), true, 'UTF-8', false);
	// 	//$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

	// 	//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	// 	//Informasi Dokumen
	// 	// $pdf->SetCreator(PDF_CREATOR);
	// 	// $pdf->SetAuthor('Aqil Mustaqim');
	// 	// $pdf->SetTitle('Laporan Penjualan');
	// 	// $pdf->SetSubject('Laporan Penjualan');

	// 	//Header Dan Footer Data
	// 	//$pdf->setHeaderData('/assets/images/1.jpg', 1, 'PosCafe', 'JL. Gaperta No 433', array(48, 89, 112), array(48, 89, 112));
	// 	//$pdf->setFooterData(array(0, 0, 0), array(0, 0, 0));
	// 	//$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	// 	//$pdf->setFooterFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	// 	// $pdf->setPrintHeader(false);
	// 	// $pdf->setPrintFooter(false);

	// 	//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// 	//Set Margin
	// 	//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	// 	//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	// 	//$pdf->setFooterMargin(PDF_MARGIN_FOOTER);

	// 	//Baris Baru
	// 	//$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

	// 	//Set Scaling Image
	// 	//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// 	//Font Subsetting
	// 	//$pdf->setFontSubsetting(true);

	// 	//Font Utama
	// 	//$pdf->SetFont('helvetica', '', 12, '', true);

	// 	//$pdf->addPage();

	// 	// output the HTML content
	// 	//$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

	// 	//$pdf->writeHTML($html, true, false, true, false, '');
	// 	//$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
	// 	//$pdf->writeHTML($html, true, false, true, false, '');
	// 	//line ini penting
	// 	$this->response->setContentType('application/pdf');
	// 	//Close and output PDF document
	// 	//$pdf->Output('LaporanPengeluaran.pdf', 'I');
	// }

	public function struk()
	{
		//Ambil Data Dari Ajaxx
		$invoice = $this->request->getPost('invoice');
		//$pelanggan = $this->request->getPost('pelanggan');
		$kasir = $this->request->getPost('kasir');
		$total =  str_replace(",", "", $this->request->getPost('totalPembayaran'));
		$jumlahUang =  str_replace(",", "", $this->request->getPost('jumlahUang'));
		$sisaUang =  str_replace(",", "", $this->request->getPost('sisaUang'));

		//$logo = EscposImage::load("example/resources/escpos-php.png", false);
		$profile = CapabilityProfile::load("simple");
		$connector = new WindowsPrintConnector("POS-58C");

		$printer = new Printer($connector, $profile);

		// membuat fungsi untuk membuat 1 baris tabel, agar dapat dipanggil berkali-kali dgn mudah
		function buatBaris4Kolom($kolom1, $kolom2, $kolom3)
		{
			// Mengatur lebar setiap kolom (dalam satuan karakter)
			$lebar_kolom_1 = 14;
			$lebar_kolom_2 = 8;
			$lebar_kolom_3 = 8;

			// Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
			$kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
			$kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);
			$kolom3 = wordwrap($kolom3, $lebar_kolom_3, "\n", true);

			// Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
			$kolom1Array = explode("\n", $kolom1);
			$kolom2Array = explode("\n", $kolom2);
			$kolom3Array = explode("\n", $kolom3);

			// Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
			$jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array), count($kolom3Array),);

			// Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
			$hasilBaris = array();

			// Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
			for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

				// memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
				$hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
				$hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ");

				// memberikan rata kanan pada kolom 3 dan 4 karena akan kita gunakan untuk harga dan total harga
				$hasilKolom3 = str_pad((isset($kolom3Array[$i]) ? $kolom3Array[$i] : ""), $lebar_kolom_3, " ", STR_PAD_LEFT);
				//$hasilKolom4 = str_pad((isset($kolom4Array[$i]) ? $kolom4Array[$i] : ""), $lebar_kolom_4, " ", STR_PAD_LEFT);

				// Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
				$hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2 . " " . $hasilKolom3;
			}

			// Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
			return implode("\n", $hasilBaris) . "\n";
		}

		//Query Mengambil Data Detail
		$db      = \Config\Database::connect();
		$builder = $db->table('penjualan_detail');
		$builder->select('penjualan_detail.invoice,id_produk,nama_produk,harga_jual,jumlah,subtotal');
		$builder->join('produk', 'penjualan_detail.id_produk = produk.id');
		$builder->where('invoice', $invoice);
		$query = $builder->get();
		$hasil = $query->getResultArray();

		//Query Mengambil Data Penjualan Invoice
		$penjualan = $this->penjualanModel->where(['invoice' => $invoice])->first();
		$tipepesanan = "";

		if ($penjualan['tipe_pesanan'] == 1) {
			$tipepesanan .= "Dine In";
		} else {
			$tipepesanan .= "Take Away";
		}



		//Membuat Logo
		// $logo = EscposImage::load("/resources/3.jpg", false);
		//$printer->text("These example images are printed with the older\nbit image print command. You should only use\n\$p -> bitImage() if \$p -> graphics() does not\nwork on your printer.\n\n");
		//$printer->bitImage($logo);

		// Membuat judul
		$printer->initialize();
		$printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT); // Setting teks menjadi lebih besar
		$printer->setJustification(Printer::JUSTIFY_CENTER); // Setting teks menjadi rata tengah
		$printer->setFont(Printer::FONT_B);
		$printer->setTextSize(2, 2);
		$printer->text("Mie Aceh TitiBobrok\n");

		$printer->initialize();
		$printer->setJustification(Printer::JUSTIFY_CENTER); // Setting teks menjadi rata tengah

		$printer->text("Jl Setia Budi No.51 Medan\n");
		$printer->text("--------------------------------");
		$printer->text("\n");

		// Data transaksi
		$printer->initialize();
		$printer->text("Invoice : $invoice\n");
		$printer->text("Pesanan : $tipepesanan\n");
		$printer->text("Kasir : $kasir\n");
		$printer->text("Waktu : " . date('Y-m-d : H:i:s') . "\n");

		// Membuat tabel
		$printer->initialize(); // Reset bentuk/jenis teks
		$printer->text("--------------------------------\n");
		$printer->text(buatBaris4Kolom("Produk", "Harga", "Subtotal"));
		$printer->text("--------------------------------\n");
		foreach ($hasil as $h) {
			$printer->text(buatBaris4Kolom($h['jumlah'] . 'x ' . $h['nama_produk'], number_format($h['harga_jual'], 0), number_format($h['subtotal'], 0)));
		}
		//$printer->text(buatBaris4Kolom("2x Kopi", "15.000", "30.000"));
		$printer->text("--------------------------------\n");
		$printer->text(buatBaris4Kolom('', "Total", number_format($total, 0)));
		$printer->text(buatBaris4Kolom('', "Bayar", number_format($jumlahUang, 0)));
		$printer->text(buatBaris4Kolom('', "Kembali", number_format($sisaUang, 0)));
		$printer->text("--------------------------------\n");
		// Pesan penutup
		$printer->initialize();
		$printer->setJustification(Printer::JUSTIFY_CENTER);
		$printer->text("Terima kasih telah berkunjung\n");

		$printer->feed(4); // mencetak 5 baris kosong agar terangkat (pemotong kertas saya memiliki jarak 5 baris dari toner)
		$printer->close();
		echo "Berhasil Mencetak Struk";
		/* mulai cetak */
		// $printer->setJustification(Printer::JUSTIFY_CENTER);
		// $printer->text("UD. KANAMART \n");
		// $printer->text("JL. WARUNG WINGIN NO. 9\n");
		// $printer->text("-----------------------------\n");
		// $printer->text("KASIR : AYU SEPTIANI|" . date('Y:m:d h:i:s') . " \n");
		// $printer->text("NO TRANSAKSI : 0009912220191122 \n");
		// $printer->text("-----------------------------\n");

		// /* buat perulangan data transaksi */

		// $printer->setJustification(Printer::JUSTIFY_LEFT);
		// $printer->text("Produk  \n");
		// $printer->setJustification(Printer::JUSTIFY_RIGHT);
		// $printer->text("jumlah barang x harga \n");

		// /* bagian footer */
		// $printer->setJustification(Printer::JUSTIFY_RIGHT);
		// $printer->text("-----------------------------\n");
		// $printer->text("TOTAL BELANJA : xxxxxxxx \n");
		// $printer->text("POTONGAN BELANJA : xxxxxxxx \n");
		// $printer->text("TUNAI : xxxxxxxx \n");
		// $printer->text("KEMBALI : xxxxxxxx \n");
		// $printer->setJustification(Printer::JUSTIFY_CENTER);
		// $printer->text("-----------------------------\n");
		// $printer->text("TERIMA KASIH \n");
		// $printer->text("Ada Diskon pembelian setiap akhir pekan \n");
		// $printer->text(" \n");
		// $printer->text(" \n");
		// $printer->text(" \n");

		// //potong kertas
		// $printer->cut();

		// /* Close printer */
		// $printer->close();
	}
}
