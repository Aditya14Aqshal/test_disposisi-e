<main>
    <div class="container-fluid">
        <h1 class="mt-4"></h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumbitem"><a href="<?php echo site_url('admin/user') ?>">user</a></li>
            <li class="breadcrumb-item active"><?php echo $title ?></li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <a href="<?php echo site_url('admin/user/add') ?>"><i class="fas fa-plus"></i> Add New</a>
            </div>
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered tablehover" id="tabelkelas" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($user as $userdata) {
                                echo "<tr>
                                    <td>$no</td>
                                    <td>$userdata->username</td>
                                    <td>$userdata->email</td>
                                    <td>$userdata->phone</td>
                                    <td>$userdata->role</td>
                                    <td>
                                        <div>
                                            <a href=".base_url('admin/user/getedit/' . $userdata->id)." class='btn btn-sm btn-info'><i class='fas fa-edit'></i> Edit</a>
                                            <a href=".base_url('admin/user/delete/' . $userdata->id)." class='btn btn-sm btn-danger' onclick='return confirm(\"Ingin mengapus data user ini?\");'><i class='fas fa-trash'></i> Hapus</a>
                                        </div>
                                    </td>
                                </tr>";
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div style="height: 100vh"></div>
    </div>
</main>
