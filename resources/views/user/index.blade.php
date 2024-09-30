@extends('layouts.template')


@section('content')
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <span class="d-inline-block">
                            {{ $title ?? 'Judul' }}
                        </span>
                        <div class="float-right">
                            <button class="btn btn-danger mr-2" data-toggle="modal" data-target="#modalCreate">
                                <i class="fa fa-plus"></i> Tambah
                            </button>
                        </div>
                    </h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">

                            <thead>
                                <tr>
                                    <th> Nama </th>
                                    <th> Email </th>
                                    <th> Username </th>
                                    <th> Role </th>
                                    <th> Status </th>
                                    <th width="100"> Aksi </th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th> Nama </th>
                                    <th> Email </th>
                                    <th> Username </th>
                                    <th> Role </th>
                                    <th> Status </th>
                                    <th width="100"> Aksi </th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('modal')
    <div class="modal fade " id="modalCreate" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="formCreate" enctype="multipart/form-data">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fa fa-plus"></i> Tambah
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        {!! Template::requiredBanner() !!}

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label> Nama {!! Template::required() !!} </label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Nama">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label> Role {!! Template::required() !!}</label>
                                    <select class="form-control" name="role" id="roleCreate" style="width: 100%">
                                        <option value=""></option>
                                        <option value="Admin">Admin</option>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label> Email {!! Template::required() !!}</label>
                                    <input type="email" name="email" class="form-control" placeholder="email@gmail.com">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label> Username {!! Template::required() !!} </label>
                                    <input type="text" name="username" placeholder="Username" class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label> Password {!! Template::required() !!} </label>
                                    <input type="password" name="password" placeholder="******" class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label> Konfirmasi Password {!! Template::required() !!} </label>
                                    <input type="password" name="confirmation" placeholder="Konfirmasi Password Anda" class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Tutup
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-save mr-1"></i> Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUpdate" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="formUpdate">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fa fa-pencil-alt"></i> Edit
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        {!! Template::requiredBanner() !!}
    
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label> Nama {!! Template::required() !!} </label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Nama">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
    
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label> Role {!! Template::required() !!}</label>
                                    <select class="form-control" name="role" style="width: 100%">
                                        <option value=""></option>
                                        <option value="Admin">Admin</option>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
    
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label> Email {!! Template::required() !!}</label>
                                    <input type="email" name="email" class="form-control" placeholder="email@gmail.com">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
    
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label> Username {!! Template::required() !!} </label>
                                    <input type="text" name="username" placeholder="Username" class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Tutup
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-save mr-1"></i> Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {

            const $modalCreate = $('#modalCreate');
            const $modalUpdate = $('#modalUpdate');
            const $formCreate = $('#formCreate');
            const $formUpdate = $('#formUpdate');
            const $formCreateSubmitBtn = $formCreate.find(`[type="submit"]`).ladda();
            const $formUpdateSubmitBtn = $formUpdate.find(`[type="submit"]`).ladda();

            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('user') }}"
                },
                columns: [{
                        data: 'name',
                        name: "name",
                    },
                    {
                        data: 'email',
                        name: "email",
                    },
                    {
                        data: 'username',
                        name: "username",
                    },
                    {
                        data: 'role',
                        name: "role",
                    },
                    {
                        data: 'active_at',
                        name: "active_at",
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    },
                ],
                drawCallback: settings => {
                    renderedEvent()
                }
            })

            const reloadDT = () => {
                $('#dataTable').DataTable().ajax.reload();
            }

            $formCreate.find(`[id="roleCreate"]`).select2({
                dropdownParent: $modalCreate,
                placeholder: '-- Pilih Role --',
                allowClear: true
            })
            
            $formUpdate.find(`[name="role"]`).select2({
                dropdownParent: $modalUpdate,
                placeholder: '-- Pilih Role --',
                allowClear: true
            })

            const clearFormCreate = () => {
                $formCreate[0].reset();
            }
            
            const formSubmit = ($modal, $form, $submit, $href, $method, $addedAction = null) => {
                $form.off('submit')
                $form.on('submit', function(e) {
                    e.preventDefault();
                    clearInvalid();

                    let formData = $(this).serialize();
                    $submit.ladda('start');

                    ajaxSetup();
                    $.ajax({
                        url: $href,
                        method: $method,
                        data: formData,
                        dataType: 'json',
                    }).done(response => {
                        let {
                            message
                        } = response;
                        successNotification('Berhasil', message);
                        reloadDT();
                        clearFormCreate();
                        $submit.ladda('stop');
                        $modal.modal('hide');
                    }).fail(error => {
                        $submit.ladda('stop');
                        ajaxErrorHandling(error, $form);
                    })
                })
            }

            const renderedEvent = () => {
                $.each($('.delete'), (i, deleteBtn) => {
                    $(deleteBtn).off('click')
                    $(deleteBtn).on('click', function() {
                        let {
                            deleteMessage,
                            deleteHref
                        } = $(this).data();
                        confirmation(deleteMessage, function() {
                            ajaxSetup()
                                    $.ajax({
                                        url: deleteHref,
                                        method: 'delete',
                                        dataType: 'json'
                                    })
                                    .done(response => {
                                        let {
                                            message
                                        } = response
                                        successNotification('Berhasil', message)
                                        reloadDT();
                                    })
                                    .fail(error => {
                                        ajaxErrorHandling(error);
                                    })
                        })
                    })
                })

                $.each($('.edit'), (i, editBtn) => {
                    $(editBtn).off('click')
                    $(editBtn).on('click', function() {
                        let {
                            editHref,
                            getHref
                        } = $(this).data();
                        $.get({
                                url: getHref,
                                dataType: 'json'
                            })
                            .done(response => {
                                let {
                                    user
                                } = response;
                                clearInvalid();
                                $modalUpdate.modal('show')
                                $formUpdate.attr('action', editHref)
                                $formUpdate.find(`[name="name"]`).val(user.name).trigger('change')
                                $formUpdate.find(`[name="role"]`).val(user.role).trigger('change')
                                $formUpdate.find(`[name="email"]`).val(user.email).trigger('change')
                                $formUpdate.find(`[name="username"]`).val(user.username).trigger('change')

                                formSubmit(
                                    $modalUpdate,
                                    $formUpdate,
                                    $formUpdateSubmitBtn,
                                    editHref,
                                    'put'
                                );
                            })
                            .fail(error => {
                                ajaxErrorHandling(error);
                            })
                        })
                })
            }

            formSubmit(
                $modalCreate,
                $formCreate,
                $formCreateSubmitBtn,
                `{{ route('user.store') }}`,
                'post',
                () => {
                    clearFormCreate()
                }
            )
        })
    </script>
@endsection