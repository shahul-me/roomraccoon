<!DOCTYPE html>
<html>
    <head>
        <title>Shopping List</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
        <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script>
error = false

function validate()
{
    if (document.productForm.id.value != '' && document.productForm.id.value != '')
        document.productForm.btnsave.disabled = false
    else
        document.productForm.btnsave.disabled = true
}
        </script>
    </head>
    <body>
        <?php require APPROOT . '/views/layout/header.php'; ?>
        <div class="container">
            <h1 align="center">Shopping List</h1>
            <br/>
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        <a class="btn btn-success mb-2" id="new-product" data-toggle="modal">New Product</a>
                    </div>
                </div>
            </div>

            <table class="table table-bordered data-table" >
                <thead>
                    <tr id="">
                        <th width="10%">Id</th>
                        <th width="15%">name</th>
                        <th width="15%">price</th>
                        <th width="10%">checked status</th>
                        <th width="25%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $data_array = json_decode(json_encode($data), true); ?>
                <tbody>
                    <?php
                    foreach ($data_array['products'] as $data1) {
                        $status = "Not Selected";
                        if ($data1['status'] == 1) {
                            $status = "Selected";
                        }
                        ?>
                        <tr>
                            <td><?php echo $data1['id']; ?></td>
                            <td><?php echo $data1['name']; ?></td>
                            <td><?php echo $data1['price']; ?></td>

                            <td><?php echo $status; ?></td>
                            <td>
    <!--                                <a class="btn btn-info" id="show-product" data-toggle="modal" data-id="<?php echo $data1['id']; ?>">Show</a>-->
                                <a class="btn btn-success" id="edit-product" data-toggle="modal" data-id="<?php echo $data1['id']; ?>">Edit </a>
                                <a id="delete-user" data-id="<?php echo $data1['id']; ?>" class="btn btn-danger delete-user">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>

        <!-- Add  product modal -->
        <div class="modal fade" id="crud-modal" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="productCrudModal"></h4>
                    </div>
                    <div class="modal-body">
                        <form name="productForm" action="<?php echo URLROOT; ?>/Products/add" method="POST">
                            <input type="hidden" name="user_id" id="user_id" >
                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Name:</strong>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="name" onchange="validate()" >
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Price:</strong>
                                        <input type="text" name="price" id="price" class="form-control" placeholder="price" onchange="validate()" >
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>product-Checked:</strong>
                                        <!-- <input type="text" name="type" id="type" class="form-control" placeholder="type" onchange="validate()" > -->

                                        <select name="status" id="status">
                                            <option value="1">Marked</option>
                                            <option value="0">Un-Marked</option> onchange="validate()
                                        </select>
                                    </div>
                                </div>


                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>Save</button>
                                    <a href="<?php echo URLROOT; ?>/Products/add" class="btn btn-danger">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit product modal -->
        <div class="modal fade" id="edit-modal" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="productEditModal"></h4>
                    </div>
                    <div class="modal-body">
                        <form name="productEditForm" action="<?php echo URLROOT; ?>/Products/edit" method="POST">
                            <input type="hidden" name="product_id" id="product_id" >
                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Name:</strong>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="name" onchange="validate()" >
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Price:</strong>
                                        <input type="text" name="price" id="price" class="form-control" placeholder="price" onchange="validate()" >
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>product-Checked:</strong>
                                        <!-- <input type="text" name="type" id="type" class="form-control" placeholder="type" onchange="validate()" > -->

                                        <select name="status" id="status">
                                            <option value="1">Marked</option>
                                            <option value="0">Un-Marked</option> onchange="validate()
                                        </select>
                                    </div>
                                </div>


                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>Save</button>
                                    <a href="{{ route('router.index') }}" class="btn btn-danger">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Show user modal -->
        <div class="modal fade" id="crud-modal-show" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="productCrudModal-show"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-2 col-sm-2 col-md-2"></div>
                            <div class="col-xs-10 col-sm-10 col-md-10 ">


                                <table class="table-responsive ">
                                    <tr height="50px"><td><strong>sapid:</strong></td><td id="ssapid"></td></tr>
                                    <tr height="50px"><td><strong>hostname:</strong></td><td id="shostname"></td></tr>
                                    <tr height="50px"><td><strong>loopback:</strong></td><td id="sloopback"></td></tr>
                                    <tr height="50px"><td><strong>mac:</strong></td><td id="smac"></td></tr>
                                    <tr height="50px"><td><strong>type:</strong></td><td id="stype"></td></tr>

                                    <tr><td></td><td style="text-align: right "><a href="{{ route('router.index') }}" class="btn btn-danger">OK</a> </td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>

    <script type="text/javascript">
        $(document).ready(function () {
            /* When click New product button */
            $('#new-product').click(function () {
                $('#btn-save').val("create-user");
                $('#productCrudModal').html("Add New User");
                $('#crud-modal').modal('show');
            });

            /* Edit Product */

            $('body').on('click', '#edit-product', function () {
                var product_id = $(this).data('id');
                $('#product_id').val(product_id);
                $.ajax({
                    type: "POST",
                    url: "<?php echo URLROOT; ?>/Products/edit",
                    data: {
                        product_id: product_id
                    },
                    success: function (data) {
                        $('#productEditModal').html("Edit User");
                        $('#btn-update').val("Update");
                        $('#btn-save').prop('disabled', false);
                        $('#edit-modal').modal('show');
                        $('#user_id').val(data.id);
                        $('#name').val("data.name");
                        $('#price').val(data.price);
                        $('#status').val(data.status);
                    },
                    error: function (e) {
                        console.log(e.responseText);
                    }
                });


            });
            /* Show product */
            $('body').on('click', '#show-product', function () {
                var user_id = $(this).data('id');
                $.get('product/' + product_id, function (data) {

                    $('#name').val("data.name");
                    $('#price').val(data.price);
                    $('#status').val(data.status);

                })
                $('#productCrudModal-show').html("User Details");
                $('#crud-modal-show').modal('show');
            });

            /* Delete product */

            $('body').on('click', '#delete-user', function () {
                var product_id = $(this).data("id");
                confirm("Are You sure want to delete !");
                $.ajax({
                    type: "DELETE",
                    url: "<?php echo URLROOT; ?>/Products/delete",

                    data: {
                        "id": product_id,
                    },
                    success: function (data) {
                      // alert(data);
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            });

        });

    </script>
</html>
