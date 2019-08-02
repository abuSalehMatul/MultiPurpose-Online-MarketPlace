@extends('backend.layouts.master')

@section('content')
                        
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <table class="table" id="table_m">

                </table>
            </div>
        </div>
    </div>

        <script>
        $(function() {
            $('#table_m').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('chore_panel_ajax') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'chore_id', name: 'chore_id' },
                    { data: 'price', name: 'price' },
                    { data: 'user_id', name: 'user_id' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'status', name: 'status' },
                ]
            });
        })
</script>
@endsection    