<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $title ?>
            <small><?= $subtitle ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <button class="btn btn-primary" data-toggle="modal" data-target="#tambahData">
                    <div class="fa fa-plus"></div> Tambah Data
                </button>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="dataTable">
                        <thead>
                            <tr>
                                <th width="10px">#</th>
                                <th>Kegiatan</th>
                                <th>Nama Peminjam</th>
                                <th>Asal Instansi</th>
                                <th>User</th>
                                <th>Tanggal</th>
                                <th>Dari Jam</th>
                                <th>Sampai Jam</th>
                                <th>Agenda</th>
                                <th>Barang</th>
                                <th>Surat</th>
                                <th>File</th>
                                <th>Status</th>
                                <th>Terdaftar</th>
                                <?php if ($this->session->userdata('level') == 'Administrator') { ?>
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($booking_kegiatan->result_array() as $row) {
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <?php
                                        $this->db->where('id', $row['idKegiatan']);
                                        foreach ($this->m_model->get_desc('tb_kegiatan')->result() as $vRg) {
                                            echo $vRg->nama;
                                        }
                                        ?>
                                    </td>
                                    <td><?= $row['peminjam'] ?></td>
                                    <td>
                                        <?php
                                        $this->db->where('id', $row['idInstansi']);
                                        foreach ($this->m_model->get_desc('tb_instansi')->result() as $vRg) {
                                            echo $vRg->nama;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $this->db->where('id', $row['idUser']);
                                        foreach ($this->m_model->get_desc('tb_user')->result() as $vUsr) {
                                            echo $vUsr->nama;
                                        }
                                        ?>
                                    </td>
                                    <td><?= date('d F Y', strtotime($row['tanggal'])) ?></td>
                                    <td><?= date('H:i', strtotime($row['dariJam'])) ?></td>
                                    <td><?= date('H:i', strtotime($row['sampaiJam'])) ?></td>
                                    <td><?= $row['agenda'] ?></td>
                                    <td>
                                        <?php
                                        $this->db->where('id', $row['idBarang']);
                                        foreach ($this->m_model->get_desc('tb_barang')->result() as $vBr) {
                                            echo $vBr->nama;
                                        }
                                        ?>
                                    </td>
                                    <td><?= $row['surat'] ?></td>
                                    <td>
                                        <?= $row['file'] ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($row['status'] == 'Diterima') {
                                            echo '<label class="label label-success">' . $row['status'] . '</label>';
                                        } elseif ($row['status'] == 'Ditolak') {
                                            echo '<label class="label label-danger">' . $row['status'] . '</label>';
                                        } else {
                                            echo '<label class="label label-primary">' . $row['status'] . '</label>';
                                        }
                                        ?>
                                    </td>
                                    <td><?= date('d F Y H:i:s', strtotime($row['terdaftar'])) ?></td>
                                    <td>
                                        <?php if ($this->session->userdata('level') == 'Administrator') { ?>
                                            <?php if ($row['status'] == 'Menunggu') { ?>
                                                <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#responData<?= $row['id'] ?>">
                                                    <div class="fa fa-pencil"></div> Respon
                                                </button>
                                            <?php } ?>
                                            <?php if ($row['status'] == 'Menunggu') { ?>
                                                <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editData<?= $row['id'] ?>">
                                                    <div class="fa fa-edit"></div> Edit
                                                </button>
                                                <a href="<?= base_url('admin/booking_kegiatan/delete/') . $row['id'] ?>" class="btn btn-danger btn-xs tombol-yakin" data-isidata="Account tidak bisa dipulihkan setelah dihapus">
                                                    <div class="fa fa-trash"></div> Delete
                                                </a>
                                                <!-- <a href="" class="btn btn-primary btn-xs" data-isidata="Surat Tidak Tersedia">
                                                    <div class="fa fa-eye"></div> Download Surat
                                                </a> -->
                                                <a href="<?php echo base_url('admin/booking_kegiatan/view_pdf/') . $row['file']; ?>" target="_blank" class="btn btn-primary btn-xs" data-isidata="Surat Tidak Tersedia">
                                                    <div class="fa fa-eye"></div> Lihat Surat
                                                </a>

                                            <?php } ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Tambah <?= $title; ?></h4>
            </div>
            <?php echo form_open_multipart('admin/booking_kegiatan/insert'); ?>
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
            <div class="modal-body">
                <div class="form-group">
                    <label>Kegiatan</label>
                    <select name="idKegiatan" class="select2" required style="width: 100%">
                        <option value="" selected disabled>-- Pilih Kegiatan --</option>
                        <?php foreach ($kegiatan->result() as $vRg) { ?>
                            <option value="<?= $vRg->id ?>"><?= $vRg->nama ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nama Peminjam</label>
                    <input type="text" name="peminjam" class="form-control" placeholder="Nama Peminjam" required>
                </div>
                <div class="form-group">
                    <label>Asal Instansi</label>
                    <select name="idInstansi" class="select2" required style="width: 100%">
                        <option value="" selected disabled>-- Pilih Instansi --</option>
                        <?php foreach ($instansi->result() as $vRg) { ?>
                            <option value="<?= $vRg->id ?>"><?= $vRg->nama ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Dari Jam</label>
                            <input type="time" name="dariJam" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sampai Jam</label>
                            <input type="time" name="sampaiJam" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Agenda</label>
                    <input type="text" name="agenda" class="form-control" placeholder="Agenda" required>
                </div>
                <div class="form-group">
                    <label>Barang</label>
                    <select name="idBarang" class="select2" required style="width: 100%">
                        <option value="" selected disabled>-- Pilih Barang --</option>
                        <?php foreach ($barang->result() as $vBr) { ?>
                            <option value="<?= $vBr->id ?>"><?= $vBr->nama ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Surat</label>
                    <select type="text" name="surat" class="select2" required style="width: 100%">
                        <option value="">-- Pilih Ada / Tidak Ada --</option>
                        <option value="Ada">Ada</option>
                        <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Upload Surat</label>
                    <input type="file" name="file" class="form-control" placeholder="File" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-danger">
                    <div class="fa fa-trash"></div> Reset
                </button>
                <button type="submit" class="btn btn-primary">
                    <div class="fa fa-save"></div> Save
                </button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
<?php foreach ($booking_kegiatan->result() as $edit) { ?>
    <div class="modal fade" id="editData<?= $edit->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit <?= $title; ?></h4>
                </div>
                <form action="<?= base_url('admin/booking_kegiatan/update/') . $edit->id ?>" method="POST">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kegiatan</label>
                            <select name="idKegiatan" class="select2" required style="width: 100%">
                                <?php
                                $this->db->where('id', $edit->idKegiatan);
                                foreach ($this->m_model->get_desc('tb_kegiatan')->result() as $uRg) { ?>
                                    <option value="<?= $uRg->id ?>"><?= $uRg->nama ?></option>
                                <?php } ?>
                                <option value="" disabled>-- Pilih Kegiatan --</option>
                                <?php foreach ($kegiatan->result() as $vRg) { ?>
                                    <option value="<?= $vRg->id ?>"><?= $vRg->nama ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nama Peminjam</label>
                            <input type="text" name="peminjam" class="form-control" placeholder="Nama Peminjam" value="<?= $edit->peminjam ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Asal Instansi</label>
                            <select name="idInstansi" class="select2" required style="width: 100%">
                                <?php
                                $this->db->where('id', $edit->idInstansi);
                                foreach ($this->m_model->get_desc('tb_instansi')->result() as $uRg) { ?>
                                    <option value="<?= $uRg->id ?>"><?= $uRg->nama ?></option>
                                <?php } ?>
                                <option value="" disabled>-- Pilih Instansi --</option>
                                <?php foreach ($instansi->result() as $vRg) { ?>
                                    <option value="<?= $vRg->id ?>"><?= $vRg->nama ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="<?= $edit->tanggal ?>" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Dari Jam</label>
                                    <input type="time" name="dariJam" class="form-control" value="<?= $edit->dariJam ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sampai Jam</label>
                                    <input type="time" name="sampaiJam" class="form-control" value="<?= $edit->sampaiJam ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Agenda</label>
                            <input type="text" name="agenda" class="form-control" placeholder="Agenda" value="<?= $edit->agenda ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Barang</label>
                            <select name="idBarang" class="select2" required style="width: 100%">
                                <?php
                                $this->db->where('id', $edit->idBarang);
                                foreach ($this->m_model->get_desc('tb_barang')->result() as $uRg) { ?>
                                    <option value="<?= $uRg->id ?>"><?= $uRg->nama ?></option>
                                <?php } ?>
                                <option value="" disabled>-- Pilih Barang --</option>
                                <?php foreach ($barang->result() as $vBr) { ?>
                                    <option value="<?= $vBr->id ?>"><?= $vBr->nama ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Surat</label>
                            <input type="text" name="surat" class="form-control" placeholder="YA / TIDAK ADA" value="<?= $edit->surat ?>" required>
                            <select type="text" name="surat" class="select2" style="width: 100%" value="<?= $edit->surat ?>" required>
                                <option value="">-- Pilih Ada / Tidak Ada --</option>
                                <option value="Ada">Ada</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>File</label>
                            <input type="file" name="file" class="form-control" value="<?= $edit->file ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger">
                            <div class="fa fa-trash"></div> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <div class="fa fa-save"></div> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Modal Respon Data -->
<?php foreach ($booking_kegiatan->result() as $respon) { ?>
    <div class="modal fade" id="responData<?= $respon->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Respon <?= $title; ?></h4>
                </div>
                <form action="<?= base_url('admin/booking_kegiatan/respon/') . $respon->id ?>" method="POST">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="" disables selected> -- Pilih Status -- </option>
                                <option value="Diterima">Diterima</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger">
                            <div class="fa fa-trash"></div> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <div class="fa fa-save"></div> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>