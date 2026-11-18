@extends('layouts.app')

@section('title', 'Catat Pergerakan Stok')

@section('content')
<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Catat Pergerakan Stok</h4>
            <p class="text-muted mb-0">
                Catat penambahan atau pengurangan stok bahan baku.
            </p>
        </div>

        <a href="{{ route('stock-movements.index') }}"
           class="btn btn-outline-secondary rounded-3">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="row">
        <div class="col-xl-8 col-lg-10">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                             style="width: 48px; height: 48px; background: #e8f3ed;">
                            <i class="bi bi-arrow-left-right fs-4"
                               style="color: #1D604B;"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Informasi Pergerakan Stok</h5>
                            <small class="text-muted">
                                Lengkapi informasi berikut dengan benar.
                            </small>
                        </div>
                    </div>

                    @if($ingredients->isEmpty())
                        <div class="alert alert-warning border-0 rounded-3">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Belum ada bahan baku. Tambahkan bahan baku terlebih dahulu.
                        </div>

                        <a href="{{ route('ingredients.create') }}"
                           class="btn btn-success rounded-3">
                            <i class="bi bi-plus-lg me-1"></i>
                            Tambah Bahan Baku
                        </a>
                    @else

                        <form action="{{ route('stock-movements.store') }}" method="POST">
                            @csrf

                            {{-- Bahan Baku --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Pilih Bahan Baku
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="ingredient_id"
                                        class="form-select rounded-3 @error('ingredient_id') is-invalid @enderror">
                                    <option value="">-- Pilih Bahan Baku --</option>

                                    @foreach($ingredients as $ingredient)
                                        <option value="{{ $ingredient->id }}"
                                            {{ old('ingredient_id') == $ingredient->id ? 'selected' : '' }}>
                                            {{ $ingredient->name }}
                                            (Stok: {{ $ingredient->stock }} {{ $ingredient->unit }})
                                        </option>
                                    @endforeach
                                </select>

                                @error('ingredient_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jenis Pergerakan --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Jenis Pergerakan
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="type"
                                        class="form-select rounded-3 @error('type') is-invalid @enderror">
                                    <option value="">-- Pilih Jenis Pergerakan --</option>
                                    <option value="in" {{ old('type') === 'in' ? 'selected' : '' }}>
                                        Stok Masuk
                                    </option>
                                    <option value="out" {{ old('type') === 'out' ? 'selected' : '' }}>
                                        Stok Keluar
                                    </option>
                                </select>

                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jumlah --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Jumlah
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="number"
                                       name="quantity"
                                       step="0.01"
                                       min="0.01"
                                       class="form-control rounded-3 @error('quantity') is-invalid @enderror"
                                       value="{{ old('quantity') }}"
                                       placeholder="Masukkan jumlah stok">

                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <small class="text-muted">
                                    Masukkan jumlah sesuai satuan bahan baku.
                                </small>
                            </div>

                            {{-- Keterangan --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Keterangan
                                </label>

                                <textarea name="description"
                                          rows="4"
                                          class="form-control rounded-3 @error('description') is-invalid @enderror"
                                          placeholder="Contoh: Pembelian bahan baku atau bahan rusak">{{ old('description') }}</textarea>

                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Actions --}}
                            <div class="d-flex flex-wrap justify-content-end gap-2 pt-3 border-top">
                                <a href="{{ route('stock-movements.index') }}"
                                   class="btn btn-light border rounded-3 px-4">
                                    Batal
                                </a>

                                <button type="submit"
                                        class="btn btn-success rounded-3 px-4">
                                    <i class="bi bi-save me-1"></i>
                                    Simpan Pergerakan Stok
                                </button>
                            </div>

                        </form>
                    @endif

                </div>
            </div>

            {{-- Information --}}
            <div class="alert border-0 rounded-3 mt-4"
                 style="background: #eaf3ee; color: #24533f;">
                <div class="d-flex gap-2">
                    <i class="bi bi-info-circle-fill mt-1"></i>
                    <div>
                        <strong>Informasi</strong>
                        <p class="mb-0 small">
                            Stok masuk akan menambah jumlah persediaan,
                            sedangkan stok keluar akan mengurangi jumlah persediaan.
                            Pastikan jumlah yang dimasukkan sudah benar.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
