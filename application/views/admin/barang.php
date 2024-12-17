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
                </div>
            <?php } ?>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="dataTable">
                        <thead>
                            <tr>
                                <th width="10px">#</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Stock</th>
                                <th>Jumlah Booking</th>
                                <th>Terdaftar</th>
                                <?php if ($this->session->userdata('level') == 'Administrator') {  ?>
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($barang->result_array() as $row) {
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['kode'] ?></td>
                                    <td><?= $row['nama'] ?></td>
                                    <td><?= $row['stock'] ?></td>
                                    <td>
                                        <?php
                                        $this->db->where('idBarang', $row['id']);
                                        $this->db->where('status', "Diterima");
                                        $count = $this->m_model->get_desc('tb_booking_barang')->num_rows();
                                        $this->db->where('idBarang2', $row['id']);
                                        $this->db->where('status', "Diterima");
                                        $count2 = $this->m_model->get_desc('tb_booking_barang')->num_rows();
                                        $this->db->where('idBarang', $row['id']);
                                        $this->db->where('status', "Diterima");
                                        $count1 = $this->m_model->get_desc('tb_booking')->num_rows();
                                        echo $count + $count1 + $count2;
                                        ?> Booking
                                    </td>
                                    <td><?= date('d F Y H:i:s', strtotime($row['terdaftar'])) ?></td>
                                    <td>

                                        <?php if ($this->session->userdata('level') == 'Administrator') {  ?>
                                            <a href="<?= base_url('admin/barang/detail_barang/') . $row['id'] ?>" class="btn btn-primary btn-xs">
                                                <div class="fa fa-eye"></div> Detail
                                            </a>
                                            <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editData<?= $row['id'] ?>">
                                                <div class="fa fa-edit"></div> Edit
                                            </button>
                                            <a href="<?= base_url('admin/barang/delete/') . $row['id'] ?>" class="btn btn-danger btn-xs tombol-yakin" data-isidata="Account tidak bisa dipulihkan setelah dihapus">
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
            <form action="<?= base_url('admin/barang/insert') ?>" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode</label>
                        <input type="text" name="kode" class="form-control" placeholder="Kode" required>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama" required>
                    </div>
                    <div class="form-group">
                        <label>Stock</label>
                        <input type="text" name="stock" class="form-control" placeholder="Stock" required>
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
<?php foreach ($barang->result() as $edit) { ?>
    <div class="modal fade" id="editData<?= $edit->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit <?= $title; ?></h4>
                </div>
                <form action="<?= base_url('admin/barang/update/') . $edit->id ?>" method="POST">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" name="kode" class="form-control" placeholder="Kode" value="<?= $edit->kode ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama" value="<?= $edit->nama ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Stock</label>
                            <input type="text" name="stock" class="form-control" placeholder="Stock" value="<?= $edit->stock ?>" required>
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