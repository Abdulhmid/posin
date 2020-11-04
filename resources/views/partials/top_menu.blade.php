<?php 
    $segment = Request::segment(1); 
    $segment2 = Request::segment(2); 
?>
<style type="text/css">
    a{
        background-color: none;
    }
    .active-clss{
        background-color: #3F4652;
    }
</style>
<nav class="navbar navbar-default navbar-fixhed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navissgation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="logo none" href="/home" style="font-weight: bold;color: #05C5CD;font-size: 36px;">
                {!!env('TITLE')!!}
                <!-- <img src="{!!url('')!!}/images/logo.png" alt="Coaster CMS"/> -->
            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="#">
                        <?=date('l, d F Y')?>
                    </a>
                </li>
                <li style="display:none;">
                    <a href="{!!url('/setting')!!}" class="menu-top">
                        <i class="fa fa-cog"></i> Penjualan Hari Ini
                    </a>
                </li>
                <li>
                    <a href="{!!url('/me')!!}" class="menu-top">
                        <i class="fa fa-lock"></i> Akun Saya
                    </a>
                </li>
                <li style="display:none;">
                    <a href="{!!url('/settings')!!}" class="menu-top">
                        <i class="fa fa-cog"></i> Pengaturan
                    </a>
                </li>
                <li>
                    <a href="{!!url('/logout')!!}" class="menu-top" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out"></i> Keluar
                    </a>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</nav>

<nav class="navbar navbar-inverse subnav navbar-fixedg-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" 
                    data-target="#navbar2" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar2" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="dropdrown">
                    <a class="dropdrown-toggle menu-top {!!$segment=='home'?'active-clss':''!!}" href="/home" >
                        <i class="fa fa-shopping-cart "></i> Kasir 
                    </a>
                </li>
                <li class="dropdrown">
                    <a class="dropdrown-toggle menu-top {!!$segment=='return'?'active-clss':''!!}" href="/return" >
                        <i class="fa fa-shopping-cart "></i> Pengembalian 
                    </a>
                </li>
                <li class="dropdrown">
                    <a class="dropdrown-toggle menu-top {!!$segment=='stocks'&&$segment2==""?'active-clss':''!!}" href="/stocks" >
                        <i class="fa fa-file-text-o"></i> Stok Tersedia
                    </a>
                </li>
                <li class="dropdrown">
                    <a class="dropdrown-toggle menu-top {!!$segment2=='broken'?'active-clss':''!!}" href="/stocks/broken" >
                        <i class="fa fa-file-text-o"></i> Barang Rusak
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle menu-top 
                                {!!$segment=='suppliers'||$segment=='categories'||$segment=='products'?'active-clss':''!!}" 
                                data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-file-text-o"></i> Data Master 
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="menu-top" href="{!!url('suppliers')!!}">
                                Suplier
                            </a>
                        </li>
                        <li>
                            <a class="menu-top" href="{!!url('categories')!!}">
                                Kategori
                            </a>
                        </li>
                        <li>
                            <a class="menu-top" href="{!!url('products')!!}">
                                Produk
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle menu-top 
                                {!!$segment=='in'||$segment=='out'?'active-clss':''!!}" 
                                data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-file-text-o"></i> Aktivitas Barang 
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="menu-top" href="/in">
                                Barang Masuk
                            </a>
                        </li>
                        <li>
                            <a class="menu-top" href="/out">
                                Pengembalian Ke Supplier 
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- <li class="dropdrown">
                    <a class="dropdrown-toggle menu-top {!!$segment=='outlets'?'active-clss':''!!}" href="/outlets" >
                        <i class="fa fa-user"></i> Outlets 
                    </a>
                </li> -->
                <!-- Admin Menu -->
                <!-- <li>
                    <a class="menu-top {!!$segment=='clients'?'active-clss':''!!}" href="{!!url('/clients')!!}">
                        <i class="fa fa-cog"></i> Klien
                    </a>
                </li> -->

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle menu-top 
                                {!!$segment=='reports'||$segment=='categories'||$segment=='products'?'active-clss':''!!}" 
                                data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-file-text-o"></i> Laporan 
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="menu-top" href="{!!url('reports')!!}">
                                Laporan Pendapatan
                            </a>
                        </li>
                        <li>
                            <a class="menu-top" href="{!!url('reports/in')!!}">
                                Laporan Barang Masuk
                            </a>
                        </li>
                        <li>
                            <a class="menu-top" href="{!!url('reports/stock')!!}">
                                Laporan Stok
                            </a>
                        </li>
                        <li>
                            <a class="menu-top" href="{!!url('reports/return')!!}">
                                Laporan Pengembalian Barang
                            </a>
                        </li>
                        <li>
                            <a class="menu-top" href="{!!url('reports/buy')!!}">
                                Laporan Barang Beli
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle menu-top 
                        {!!$segment=='roles'||$segment=='users'||$segment=='modules'?'active-clss':''!!}" 
                        data-toggle="dropdown" 
                        aria-expanded="false">
                        <i class="fa fa-file-text-o"></i> Konfigurasi 
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="menu-top" href="{!!url('roles')!!}">
                                Grup
                            </a>
                        </li>
                        <li>
                            <a class="dropdrown-toggle menu-top" href="/users" >
                                <i class="fa fa-user"></i> Pengguna 
                            </a>
                        </li>
                        <li>
                            <a class="menu-top" href="{!!url('modules')!!}">
                                Module
                            </a>
                        </li>
                        <li>
                            <a class="menu-top" href="{!!url('modules/access')!!}">
                                Hak Akses
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><img src="http://spos.tecdiary.my/themes/default/assets/images/english.png" alt="english"></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="menu-top" href="http://spos.tecdiary.my/pos/language/english">
                                <img src="http://spos.tecdiary.my/themes/default/assets/images/english.png" 
                                class="language-img"> &nbsp;&nbsp;English
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</nav>