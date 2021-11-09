	public function rinciansetorkaoscmt($idkode='')
	{
		$viewData['rincian'] = $this->GlobalModel->queryManual('SELECT * FROM produksi_po pp JOIN kelolapo_kirim_setor kks ON pp.kode_po=kks.kode_po WHERE kks.progress="'.'SELESAI'.'" ');

		$this->load->view('global/header');
		$this->load->view('kelolapo/rinciansetor/rincian-setor-view',$viewData);
		$this->load->view('global/footer');
	}