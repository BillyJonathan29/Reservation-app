@extends('layouts.template')

@section('content')
<div class="row">

    <div class="col-lg-9">
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
                                <th> Fasilitas </th>
                                <th> Ikon </th>
                                <th> Tersedia Di Semua Ruangan </th>
                                <th width="100"> Aksi </th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th> Fasilitas </th>
                                <th> Ikon </th>
                                <th> Tersedia Di Semua Ruangan </th>
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
<div class="modal fade" id="modalCreate" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
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
                    <div class="form-group">
                        <label> Fasilitas {!! Template::required() !!} </label>
                        <input type="text" name="facility_name" class="form-control" placeholder="Nama Fasilitas">
                        <span class="invalid-feedback"></span>
                    </div>

                    <div class="form-group">
                        <label> Gambar {!! Template::required() !!} </label>
                        <input type="file" name="file_icon" class="form-control" placeholder="Gambar">
                        <span class="invalid-feedback"></span>
                    </div>

                    <div class="form-group">
                        <label> Tersedia Di Semua Kamar {!! Template::required() !!} </label>
                        <select name="available_on_all_rooms" id="typeCreate" class="form-control" style="width: 100%">
                            <option value=""></option>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                        <span class="invalid-feedback"></span>
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formUpdate" enctype="multipart/form-data">
                @method('PUT')
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
                    <div class="form-group">
                        <label> Fasilitas {!! Template::required() !!} </label>
                        <input type="text" name="facility_name" class="form-control" placeholder="Nama Fasilitas">
                        <span class="invalid-feedback"></span>
                    </div>

                    <div class="form-group">
                        <label> Gambar {!! Template::required() !!} </label>
                        <input type="file" name="file_icon" class="form-control" placeholder="Gambar">
                        <span class="invalid-feedback"></span>
                    </div>

                    <div class="form-group">
                        <label> Tersedia Di Semua Ruangan {!! Template::required() !!} </label>
                        <select name="available_on_all_rooms" id="typeUpdate" class="form-control" style="width: 100%">
                            <option value=""></option>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                        <span class="invalid-feedback"></span>
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
    $(function(){
        const $modalCreate = $('#modalCreate')
        const $modalUpdate = $('#modalUpdate')
        const $formCreate = $('#formCreate')
        const $formUpdate = $('#formUpdate')
        const $formCreateSubmitBtn = $formCreate.find(`[type="submit"]`).ladda()
        const $formUpdateSubmitBtn = $formUpdate.find(`[type="submit"]`).ladda()

        // Update
        $formUpdate.find(`[name="available_on_all_rooms"]`).select2({
            dropdownParent: $modalUpdate,
            placeholder: '-- Tersedia Di Semua Ruangan --',
            allowClear: true
        });

        // Create
        $formCreate.find(`[name="available_on_all_rooms"]`).select2({
            dropdownParent: $modalCreate,
            placeholder: '-- Tersedia Di Semua Ruangan --',
            allowClear: true
        });

       

        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: "{{ route('facilitie') }}"
            },
            columns: [
                {
                    data: 'facility_name',
                    name: 'facility_name'
                },{
                    data: 'file_icon',
                    name: 'file_icon'
                },{
                    data: 'available_on_all_rooms',
                    name: 'available_on_all_rooms'
                },{
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            drawCallback: settings => {
                renderedEvent()
            }
        })


        const reloadDT = () => {
            $('#dataTable').DataTable().ajax.reload()
        }

        const clearFormCreate = () => {
            $formCreate[0].reset()
        }

        const clearFormUpdate = () => {
            $formUpdate[0].reset()
        }

        const renderedEvent = () => {
                $.each($('.delete'), (i, deleteBtn) => {
                    $(deleteBtn).off('click')
                    $(deleteBtn).on('click', function(e) {
                        let {
                            deleteMessage,
                            deleteHref
                        } = $(this).data();
                        confirmation(deleteMessage, function() {
                            ajaxSetup();
                            $.ajax({
                                url: deleteHref,
                                method: 'delete',
                                dataType: 'json'
                            }).done(response => {
                                let {
                                    message
                                } = response;
                                successNotification('Berhasil', message);
                                reloadDT()
                            }).fail(error => {
                                ajaxErrorHandling(error);
                            })
                        })
                    })
                })

                $.each($('.edit'), (i, editBtn) => {
                    $(editBtn).off('click')
                    $(editBtn).on('click', function() {
                        let { editHref,getHref } = $(this).data();
                        $.get({
                                url: getHref,
                                dataType: 'json'
                            })
                            .done(response => {
                                let { facilitie } = response;  
                                clearInvalid();
                                $modalUpdate.modal('show')   
                                $formUpdate.attr('action', editHref)
                                $formUpdate.find(`[name="facility_name"]`).val(facilitie.facility_name).trigger('change')
                                $formUpdate.find(`[name="available_on_all_rooms"]`).val(facilitie.available_on_all_rooms).trigger('change')                              
                                // $formUpdate.find(`[name="file_icon"]`).val(facilitie.file_icon).trigger('change')
                                formSubmit(
                                    $modalUpdate,
                                    $formUpdate,
                                    $formUpdateSubmitBtn,
                                    editHref,
                                    'POST'
                                );
                            })
                            .fail(error => {
                                ajaxErrorHandling(error);
                            })
                    })
                })
        }


        const formSubmit = ($modal, $form, $submit, $href, $method, addedAction = null) => {
            $form.off('submit')
            $form.on('submit', function(e) {
                e.preventDefault();
                clearInvalid();

                let formData = new FormData(this);
                $submit.ladda('start');

                ajaxSetup();
                $.ajax({
                    url: $href,
                    method: $method,
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                })
                .done(response => {
                    let {
                        message
                    } = response;
                    successNotification('Berhasil', message)
                    $submit.ladda('stop');
                    $modal.modal('hide');
                    reloadDT();
                    $formCreate[0].reset();

                    if(addedAction) {
                                addedAction();
                    }
                })
                .fail(error => {
                    $submit.ladda('stop')
                    ajaxErrorHandling(error, $form)
                })
            })
        };



        formSubmit(
        $modalCreate,
        $formCreate,
        $formCreateSubmitBtn,
            `{{ route('facilitie.store') }}`,
            'POST',
            () => {
                clearFormCreate();
            }
        );
                
    })
</script>
@endsection