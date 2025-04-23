@extends('voyager::master')
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            Users Orders Compilation
        </h1>
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12 panel-container">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row" style="margin-bottom: -40px">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-11" style="height: 40px;">
                                        <select id="users" class="form-select" style="width: 100%; height: 40px;" onchange="updateTables()">
                                            <option value="nan" >Select User for Details</option>
                                            @foreach ($users as $user)
                                                <option value="{{$user->id}}">{{$user->name_for_admins}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <br><br>
                        
                        <h4>Product Orders</h4>
                        <hr>
                        <table id="dataTable" class="table table-hover"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr class="table-header">
                                    <th>Id</th>
                                    <th>Shipping Options</th>
                                    <th>Statuses</th>
                                    <th>Created At</th>
                                    <th style="width: 400px;">List products</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 panel-container">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <br><br>
                        <h4>Metal Orders</h4>
                        <hr>
                        <table id="dataTable2" class="table table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr class="table-header">
                                    <th>Id</th>
                                    <th>Metals</th>
                                    <th>Quantity Oz</th>
                                    <th>Price per Oz</th>
                                    <th>Total</th>
                                    <th>Currency</th>
                                    <th>Paid</th>
                                    <th>Created at</th>
                                </tr>
                            </thead>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <link href="{{ URL::to('/') }}/css/admin/custom.css?ver=1.0.0" rel="stylesheet">
@stop

@section('javascript')
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <!-- DataTables -->
    <script>
        $(function() {
            $('#users').select2();
            $('#dataTable').on('click', 'tbody tr', function() {
                let id = $(this).find('.order-id').val();
                let url = "product-orders/" + id; 
                window.open(url, '_blank').focus();
            });
            $('#dataTable2').on('click', 'tbody tr', function() {
                let id = $(this).find('.order-id').val();
                let url = "metal-orders/" + id; 
                window.open(url, '_blank').focus();
            });
        });
        function updateTables(){
            let user_id = document.getElementById('users').value;
            if(user_id === "nan") return;
            $('#dataTable').removeAttr('width').DataTable( {
                destroy: true,
                order: [[0, "asc"]],
                processing: true,
                serverSide: false,
                paging: true,
                scrollX: true,
                autoWidth: false,
                responsive: true,
                columnDefs: [
                    { width: "1%", targets: 0 },
                    { width: "16%", targets: 1 },
                    { width: "16%", targets: 2 },
                    { width: "16%", targets: 3 },
                    { width: "51%", targets: 4 }
                ],
                ajax: {
                    url: "/admin/users-orders-compilation-data-products/"+user_id,
                    type: "GET"
                },                
                columns: [{
                        data: 'po_id',
                        className: "text-center order-row",
                        render: function(data)
                        {
                            return data + '<input class="order-id" type="hidden" value="'+ data +'" />';
                        }
                    }, {
                        data: 'shipping_option',
                        className: "text-center order-row"
                    }, {
                        data: 'shipping_status',
                        className: "text-center order-row"
                    }, {
                        data: 'created_at',
                        className: "text-center order-row"
                    }, {
                        data: 'products',
                        className: "text-center order-row",
                        render: function(data)
                        {
                            let products = [];
                            let div = () => {
                                let a = 0;
                                for (const product in data) {
                                    products[a] = 
                                        '<div class="row">\n\
                                            <div class="col-md-7">'+data[product].name+'</div>\n\
                                            <div class="col-md-3">'+data[product].price+' USD</div>\n\
                                            <div class="col-md-2">'+data[product].quantity+' Oz</div>\n\
                                        </div>';
                                    a++;
                                }
                                return products.join("");
                            };
                            return div;
                        }
                    }
                ]
            });

            $('#dataTable2').DataTable( {
                destroy: true,
                order: [[0, "asc"]],
                processing: true,
                serverSide: false,
                autoWidth: false,
                responsive: true,
                paging: true,
                ajax: {
                    url: "/admin/users-orders-compilation-data-metals/"+user_id,
                    type: "GET"
                },
                columns: [{
                        data: 'id',
                        className: "text-center order-row",
                        render: function(data)
                        {
                            return data + '<input class="order-id" type="hidden" value="'+ data +'" />';
                        }
                    }, {
                        data: 'metal_name',
                        className: "text-center"
                    }, {
                        data: 'quantity',
                        className: "text-center"
                    }, {
                        data: 'price_per_oz',
                        className: "text-center"
                    }, {
                        data: 'priceproduct',
                        className: "text-center"
                    }, {
                        data: 'currency',
                        className: "text-center"
                    }, {
                        data: 'paid',
                        className: "text-center"
                    }, {
                        data: 'created_at',
                        className: "text-center"
                    }
                ]
            } );
        }
    </script>
@stop
