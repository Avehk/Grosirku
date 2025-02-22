<!DOCTYPE html>
<html>

<head>
    @include('home.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style type="text/css">
        .div_center {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .detail-box {
            padding: 15px;
            text-align: center;
        }

        .btn-primary {
            background-color: tomato;
            color: #fff;
            border: 2px solid tomato;
            transition: background-color 0.3s, color 0.3s, transform 0.3s;
        }

        .btn-primary:hover {
            background-color: #fff;
            color: tomato;
            transform: scale(1.05);
        }

        .box {
            background: #f9f9f9;
            padding: 30px;
            margin-bottom: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .box:hover {
            transform: translateY(-10px);
        }

        .heading_container h2 {
            font-size: 2.5rem;
            font-weight: bold;
            color: tomato;
            margin-bottom: 30px;
            text-transform: uppercase;
        }

        .img-box img {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .img-box img:hover {
            transform: scale(1.05);
        }

        .detail-box h6 {
            margin: 10px 0;
            font-size: 1.2rem;
            color: #333;
        }

        .detail-box span {
            color: tomato;
            font-weight: bold;
        }

        .hero_area {
            padding-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="hero_area">
        <!-- header section starts -->
        @include('home.header')
        <!-- end header section -->
    </div>
    <!-- Product Detail -->
    <section class="shop_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center animate__animated animate__fadeInDown">
                <h2>Detail Produk</h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box animate__animated animate__fadeInUp">
                        <div class="div_center">
                            <img width="400" src="/products/{{$data->image}}" alt="">
                        </div>
                        <div class="detail-box">
                            <h6>{{$data->title}}</h6>
                            <h6>Harga
                                <span>Rp{{$data->price}}</span>
                            </h6>
                        </div>
                        <div class="detail-box">
                            <h6>Kategori produk: {{$data->category}}</h6>
                            <h6>Stok tersedia:
                                <span>{{$data->quantity}}</span>
                            </h6>
                        </div>
                        <div class="detail-box">
                            <p>{{$data->description}}</p>
                        </div>
                        <div class="detail-box">
                            <img style="width:20px; height:auto;" src="admincss/img/bagrosir.png" alt="" />
                            <a class="btn btn-primary" href="{{url('add_cart', $data->id)}}">Tambah Keranjang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- info section -->
    @include('home.footer')
</body>

</html>
