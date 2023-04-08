<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
    <div class="row row-sm" id="users_container" >
        <div class="col-md-12 col-xl-12">
            <table id="users_table" class="table table-bordered">
                <thead>
                <tr>
                    <th>Ref</th>
                    <th>Name</th>
                    <th class="d-none d-xl-table-cell">Username</th>
                    <th class="d-none d-xl-table-cell">Email</th>
                    <th class="d-none d-xl-table-cell">Mobile</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>


    <div class="modal fade js-modal-settings modal-backdrop-transparent" id="user_form_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-right modal-md">
            <div class="modal-content">
                <div class="dropdown-header bg-trans-gradient d-flex justify-content-center align-items-center w-100">
                    <h4 class="m-0 text-center color-white">
                        <span id="form_title"></span>
                        <small class="mb-0 opacity-80" id="form_title_2"></small>
                    </h4>
                    <button type="button" class="close text-white position-absolute pos-top pos-right p-2 m-1 mr-2"
                            data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <form action="" id="user_form"></form>
                </div>
            </div>
        </div>
    </div>


<?= $this->endSection(); ?>