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
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-maroon">
                    <div class="inner">
                        <h3>
                            <?php
                            echo $this->db->query('SELECT id FROM tb_ruangan')->num_rows();
                            ?>
                        </h3>

                        <p>Total Ruangan</p>
                    </div>
                    <div class="icon">
                        <div class="fa fa-windows"></div>
                    </div>
                    <?php if ($this->session->userdata('level') == 'Administrator') { ?>
                        <a href="<?= base_url('admin/ruangan') ?>" class="small-box-footer">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php
                            echo $this->db->query('SELECT id FROM tb_barang')->num_rows();
                            ?>
                        </h3>

                        <p>Total Barang</p>
                    </div>
                    <div class="icon">
                        <div class="fa fa-shopping-cart"></div>
                    </div>
                    <?php if ($this->session->userdata('level') == 'Administrator') { ?>
                        <a href="<?= base_url('admin/barang') ?>" class="small-box-footer">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    <?php } ?>
                </div>
            </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-bar-chart-o"></i>

                        <h3 class="box-title">Grafik Penggunaan (<?= date('Y') ?>)</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div id="bar-chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>