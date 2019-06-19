@extends('admin.layout.master')

@section('body')
    <style>

        .videoWrapper iframe {
            width: 100%;
            height: 100%;
        }

    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-title ">
                    <button type="button" class="btn btn-success btn-md pull-right edit_button"
                            data-toggle="modal" data-target="#myModal"
                            data-act="Add New"
                            data-title=""
                            data-link=""
                            data-id="0">
                        <i class="fa fa-plus"></i> Add New
                    </button>
                    <br>

                </div>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" >
                            <thead>
                            <tr>
                                <th style="width: 30%"> Video</th>
                                <th> Title</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($events as $k=>$mac)
                                <tr>
                                    <td>
                                        <div class="videoWrapper">
                                            {!! $mac->link or '-' !!}
                                        </div>
                                    </td>
                                    <td>{{$mac->title}}</td>
                                    <td>
                                        <b class="btn btn-sm btn-{{ $mac->status ==0 ? 'warning' : 'success' }}">{{ $mac->status == 0 ? 'Deactive' : 'Active' }}</b>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-primary btn-sm edit_button"
                                                data-toggle="modal" data-target="#myModal"
                                                data-act="Edit"
                                                data-title="{{$mac->title}}"
                                                data-link="{{$mac->link}}"
                                                data-status="{{$mac->status}}"
                                                data-id="{{$mac->id}}">
                                            <i class="fa fa-edit"></i> EDIT
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$events->links()}}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Edit button -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><b class="abir_act"></b> Live </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form method="post" action="{{route('update.live')}}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <input class="form-control abir_id" type="hidden" name="id">
                            <input class="form-control input-lg abir_title" name="title" placeholder=" Video Title"
                                   required>
                            <br>
                        </div>

                        <div class="form-group">
                            <input class="form-control input-lg abir_link" name="link" placeholder=" Enter Embed Code"
                                   required>
                            <br>
                        </div>
                        
                        
                        <div class="form-group">
                            <select name="status" id="event-status" class="form-control input-lg abir_status" required>
                                <option value="">Status</option>
                                <option value="1">Active</option>
                                <option value="0">DeActive</option>
                            </select>
                            <br>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $(document).on("click", '.edit_button', function (e) {

                var title = $(this).data('title');
                var link = $(this).data('link');
                var status = $(this).data('status');
                var id = $(this).data('id');
                var act = $(this).data('act');

                $(".abir_id").val(id);
                $(".abir_title").val(title);
                $(".abir_link").val(link);
                $(".abir_status").val(status).attr('selected', 'selected');
                $(".abir_act").text(act);

            });
        });
    </script>
@endsection