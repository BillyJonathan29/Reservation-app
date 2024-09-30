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
                        <button class="btn btn-success mr-2" data-toggle="modal" data-target="#modalImport">
                            <i class="fa fa-upload"></i> Import
                        </button>
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
                                <th width="150" > Nomor Ruangan </th>
                                <th width="200"> Nama Ruangan </th>
                                <th width="150"> Nomor Lantai </th>
                                <th width="200"> Fasilitas </th>
                                <th width="100"> Aksi </th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th width="150" > Nomor Ruangan </th>
                                <th width="200"> Nama Ruangan </th>
                                <th width="150"> Nomor Lantai </th>
                                <th width="200"> Fasilitas </th>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formCreate">

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
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label> Nomor Ruangan {!! Template::required() !!} </label>
                                <input type="text" name="room_number" class="form-control" placeholder="Nomor Ruangan">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label> Nama Ruangan {!! Template::required() !!} </label>
                                <input type="text" name="room_name" class="form-control" placeholder="Nama Ruangan">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label> Nomor Lantai {!! Template::required() !!} </label>
                                <input type="text" name="floor_number" class="form-control" placeholder="Nomor Lantai">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        @foreach ($facilitys as $key=> $f)
                        <div class="col-lg-3">
                            <div class="form-check">
                                <label>{{ $f->facility_name }}</label><br/>
                                <label class="form-radio-label">
                                    <input class="form-radio-input" type="radio" name="id_facility[{{ $key }}]" value="{{ $f->id }}" {{ $f->available_on_all_rooms == 'Ya' ? 'checked' : ''  }}>
                                    <span class="form-radio-sign">Ya</span>
                                </label>
                                <label class="form-radio-label">
                                    <input class="form-radio-input" type="radio" name="id_facility[{{ $key }}]" value="" {{ $f->available_on_all_rooms == 'Tidak' ? 'checked' : ''  }}>
                                    <span class="form-radio-sign">Tidak</span>
                                </label>
                            </div>
                        </div>
                        @endforeach
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
                        <i class="fa fa-plus"></i> Tambah
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    {!! Template::requiredBanner() !!}

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label> Nomor Ruangan {!! Template::required() !!} </label>
                                <input type="text" name="room_number" class="form-control" placeholder="Nomor Ruangan">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label> Nama Ruangan {!! Template::required() !!} </label>
                                <input type="text" name="room_name" class="form-control" placeholder="Nama Ruangan">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label> Nomor Lantai {!! Template::required() !!} </label>
                                <input type="text" name="floor_number" class="form-control" placeholder="Nomor Lantai">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        
                        @foreach ($facilitys as $key=> $f)
                        <div class="col-lg-3">
                            <div class="form-check">
                                <label>{{ $f->facility_name }}</label><br/>
                                <label class="form-radio-label">
                                    <input class="form-radio-input" type="radio" name="id_facility[{{ $key }}]" value="{{ $f->id }}" >
                                    <span class="form-radio-sign">Ya</span>
                                </label>
                                <label class="form-radio-label">
                                    <input class="form-radio-input" type="radio" name="id_facility[{{ $key }}]" value="">
                                    <span class="form-radio-sign">Tidak</span>
                                </label>
                            </div>
                        </div>
                        @endforeach
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

<div class="modal fade" id="modalImport" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formImport">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-upload"></i> Import
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="p-1">
                        <p class="mb-2"> Catatan : </p>
                        <ul class="pl-4">
                            <li> Import wajib menggunakan template yg kita sediakan. </li>
                            <li> Download template dengan <a
                                href="{{ route('import_templates', 'Template_room.xlsx') }}" download> Klik
                                Disini </a>. </li>
                            <li> Contoh Pengisian Data <a
                                href="{{ route('import_templates', 'Template_contoh_pengisian.xlsx') }}" download> Klik
                                Disini </a>. </li>
                            <li> Kolom dengan background merah wajib diisi. </li>
                        </ul>
                    </div>


                    {!! Template::requiredBanner() !!}

                    <div class="form-group">
                        <label> File {!! Template::required() !!} </label>
                        <input type="file" name="file_excel" class="form-control">
                        <span class="invalid-feedback"></span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Tutup
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload mr-1"></i> Import
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
                    url: "{{ route('room') }}"
                },
                columns: [{
                        data: 'room_number',
                        name: "room_number",
                    },
                    {
                        data: 'room_name',
                        name: "room_name",
                    },
                    {
                        data: 'floor_number',
                        name: "floor_number",
                    },
                    {
                        data: 'room_pacilities',
                        name: 'room_pacilities'
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

            const clearFormCreate = () => {
                $formCreate[0].reset();
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
                               let { message } = response
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
                               let { room } = response;
                               clearInvalid();
                               $modalUpdate.modal('show')
                               $formUpdate.attr('action', editHref)
                               $formUpdate.find(`[name="room_number"]`).val(room
                                   .room_number);
                               $formUpdate.find(`[name="room_name"]`).val(room.room_name);
                               $formUpdate
                                   .find(`[name="floor_number"]`)
                                   .val(room.floor_number);
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

            formSubmit(
                $modalCreate,
                $formCreate,
                $formCreateSubmitBtn,
                `{{ route('room.store') }}`,
                'post',
                () => {
                    clearFormCreate()
                }
            )

            let $importForm = $('#formImport');
            let $importSubmitBtn = $importForm.find(`[type="submit"]`).ladda()

            $importForm.on('submit', function(e) {
                    e.preventDefault();
                    clearInvalid();

                    let formData = new FormData(this);
                    $importSubmitBtn.ladda('start');

                    ajaxSetup();
                    $.ajax({
                            url: "{{ route('room.import') }}",
                            method: 'post',
                            data: formData,
                            dataType: 'json',
                            processData: false,
                            contentType: false,
                        })
                        .done(response => {
                            $importSubmitBtn.ladda('stop')
                            ajaxSuccessHandling(response)
                            $importForm[0].reset();
                            reloadDT()
                            $('#modalImport').modal('hide')
                        })
                        .fail(error => {
                            $importSubmitBtn.ladda('stop')
                            ajaxErrorHandling(error, $importForm)
                        })
            })


        })
</script>
@endsection