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
            <?php if ($this->session->userdata('level') == 'Administrator') { ?>
                <div class="box-header">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#tambahData">
                        <div class="fa fa-plus"></div> Tambah Data
                    </button>

                    <!--<a class="btn btn-danger" href="<?php echo base_url('admin/kegiatan/cetakpdf') ?>"><i class="fa fa-print"></i> Print to PDF</a>-->
                    <a class="btn btn-danger" href="<?php echo base_url('admin/kegiatan/excel') ?>"><i class="fa fa-print"></i> Print to Excel</a>
                </div>
        </div>
    <?php } ?>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="dataTable">
                <thead>
                    <tr>
                        <th width="10px">No</th>
                        <th>Kode</th>
                        <th>Nama gue</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Tempat</th>
                        <th>Pegawai</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($kegiatan->result_array() as $row) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['kode'] ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= date('d F Y', strtotime($row['tanggal'])) ?></td>
                            <td><?= $row['waktu'] ?></td>
                            <td><?= $row['tempat'] ?></td>
                            <td><?= $row['pegawai'] ?></td>
                            <td><?= date('d F Y H:i:s', strtotime($row['terdaftar'])) ?></td>
                            <td>
                                <?php if ($this->session->userdata('level') == 'Administrator') {  ?>
                                    <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editData<?= $row['id'] ?>">
                                        <div class="fa fa-edit"></div> Edit
                                    </button>
                                    <a href="<?= base_url('admin/kegiatan/delete/') . $row['id'] ?>" class="btn btn-danger btn-xs tombol-yakin" data-isidata="Account tidak bisa dipulihkan setelah dihapus">
                                        <div class="fa fa-trash"></div> Delete
                                    </a>
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
            <form action="<?= base_url('admin/kegiatan/insert') ?>" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode</label>
                        <input type="text" name="kode" class="form-control" placeholder="Kode" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Kegiatan</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Waktu Kegiatan</label>
                        <input type="text" name="waktu" class="form-control" placeholder="Waktu Kegiatan" required>
                    </div>
                    <div class="form-group">
                        <label>Tempat Kegiatan</label>
                        <input type="text" name="tempat" class="form-control" placeholder="Tempat Kegiatan" required>
                    </div>
                    <div class="form-group">
                        <label>Pegawai</label>
                        <input type="text" name="pegawai" class="form-control" placeholder="Pegawai" required>
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
</div>

<!-- Modal Edit Data -->
<?php foreach ($kegiatan->result() as $edit) { ?>
    <div class="modal fade" id="editData<?= $edit->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit <?= $title; ?></h4>
                </div>
                <form action="<?= base_url('admin/kegiatan/update/') . $edit->id ?>" method="POST">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" name="kode" class="form-control" placeholder="Kode" value="<?= $edit->kode ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Kegiatan</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama" value="<?= $edit->nama ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="<?= $edit->tanggal ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Waktu Kegiatan</label>
                            <input type="text" name="waktu" class="form-control" placeholder="Waktu Kegiatan" value="<?= $edit->waktu ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Tempat Kegiatan</label>
                            <input type="text" name="tempat" class="form-control" placeholder="Tempat Kegiatan" value="<?= $edit->tempat ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Pegawai</label>
                            <input type="text" name="pegawai" class="form-control" placeholder="Pegawai" value="<?= $edit->pegawai ?>" required>
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