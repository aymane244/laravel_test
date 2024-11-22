@extends('layouts.app')
@section('content')
    <h1 class="text-center my-5">Products</h1>
    <div class="container">
        <div class="row justify-content-center bg-white shadow p-4">
            <form action="" id="insert">
                <div class="col-md-10">
                    <h5 class="text-center">Insert products</h5>
                    <div class=" mb-3">
                        <label for="product">Product name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text" id="product"><i class="fa-solid fa-bag-shopping"></i></span>
                            <input type="text" class="form-control name" placeholder="Product" aria-label="Product" aria-describedby="name" id="name">
                        </div>
                        <span class="name text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="product">Quantity <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text" id="quantity"><i class="fa-solid fa-arrow-down-wide-short"></i></span>
                            <input type="number" min="0" class="form-control quantity" placeholder="Quantity" aria-label="quantity" aria-describedby="quantity" id="quantity">
                        </div>
                        <span class="quantity text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="product">Price <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text" id="price"><i class="fa-solid fa-money-bill"></i></span>
                            <input type="number" min="0" step="any" class="form-control price" placeholder="Price" aria-label="price" aria-describedby="price" id="price">
                        </div>
                        <span class="price text-danger"></span>
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <div class="table-responsive my-5">
            <table id="products_table" class="table table-striped border w-100">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Product name</th>
                        <th class="text-center">Quantity Per Stock</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Edit</th>
                    </tr>
                </thead>
                <tbody id="products_body"></tbody>
            </table>
        </div>
        @include("products.modal")
    </div>
    <script>
        $(document).ready(function(){
            $('#products_table').DataTable({
                "responsive": true,
            });

            $('#insert').on('submit', function(e){
                e.preventDefault(); 
                $(".is-invalid").removeClass("is-invalid");
                $("span.text-danger").html("");
                const name = $('.name').val();
                const quantity = $('.quantity').val();
                const price = $('.price').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/store',
                    type: 'POST',
                    data:{
                        name: name,
                        quantity: quantity,
                        price: price,
                    },
                    success: function(response){
                        if(response.errors){
                            $.each(response.errors, function(field, messages){
                                $("." + field).addClass("is-invalid");
                                $("." + field).html(messages[0]);
                            });
                        }else{
                            Swal.fire({
                                icon: 'success',
                                html: response.message
                            }).then((result) =>{
                                $.ajax({
                                    url: `/products`,
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(response){
                                        $("#products_body").html("");
                                        let total_sum = 0;
                                        let code = "";

                                        $.each(response.products, function(key, product){
                                            let total = parseInt(product.quantity_stock, 10) * parseFloat(product.unit_price, 10);
                                            total_sum +=total;
                                            code +=`
                                            <tr>
                                                <td class="align-column">${key + 1}</td>
                                                <td class="align-column">${product.name}</td>
                                                <td class="align-column">${product.quantity_stock}</td>
                                                <td class="align-column">${product.unit_price}</td>
                                                <td class="align-column">${total}</td>
                                                <td style="height:40px" class="align-column">
                                                    <i class="fa-solid fa-edit text-success fs-5 pointer" data-bs-toggle="modal" data-bs-target="#editModal" data-id="${product.id}"></i>
                                                </td>
                                            </tr>`;
                                        });

                                        code +=`
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="fw-bold">Grand Total</td>
                                            <td class="text-center fw-bold">${total_sum}</td>
                                            <td></td>
                                            <td></td>
                                        </tr>`;

                                        $("#products_body").append(code)
                                    },
                                    error: function(error){
                                        console.error(error);
                                        alert('An error occurred. Please try again.');
                                    }
                                });
                            });

                            $('#insert')[0].reset();
                        }
                    },
                    error: function(error){
                        console.error(error);
                        alert('An error occurred. Please try again.');
                    }
                });
            });

            let id = "";

            $(document).on('show.bs.modal', '#editModal', function(event){
                let button = $(event.relatedTarget);
                id = button.data('id');
                
                $.ajax({
                    url: `/edit/${id}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response){
                        $('#editModalLabel').html("Update "+ response.product.name);
                        $('#name_update').val(response.product.name);
                        $('#quantity_update').val(response.product.quantity_stock);
                        $('#price_update').val(response.product.unit_price);
                    },
                    error: function(error){
                        console.error(error);
                        alert('An error occurred. Please try again.');
                    }
                });
            });

            $(document).on('click', "#update_product", function(){
                let name = $('.name_update').val();
                let quantity = $('.quantity_update').val();
                let price = $('.price_update').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('update') }}",
                    type: 'POST',
                    data:{
                        name: name,
                        quantity: quantity,
                        price: price,
                        id: id,
                    },
                    success: function(response){
                        if(response.errors){
                            $.each(response.errors, function(field, messages){
                                $("." + field).addClass("is-invalid");
                                $("." + field).html(messages[0]);
                            });
                        }else{
                            Swal.fire({
                                icon: 'success',
                                html: response.message
                            }).then((result) =>{
                                if(result.isConfirmed){
                                    window.location.href = '/';
                                }
                            });
                        }
                    },
                    error: function(error){
                        console.error(error);
                        alert('An error occurred. Please try again.');
                    }
                });
            })
        });
    </script>
@endsection