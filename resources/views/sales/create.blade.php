@extends('layouts.app')

@section('title', 'Kasir')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold mb-1">Kasir</h3>
    <p class="text-muted mb-0">Pilih produk dan proses transaksi pelanggan.</p>
</div>

@if ($errors->any())
    <div class="alert alert-danger rounded-3">
        <strong><i class="bi bi-exclamation-circle me-2"></i>Transaksi gagal:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success rounded-3">
        {{ session('success') }}
    </div>
@endif

<div class="row g-4">
    {{-- KATALOG PRODUK --}}
    <div class="col-xl-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                    <div>
                        <h5 class="fw-bold mb-1">Katalog Produk</h5>
                        <p class="text-muted small mb-0">
                            {{ $products->count() }} produk tersedia
                        </p>
                    </div>

                    <div class="input-group" style="max-width: 260px;">
                        <span class="input-group-text bg-light border-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" id="productSearch"
                               class="form-control bg-light border-0"
                               placeholder="Cari produk...">
                    </div>
                </div>

                @if ($products->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-cup-hot fs-1 text-muted"></i>
                        <h6 class="fw-bold mt-3">Belum ada produk</h6>
                        <p class="text-muted small mb-0">
                            Tambahkan produk terlebih dahulu.
                        </p>
                    </div>
                @else
                    <div class="row g-3" id="productCatalog">
                        @foreach ($products as $product)
                            <div class="col-sm-6 col-lg-4 product-item"
                                 data-name="{{ strtolower($product->name) }}"
                                 data-category="{{ strtolower($product->category->name ?? '') }}">
                                <div class="product-card h-100 border rounded-4 p-3">
                                    <div class="product-icon mb-3">
                                        <i class="bi bi-cup-straw"></i>
                                    </div>

                                    <div class="mb-3">
                                        <span class="badge bg-success-subtle text-success mb-2">
                                            {{ $product->category->name ?? 'Umum' }}
                                        </span>
                                        <h6 class="fw-bold mb-1">
                                            {{ $product->name }}
                                        </h6>
                                        <h6 class="text-success fw-bold mb-0">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </h6>
                                    </div>

                                    <button type="button"
                                            class="btn btn-outline-success w-100 rounded-3 add-product"
                                            data-id="{{ $product->id }}"
                                            data-name="{{ $product->name }}"
                                            data-price="{{ $product->price }}">
                                        <i class="bi bi-plus-lg me-1"></i>
                                        Tambahkan
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div id="noSearchResult" class="text-center text-muted py-5 d-none">
                        Produk tidak ditemukan.
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- KERANJANG --}}
    <div class="col-xl-4">
        <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
            @csrf

            <div class="card border-0 shadow-sm rounded-4 cart-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold mb-1">
                                <i class="bi bi-cart3 me-2 text-success"></i>
                                Keranjang
                            </h5>
                            <p class="text-muted small mb-0">
                                <span id="cartCount">0</span> item dipilih
                            </p>
                        </div>

                        <button type="button" id="clearCart"
                                class="btn btn-sm btn-light text-danger rounded-3">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>

                    <div id="cartItems" class="cart-items">
                        <div id="emptyCart" class="text-center text-muted py-5">
                            <i class="bi bi-cart-x fs-1"></i>
                            <p class="mt-3 mb-0 small">
                                Keranjang masih kosong.
                            </p>
                            <p class="small">Pilih produk untuk memulai transaksi.</p>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-semibold" id="subtotalDisplay">Rp 0</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold">Total Pembayaran</span>
                        <h4 class="fw-bold text-success mb-0" id="totalDisplay">
                            Rp 0
                        </h4>
                    </div>

                    <div class="mb-3">
                        <label for="paidAmount" class="form-label fw-semibold">
                            Uang Dibayar (Rp)
                        </label>
                        <input type="number"
                               name="paid_amount"
                               id="paidAmount"
                               class="form-control form-control-lg rounded-3"
                               min="0"
                               step="1"
                               value="{{ old('paid_amount') }}"
                               placeholder="Masukkan nominal"
                               required>
                    </div>

                    <div class="bg-light rounded-3 p-3 mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Kembalian</span>
                            <h5 class="fw-bold text-success mb-0" id="changeDisplay">
                                Rp 0
                            </h5>
                        </div>
                    </div>

                    <button type="submit" id="checkoutButton"
                            class="btn btn-success btn-lg w-100 rounded-3"
                            disabled>
                        <i class="bi bi-receipt me-2"></i>
                        Proses Transaksi
                    </button>

                    <a href="{{ route('sales.index') }}"
                       class="btn btn-light w-100 rounded-3 mt-2">
                        Lihat Riwayat Transaksi
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .product-card {
        background: #fff;
        transition: all .2s ease;
    }

    .product-card:hover {
        border-color: #1D604B !important;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,.06);
    }

    .product-icon {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eaf3ed;
        color: #1D604B;
        border-radius: 16px;
        font-size: 25px;
    }

    .cart-card {
        position: sticky;
        top: 90px;
    }

    .cart-items {
        max-height: 360px;
        overflow-y: auto;
    }

    .cart-item {
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .quantity-control button {
        width: 28px;
        height: 28px;
        padding: 0;
        border: 1px solid #ddd;
        background: white;
        border-radius: 8px;
    }

    .quantity-control input {
        width: 38px;
        text-align: center;
        border: 0;
        font-weight: 600;
        background: transparent;
    }

    @media (max-width: 1199px) {
        .cart-card {
            position: static;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    const cart = {};

    const cartItems = document.getElementById('cartItems');
    const paidAmount = document.getElementById('paidAmount');
    const checkoutButton = document.getElementById('checkoutButton');

    function rupiah(value) {
        return 'Rp ' + Math.round(value).toLocaleString('id-ID');
    }

    function addProduct(id, name, price) {
        if (cart[id]) {
            cart[id].quantity++;
        } else {
            cart[id] = {
                id: id,
                name: name,
                price: Number(price),
                quantity: 1
            };
        }

        renderCart();
    }

    function changeQuantity(id, amount) {
        if (!cart[id]) return;

        cart[id].quantity += amount;

        if (cart[id].quantity <= 0) {
            delete cart[id];
        }

        renderCart();
    }

    function removeProduct(id) {
        delete cart[id];
        renderCart();
    }

    function renderCart() {
        const products = Object.values(cart);
        let total = 0;
        let count = 0;

        cartItems.innerHTML = '';

        if (products.length === 0) {
            cartItems.innerHTML = `
                <div class="text-center text-muted py-5">
                    <i class="bi bi-cart-x fs-1"></i>
                    <p class="mt-3 mb-0 small">Keranjang masih kosong.</p>
                    <p class="small">Pilih produk untuk memulai transaksi.</p>
                </div>
            `;
        }

        products.forEach((item, index) => {
            const subtotal = item.price * item.quantity;
            total += subtotal;
            count += item.quantity;

            cartItems.insertAdjacentHTML('beforeend', `
                <div class="cart-item">
                    <input type="hidden"
                           name="items[${index}][product_id]"
                           value="${item.id}">

                    <input type="hidden"
                           name="items[${index}][quantity]"
                           value="${item.quantity}">

                    <div class="d-flex justify-content-between gap-2">
                        <div class="flex-grow-1">
                            <div class="fw-semibold small">${escapeHtml(item.name)}</div>
                            <div class="text-muted small">${rupiah(item.price)}</div>

                            <div class="quantity-control mt-2">
                                <button type="button"
                                        onclick="changeQuantity('${item.id}', -1)">
                                    <i class="bi bi-dash"></i>
                                </button>

                                <span class="fw-semibold small">${item.quantity}</span>

                                <button type="button"
                                        onclick="changeQuantity('${item.id}', 1)">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="text-end">
                            <div class="fw-bold small">${rupiah(subtotal)}</div>
                            <button type="button"
                                    class="btn btn-sm text-danger p-0 mt-2"
                                    onclick="removeProduct('${item.id}')">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `);
        });

        document.getElementById('cartCount').textContent = count;
        document.getElementById('subtotalDisplay').textContent = rupiah(total);
        document.getElementById('totalDisplay').textContent = rupiah(total);

        checkoutButton.disabled = products.length === 0;

        calculateChange(total);
    }

    function calculateChange(total) {
        const paid = Number(paidAmount.value) || 0;
        const change = Math.max(0, paid - total);

        document.getElementById('changeDisplay').textContent = rupiah(change);
    }

    function escapeHtml(value) {
        return String(value).replace(/[&<>"']/g, char => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        })[char]);
    }

    document.querySelectorAll('.add-product').forEach(button => {
        button.addEventListener('click', () => {
            addProduct(
                button.dataset.id,
                button.dataset.name,
                button.dataset.price
            );
        });
    });

    paidAmount.addEventListener('input', () => {
        const total = Object.values(cart)
            .reduce((sum, item) => sum + item.price * item.quantity, 0);

        calculateChange(total);
    });

    document.getElementById('clearCart').addEventListener('click', () => {
        Object.keys(cart).forEach(id => delete cart[id]);
        renderCart();
    });

    document.getElementById('productSearch').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        let visible = 0;

        document.querySelectorAll('.product-item').forEach(item => {
            const match = item.dataset.name.includes(keyword)
                || item.dataset.category.includes(keyword);

            item.classList.toggle('d-none', !match);

            if (match) visible++;
        });

        document.getElementById('noSearchResult')
            .classList.toggle('d-none', visible > 0);
    });

    document.getElementById('saleForm').addEventListener('submit', function (event) {
        const products = Object.values(cart);
        const total = products.reduce(
            (sum, item) => sum + item.price * item.quantity, 0
        );

        if (products.length === 0) {
            event.preventDefault();
            alert('Keranjang masih kosong.');
            return;
        }

        if (Number(paidAmount.value) < total) {
            event.preventDefault();
            alert('Uang pembayaran masih kurang.');
            paidAmount.focus();
        }
    });

    renderCart();
</script>
@endpush
